<?php

// 导入SDK
include('SMTPHub.php');
// 实例
$SMTP = new \lib\mail\SMTPHub('http://smtphub.domain.com/api.php', '1000', 'abcdefghijklmnopqrestuvwxyz');

// 定义参数
$to        = 'name@mail.com';
$to_name   = '接收人名字';
$subject   = "这是一封测试邮件";
$message   = "邮件内容";
$from_name = '发信人名字';

// 调用发送接口
$result    = $SMTP->send($to, $subject, $message, $to_name, $from_name);

// 输出结果
@header('Content-Type: application/json; charset=UTF-8');
echo $result;
