<?php
define('IN_ADMIN', true);
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if (!checkRefererHost()) exit('403');

$id = intval($_GET['id']);
$email = $DB->find('record', '*', ['id' => $id]);
if (!$email) exit('记录不存在');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>查看邮件</title>
</head>

<body>
    <!-- <table class="table table-bordered table-sm">
        <tr>
            <td>APPID</td>
            <td><?php echo $email['appid']; ?></td>
        </tr>
        <tr>
            <td>SMTPID</td>
            <td><?php echo $email['smtp_id']; ?></td>
        </tr>
        <tr>
            <td>状态</td>
            <td><?php echo $email['status'] == 1 ? '<span class="label label-success">成功</span>' : '<span class="label label-default">失败</span>'; ?></td>
        </tr>
        <tr>
            <td>主题</td>
            <td><?php echo $email['mail_subject']; ?></td>
        </tr>
        <tr>
            <td>发送人</td>
            <td><?php echo $email['mail_from']; ?></td>
        </tr>
        <tr>
            <td>接收人</td>
            <td><?php echo $email['mail_to']; ?></td>
        </tr>
        <tr>
            <td>发送日期</td>
            <td><?php echo $email['mail_date']; ?></td>
        </tr>
        <tr>
            <td colspan="2">邮件内容</td>
        </tr>
    </table> -->
    <?php echo $email['mail_body']; ?>
</body>

</html>