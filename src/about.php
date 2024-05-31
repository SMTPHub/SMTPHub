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

    <title>关于我们 - <?php echo $conf['title'] ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>" />

    <link href="<?php echo $cdnpublic; ?>twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cdnpublic; ?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="/assets/css/site.css" rel="stylesheet">
    <style>
        body {
            padding-top: 0;
        }
        .page-header {
            position: unset;
        }
        .card {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <header class="page-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/"><img src="/assets/img/logo.png"> <?php echo $conf['site_name'] ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">首页</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/doc.php">开发文档</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./agreement.php">服务协议</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/about.php">关于我们</a>
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
                <h2>关于我们</h2>
            </div>
            <div class="card" id="aboutus">
                <div class="card-header">关于应用</div>
                <div class="card-body">
                    <p>应用名称：SMTPHub</p>
                    <p>源码下载：<a href="https://gitee.com/SMTPHub/SMTPHub" target="_blank">Gitee</a>，<a href="https://github.com/SMTPHub/SMTPHub" target="_blank">Github</a></p>
                    <p>版权所有：Copyright © 2023 - 2024 程江科技</p>
                </div>
            </div>
            <div class="card" id="contactus">
                <div class="card-header">联系方式</div>
                <div class="card-body">
                    <p>联系地址：<?php echo $conf['address'] ?></p>
                    <p>联系 QQ：<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq'] ?>&site=qq&menu=yes" target="_blank"><?php echo $conf['kfqq'] ?></a></p>
                    <p>服务邮箱：<?php echo $conf['email'] ?></p>
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