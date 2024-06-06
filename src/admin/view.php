<?php
define('IN_ADMIN', true);
$mod = 'admin';
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if (!checkRefererHost()) exit('403');

$id = intval($_GET['id']);
$email = $DB->find('record', '*', ['id' => $id]);
if (!$email) exit('记录不存在');
$email['mail_body'] = urldecode($email['mail_body']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>查看邮件</title>
    <link href="<?php echo $cdnpublic; ?>twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <table class="table table-bordered table-sm">
        <tr>
            <td>应用ID</td>
            <td><?php echo $email['appid']; ?></td>
            <td>服务ID</td>
            <td><?php echo $email['smtp_id']; ?></td>
        </tr>
        <tr>
            <td>状态</td>
            <td><?php echo $email['status'] == 1 ? '<span class="label label-success">成功</span>' : '<span class="label label-default">失败</span>'; ?></td>
            <td>主题</td>
            <td><?php echo $email['mail_subject']; ?></td>
        </tr>
        <tr>
            <td>发送人</td>
            <td><?php echo $email['mail_from']; ?></td>
            <td>接收人</td>
            <td><?php echo $email['mail_to']; ?></td>
        </tr>
        <tr>
            <td>发送日期</td>
            <td><?php echo $email['mail_date']; ?></td>
        </tr>
    </table>
    <hr />
    <?php echo $email['mail_body']; ?>
</body>

</html>