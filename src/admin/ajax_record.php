<?php
define('IN_ADMIN', true);
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
// $act=isset($_GET['act'])?daddslashes($_GET['act']):null;
$act = isset($_REQUEST['act']) ? daddslashes($_REQUEST['act']) : 'list';
if (!checkRefererHost()) exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    case 'info':
        $id = intval($_GET['id']);
        $row = $DB->find('record', '*', ['id' => $id]);
        if (!$row) exit('{"code":-1,"msg":"记录不存在"}');
        exit(json_encode(['code' => 0, 'data' => $row]));
        break;
    case 'list':
        $sql = " 1=1";
        $appid = intval($_POST['appid']);
        $smtp_id = intval($_POST['smtp_id']);
        $mail_subject = trim(daddslashes($_POST['mail_subject']));
        $mail_from = trim(daddslashes($_POST['mail_from']));
        $mail_to = trim(daddslashes($_POST['mail_to']));

        if (!empty($appid)) {
            $sql .= " AND `appid`='{$appid}'";
        }
        if (!empty($smtp_id)) {
            $sql .= " AND `smtp_id`='{$smtp_id}'";
        }
        if (!empty($mail_subject)) {
            $sql .= " AND `mail_subject` like '%{$mail_subject}%'";
        }
        if (!empty($mail_from)) {
            $sql .= " AND `mail_from` like '%{$mail_from}%'";
        }
        if (!empty($mail_to)) {
            $sql .= " AND `mail_to` like '%{$mail_to}%'";
        }

        $offset = intval($_POST['offset']);
        $limit = intval($_POST['limit']);
        $total = $DB->count('record', $sql);
        $list = $DB->findAll('record', 'id,appid,smtp_id,mail_subject,mail_from,mail_to,mail_date,status', $sql, 'id desc', "$offset,$limit");

        exit(json_encode(['total' => $total, 'rows' => $list]));
        break;
        // $sql = " A.status=0";
        // $domain = trim($_POST['domain']);
        // $did = intval($_POST['did']);
        // $appid = trim($_POST['appid']);

        // // TODO 删除后就找不到了，此处不能用关联存储，直接存储到表
        // if (!empty($domain)) {
        //     $sql .= " AND B.domain='{$domain}'";
        // } elseif (!empty($did)) {
        //     $sql .= " AND A.did='{$did}'";
        // }
        // if (!empty($appid)) {
        //     $sql .= " AND `appid`='{$appid}'";
        // }
        // $offset = intval($_POST['offset']);
        // $limit = intval($_POST['limit']);
        // $total = $DB->getColumn("SELECT count(A.id) FROM pre_record A JOIN pre_app B ON A.did=B.id WHERE{$sql}");
        // $list = $DB->getAll("SELECT A.*,B.domain FROM pre_record A JOIN pre_app B ON A.did=B.id WHERE{$sql} order by A.id desc limit $offset,$limit");

        // exit(json_encode(['total' => $total, 'rows' => $list]));
        // break;
    case 'clean':
        $days = intval($_POST['days']);
        if (empty($days) || !$days) $days = 1;
        $lastday = date("Y-m-d", strtotime("-{$days} day")) . ' 00:00:00';
        $tokens = $DB->delete('record', "`mail_date` < '$lastday'");
        $DB->exec("OPTIMIZE TABLE `pre_record`");
        exit('{"code":0,"msg":"删除成功！"}');
        break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
        break;
}
