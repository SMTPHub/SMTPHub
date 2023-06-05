<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">
    <!-- Mobile support -->
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <!-- Bootstrap Style -->
    <link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css?v=<?php echo VERSION ?>" rel="stylesheet">
    <script type="text/javascript" src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>

    <div class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./"><?php echo $conf['title'] ?></a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php echo checkIfActive('index,') ?>"><a href="./"><i class="fa fa-home" aria-hidden="true"></i> 首页</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?php echo checkIfActive('app') ?>"><a href="./user/app.php"><i class="fa fa-globe" aria-hidden="true"></i> 我的应用</a></li>
                    <?php if ($conf['userlogin']) { ?>
                        <?php if ($user_islogin) { ?>
                            <li class="dropdown">
                                <a data-target="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-<?php echo $userrow['type'] == 'qq' ? 'qq' : 'wechat'; ?>" aria-hidden="true"></i> <?php echo $userrow['nickname'] ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./user/login.php?logout=1" onclick="return confirm('是否确定退出登录？')"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="<?php echo checkIfActive('login') ?>"><a href="./user/login.php"><i class="fa fa-user-circle" aria-hidden="true"></i> 未登录</a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>