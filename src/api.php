<?php
$mod = 'api';
include("./includes/common.php");
$action = isset($_REQUEST['action']) ? daddslashes($_REQUEST['action']) : null;

@header('Content-Type: application/json; charset=UTF-8');

switch ($action) {
    case 'send':
        // 检查字段
        $appid = intval($_POST['appid']);
        $appsecret = trim(daddslashes($_POST['appsecret']));
        if (empty($appid)) exit('{"code":-1,"msg":"appid 不能为空"}');
        if (empty($appsecret)) exit('{"code":-1,"msg":"appsecret 不能为空"}');
        // 应用信息
        $app_config = $DB->find('app', 'app_name,app_from_name,smtp_id,status', ['id' => $appid, 'app_secret' => $appsecret]);
        if (!$app_config) exit('{"code":-1,"msg":"应用不存在"}');
        if (intval($app_config['status']) < 1) exit('{"code":-1,"msg":"应用不可用"}');
        if (intval($app_config['smtp_id']) < 1) exit('{"code":-1,"msg":"应用未绑定邮件服务"}');
        // 检查服务信息
        $smtp_config = $DB->find('smtp', '*', ['id' => $app_config['smtp_id']]);
        if (!$smtp_config) exit('{"code":-1,"msg":"邮件服务不存在"}');
        if (intval($smtp_config['status']) < 1) exit('{"code":-1,"msg":"邮件服务不可用"}');
        // 邮件信息
        $to = trim(daddslashes($_POST['to']));
        $to_name = trim(daddslashes($_POST['to_name']));
        $from_name = trim(daddslashes($_POST['from_name']));
        $subject = trim(daddslashes($_POST['subject']));
        $message = trim(daddslashes($_POST['message']));
        if (empty($to)) exit('{"code":-1,"msg":"收件人不能为空"}');
        if (empty($subject)) exit('{"code":-1,"msg":"主题不能为空"}');
        if (empty($message)) exit('{"code":-1,"msg":"内容不能为空"}');

        if (empty($from_name)) {
            // 发信人名称
            if (!empty($app_config['app_from_name'])) {
                $from_name = $app_config['app_from_name'];
            } else {
                // 未设置则取应用名称
                $from_name = $app_config['app_name'];
            }
        }

        // 发送邮件
        $params = array(
            'appid' => $appid,
            'to' => $to,
            'subject' => $subject,
            'message' => $message,
            'to_name' => $to_name,
            'from_name' => $from_name,
        );
        // exit(json_encode(['code' => 0, 'data' => $row]));
        if (send_mail($smtp_config, $params)) {
            exit(json_encode(['code' => 0, 'msg' => '发送成功']));
        } else {
            exit(json_encode(['code' => -1, 'msg' => '发送失败']));
        }
        break;
    default:
        exit('{"code":403}');
        break;
}
