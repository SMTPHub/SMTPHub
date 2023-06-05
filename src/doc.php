<?php
include("./includes/common.php");
$title = '帮助文档';
// if ($admin_islogin == 1) {
// } else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮助文档 - <?php echo $conf['title']; ?></title>
    <link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.staticfile.org/github-markdown-css/5.1.0/github-markdown.min.css">
    <style>
        body {
            background-color: #eee !important;
        }

        .center-block {
            margin: 0 auto;
            float: none;
            padding: 0;
        }

        .markdown-body {
            box-sizing: border-box;
            margin: 18px auto;
            padding: 45px;
            box-shadow: 2px 2px 2px 2px #888888;
        }

        @media (max-width: 767px) {
            .markdown-body {
                padding: 15px;
                margin: 0 auto;
            }
        }

        code {
            color: #24292f;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 center-block">
                <div class="markdown-body">
                    <h1><?php echo $conf['title']; ?></h1>
                    <h3>使用方法：</h3>
                    <p>1. 系统后台【 SMTP管理】添加 SMTP 服务器配置，依次填写名称，SMTP主机、端口、账号、密码，</p>
                    <p>2. 系统后台【应用管理】添加应用，填写应用名称，应用密钥，服务类别选中上一步添加的 SMTP 服务，点击【保存】，在列表中点击【密钥】得到 APPSECRET，</p>
                    <p>3. 使用如上操作拿到的 APPID 和 APPSECRET 调用接口开始使用。</p>
                    <p>接口调用说明</p>
                    <p>接口 URL：<code><?php echo $site_url; ?>/api.php</code></p>
                    <p>POST 参数说明</p>
                    <table class="table table-striped table-hover table-bordered">
                        <tr>
                            <th>参数名</th>
                            <th>必要</th>
                            <th>示例</th>
                            <th>说明</th>
                        </tr>
                        <tr>
                            <td>action</td>
                            <td>必须</td>
                            <td>send</td>
                            <td>发送邮件</td>
                        </tr>
                        <tr>
                            <td>appid</td>
                            <td>必须</td>
                            <td>1000</td>
                            <td>应用ID</td>
                        </tr>
                        <tr>
                            <td>appsecret</td>
                            <td>必须</td>
                            <td>Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k</td>
                            <td>应用密钥</td>
                        </tr>
                        <tr>
                            <td>to</td>
                            <td>必须</td>
                            <td>username@qq.com</td>
                            <td>邮件收件人地址</td>
                        </tr>
                        <tr>
                            <td>subject</td>
                            <td>必须</td>
                            <td>网站通知</td>
                            <td>邮件主题</td>
                        </tr>
                        <tr>
                            <td>message</td>
                            <td>必须</td>
                            <td><code>&lt;p&gt;您好，感谢您加入会员 ！&lt;/p&gt;</code></td>
                            <td>邮件内容，支持HTML</td>
                        </tr>
                        <tr>
                            <td>to_name</td>
                            <td>可选</td>
                            <td>【网站会员】</td>
                            <td>邮件收信人名称</td>
                        </tr>
                        <tr>
                            <td>from_name</td>
                            <td>可选</td>
                            <td>【站点名称】</td>
                            <td>邮件发信人名称，未设置时，按照应用配置的【发信人名称】<br />来显示，若未配置则显示为配置的【应用名称】</td>
                        </tr>
                    </table>
                    <p>接口返回状态：发送成功</p>
                    <pre>{
    "code": 0,
    "msg": "发送成功"
}</pre>
                    <p>接口返回状态：发送失败</p>
                    <pre>{
    "code": -1,
    "msg": "发送失败"
}</pre>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>