<?php
define('IN_ADMIN', true);
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
// $act=isset($_GET['act'])?daddslashes($_GET['act']):null;
$act = isset($_REQUEST['act']) ? daddslashes($_REQUEST['act']) : null;
if (!checkRefererHost()) exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    case 'info':
        $id = intval($_GET['id']);
        $row = $DB->find('smtp', '*', ['id' => $id]);
        if (!$row) exit('{"code":-1,"msg":"记录不存在"}');
        exit(json_encode(['code' => 0, 'data' => $row]));
        break;
    case 'options':
        $row = $DB->findAll('smtp', 'id,name', ['status' => 1]);
        exit(json_encode(['code' => 0, 'data' => $row]));
        break;
    case 'list':
        $sql = " 1=1";

        $id = intval($_POST['id']);
        $name = trim(daddslashes($_POST['name']));
        $smtp_host = trim(daddslashes($_POST['smtp_host']));
        $smtp_username = trim(daddslashes($_POST['smtp_username']));

        if (!empty($id)) {
            $sql .= " AND `id`='{$id}'";
        }
        if (!empty($name)) {
            $sql .= " AND `name` like '%{$name}%'";
        }
        if (!empty($smtp_host)) {
            $sql .= " AND smtp_host like '%{$smtp_host}%'";
        }
        if (!empty($smtp_username)) {
            $sql .= " AND smtp_username like '%{$smtp_username}%'";
        }

        $offset = intval($_POST['offset']);
        $limit = intval($_POST['limit']);
        $total = $DB->getColumn("SELECT count(*) from pre_smtp WHERE{$sql}");
        $list = $DB->getAll("SELECT * FROM pre_smtp WHERE{$sql} order by id desc limit $offset,$limit");

        exit(json_encode(['total' => $total, 'rows' => $list]));
        break;
    case 'check':
        $id = intval($_POST['id']);
        $to = trim(daddslashes($_POST['to']));
        if (!$id) exit('{"code":-1,"msg":"缺少id"}');
        if (!$to) exit('{"code":-1,"msg":"缺少收件人地址"}');
        $smtp_config = $DB->find('smtp', '*', ['id' => $id]);
        if (!$smtp_config) exit('{"code":-1,"msg":"记录不存在"}');
        $mail_body = array(
            'to' => $to,
            'message' => '当您收到此邮件时，证明 SMTP 已经配置正确，可以进行使用。',
            'subject' => '测试邮件'
        );
        // $from = !empty($smtp_config['smtp_from']) ? $smtp_config['smtp_from'] : $smtp_config['smtp_username'];

        // $record = array(
        //     'appid' => 0,
        //     'smtp_id' => $smtp_config['id'],
        //     'subject' => $mail_body['subject'],
        //     'from' => $from,
        //     'to' => $mail_body['to'],
        //     'body' => $mail_body['message'],
        //     'date' => date('Y-m-d H:i:s')
        // );
        // print_r($config);
        // print_r($record);
        // $res = $DB->insert('record', $record);
        // print_r($res);

        if (send_mail($smtp_config, $mail_body)) {
            exit(json_encode(['code' => 0, 'msg' => '发送成功！']));
        } else {
            exit(json_encode(['code' => -1, 'msg' => '发送失败']));
        }
        break;
    case 'save':
        $name = trim(daddslashes($_POST['name']));
        $type = intval($_POST['type']);
        $id = intval(trim($_POST['id']));
        $smtp_host = trim(daddslashes($_POST['smtp_host']));
        $smtp_port = trim(daddslashes($_POST['smtp_port']));
        $smtp_username = trim(daddslashes($_POST['smtp_username']));
        $smtp_password = trim(daddslashes($_POST['smtp_password']));
        $smtp_from = trim(daddslashes($_POST['smtp_from']));
        $action = trim(daddslashes($_POST['action']));
        if (!$name || !$smtp_host || !$smtp_port || !$smtp_username || !$smtp_password) exit('{"code":-1,"msg":"必填项不能为空"}');
        if ($_POST['action'] == 'add') {
            if ($DB->find('smtp', 'name', ['name' => $name])) exit('{"code":-1,"msg":"名称重复，请勿重复添加"}');
            if ($DB->find('smtp', 'name', ['smtp_username' => $smtp_username])) exit('{"code":-1,"msg":"SMTP账号重复，请勿重复添加"}');

            if (!$DB->insert('smtp', [
                'type' => $type,
                'name' => $name,
                'status' => 1,
                'smtp_host' => $smtp_host,
                'smtp_port' => $smtp_port,
                'smtp_username' => $smtp_username,
                'smtp_password' => $smtp_password,
                'smtp_from' => $smtp_from,
                'addtime' => date("Y-m-d H:i:s")
            ])) exit('{"code":-1,"msg":"添加失败：<br />[' . $DB->error() . ']"}');
            exit('{"code":0,"msg":"添加成功！"}');
        } else {
            if (!$id) exit('{"code":-1,"msg":"ID不能为空"}');
            if ($DB->find('smtp', 'name', "name='{$name}' AND id<>'$id' ", NULL, 1)) exit('{"code":-1,"msg":"名称重复，请勿重复添加"}');
            if ($DB->find('smtp', 'name', "smtp_username='{$smtp_username}' AND id<>'$id' ", NULL, 1)) exit('{"code":-1,"msg":"SMTP账号重复，请勿重复添加"}');

            if (!$DB->update(
                'smtp',
                [
                    'type' => $type,
                    'name' => $name,
                    'smtp_host' => $smtp_host,
                    'smtp_port' => $smtp_port,
                    'smtp_username' => $smtp_username,
                    'smtp_password' => $smtp_password,
                    'smtp_from' => $smtp_from,
                    'updatetime' => date("Y-m-d H:i:s")
                ],
                ['id' => $id]
            )) exit('{"code":-1,"msg":"修改失败：<br />[' . $DB->error() . ']"}');
            exit('{"code":0,"msg":"修改成功！"}');
        }
        break;
    case 'set':
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);
        if (empty($id)) exit('{"code":-1,"msg":"id不能为空"}');
        if (!$DB->update('smtp', ['status' => $status], ['id' => $id])) {
            exit('{"code":-1,"msg":"修改失败[' . $DB->error() . ']"}');
        }
        exit('{"code":0,"msg":"修改成功！"}');
        break;
    case 'del':
        $id = intval($_POST['id']);
        if (!$DB->find('smtp', 'name', ['id' => $id])) exit('{"code":-1,"msg":"不存在！"}');
        if ($DB->delete('smtp', ['id' => $id])) {
            exit('{"code":0,"msg":"删除成功！"}');
        }
        exit('{"code":-1,"msg":"删除失败：<br />[' . $DB->error() . ']"}');
        break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
        break;
}
