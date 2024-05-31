<?php
$mod = isset($_GET['mod']) ? $_GET['mod'] : 'home';
include("./includes/common.php");
?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">

    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection">

    <title>开发文档 - <?php echo $conf['title']?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']?>">
    <meta name="description" content="<?php echo $conf['description']?>" />

    <link href="<?php echo $cdnpublic; ?>twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cdnpublic; ?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="./assets/css/site.css" rel="stylesheet">
    <style>
      body{padding-top: 0;}
      .page-header{position: unset;}
      .card{margin-bottom: 10px;}
    </style>
  </head>
  <body>
    <header class="page-header">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/">
            <img src="./assets/img/logo.png"> <?php echo $conf['site_name']?>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="./">首页</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="doc.php">开发文档</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./agreement.php">服务协议</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">关于我们</a>
              </li>
              <?php if($conf['user_login']){?><li class="nav-item">
                  <a class="nav-link" href="./user/">用户中心</a>
              </li><?php }?>
              <li class="nav-item">
                <a class="nav-link" href="https://github.com/SMTPHub/SMTPHub" target="_blank">Github</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <section class="page-section page-info">
      <div class="container">
        <div class="page-section-title text-center">
          <h2>开发文档</h2>
        </div>
<div class="row">
  <div class="col-md-3">
    <div class="list-group">
      <a href="#doc1" class="list-group-item list-group-item-action">平台介绍</a>
      <a href="#doc2" class="list-group-item list-group-item-action">接口规则</a>
      <a href="#doc3" class="list-group-item list-group-item-action">使用步骤</a>
      <a href="#doc4" class="list-group-item list-group-item-action">SDK使用</a>
      <a href="#doc5" class="list-group-item list-group-item-action">SDK下载</a>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card" id="doc1">
      <div class="card-header"><?php echo $conf['site_name']?> 介绍</div>
      <div class="card-body">
        <p><?php echo $conf['site_name']?> 是一款使用第三方平台邮箱账号来进行发送邮件的系统。</p>
        <p>使用本系统可以将多个 SMTP 服务统一聚合起来使用，通过本系统的接口，开发者可以通过接口 APPID 和 APPSECRET 进行 SMTP 邮箱的发送操作。</p>
        <p>这里的第三方平台，是指网易、QQ、新浪、Tom、搜狐、Gmail、Outlook，等支持 SMTP 的邮箱服务平台。</p>
      </div>
    </div>

    <div class="card" id="doc2">
      <div class="card-header">接口协议规则</div>
      <div class="card-body">
        <p>传输方式：HTTP</p>
        <p>数据格式：JSON 或 FormData</p>
        <p>字符编码：UTF-8</p>
      </div>
    </div>

    <div class="card" id="doc3">
      <div class="card-header">使用步骤</div>
      <div class="card-body">
        <p>1. 系统后台【 SMTP管理】添加 SMTP 服务器配置，依次填写名称，SMTP主机、端口、账号、密码，</p>
        <p>2. 系统后台【应用管理】添加应用，填写应用名称，应用密钥，服务类别选中上一步添加的 SMTP 服务，点击【保存】，在列表中点击【密钥】得到 APPSECRET，</p>
        <p>3. 使用如上操作拿到的 APPID 和 APPSECRET 调用接口开始使用。</p>
        <h3>接口调用说明</h3>
        <p>接口 URL：<code><?php echo $site_url; ?>/api.php</code></p>
        <p>POST 参数说明</p>
        <div class="table-responsive"><table class="table table-hover table-striped table-bordered table-sm">
            <tr>
                <th width="120">参数名</th>
                <th width="50">必要</th>
                <th width="130">说明</th>
                <th>示例</th>
            </tr>
            <tr>
                <td>action</td>
                <td>必须</td>
                <td>发送邮件</td>
                <td>send</td>
            </tr>
            <tr>
                <td>appid</td>
                <td>必须</td>
                <td>应用ID</td>
                <td>1000</td>
            </tr>
            <tr>
                <td>appsecret</td>
                <td>必须</td>
                <td>应用密钥</td>
                <td>Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k</td>
            </tr>
            <tr>
                <td>to</td>
                <td>必须</td>
                <td>邮件收件人地址</td>
                <td>username@email-server.com</td>
            </tr>
            <tr>
                <td>subject</td>
                <td>必须</td>
                <td>邮件主题</td>
                <td>网站通知</td>
            </tr>
            <tr>
                <td>message</td>
                <td>必须</td>
                <td>邮件内容</td>
                <td><code>&lt;p&gt;您好，感谢您加入会员 ！支持HTML！&lt;/p&gt;</code></td>
            </tr>
            <tr>
                <td>to_name</td>
                <td>可选</td>
                <td>邮件收信人名称</td>
                <td>【网站会员】</td>
            </tr>
            <tr>
                <td>from_name</td>
                <td>可选</td>
                <td>邮件发信人名称</td>
                <td>【站点名称】</td>
            </tr>
            <tr>
                <td>reply_to</td>
                <td>可选</td>
                <td>回信地址</td>
                <td>service@email-server.com</td>
            </tr>
            <tr>
                <td>reply_name</td>
                <td>可选</td>
                <td>回信地址名称</td>
                <td>客户服务</td>
            </tr>
        </table></div>
        注意： 邮件发信人名称，未设置时，按照应用配置的【发信人名称】来显示，若未配置则显示为配置的【应用名称】
        <hr />
        <p>接口请求 JSON 示例</p>
        <code><pre>{
    "appid": 1000,
    "appsecret": "Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k",
    "action": "send",
    "to": "username@email-server.com",
    "subject": "网站通知",
    "message": "&lt;p&gt;您好，感谢您加入会员 ！支持HTML！&lt;/p&gt;",
    "to_name": "【网站会员】",
    "from_name": "【站点名称】",
    "reply_to": "service@email-server.com",
    "reply_name": "【客户服务部】"
}</pre></code>
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
      </div>
    </div>

    <div class="card" id="doc4">
      <div class="card-header">PHP SDK 使用方法</div>
      <div class="card-body">
        <p>引用 SDK</p>
        <hr />
        <pre>// 导入 SDK
include('SMTPHub.php');
// 实例
$SMTP = new \lib\mail\SMTPHub('<?php echo $site_url; ?>/api.php', APPID, APPSECRET);
// 调用发送接口
$SMTP->send('接收人邮箱', '主题', '内容', '收信人名字', '发信人名字');
</pre>
      <p>示例</p>
      <hr />
      <pre>// 导入SDK
include('SMTPHub.php');
// 实例
$SMTP = new \lib\mail\SMTPHub('<?php echo $site_url; ?>/api.php', '1000', 'Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k');

// 定义参数
$to        = 'username@email-server.com';
$to_name   = '接收人名字';
$subject   = "这是一封测试邮件";
$message   = "邮件内容";
$from_name = '发信人名字';

// 调用发送接口
$result    = $SMTP->send($to, $subject, $message, $to_name, $from_name);

// 输出结果
echo $result;
</pre>
      </div>
    </div>

    <div class="card" id="doc5">
      <div class="card-header">SDK 下载</div>
      <div class="card-body">
        <p>SDK版本：1.0</p>
        <p><a href="./sdk/smtphub-sdk-php.zip">点击下载</a></p>
      </div>
    </div>
  </div>
</div>
</div>
</section>

    <footer class="page-footer text-center">
        <p>
            Copyright &copy;<?php echo date("Y")?> <?php echo $conf['orgname'] ?> All Rights Reserved.
            <?php if ($conf['site_icp']) { ?><br /><a href="https://beian.miit.gov.cn/#/Integrated/index" class="nav-link" target="_blank"><?php echo $conf['site_icp'] ?></a><?php } ?>
        </p>
        <?php echo $conf['footer']; ?>
    </footer>

    <script src="<?php echo $cdnpublic; ?>jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo $cdnpublic; ?>twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>

  </body>
</html>