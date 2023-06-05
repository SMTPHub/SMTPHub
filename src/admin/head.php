<?php
if (!defined('IN_CRONLITE')) return;
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $title; ?> - <?php echo $conf['title']; ?></title>
    <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap-table.css" rel="stylesheet" />
    <script src="//cdn.staticfile.org/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="//cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
    <script src="//cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.staticfile.org/layer/3.1.1/layer.js"></script>
    <!--[if lt IE 9]>
    <script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
    <?php if ($admin_islogin == 1) { ?>
        <nav class="navbar navbar-fixed-top navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">导航按钮</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./"><?php echo $conf['title']; ?></a>
                </div><!-- /.navbar-header -->
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="<?php echo checkIfActive('index,') ?>">
                            <a href="./"><i class="fa fa-home"></i> 后台首页</a>
                        </li>
                        <li class="<?php echo checkIfActive('app'); ?>">
                            <a href="app.php"><i class="fa fa-cube fa-fw"></i> 应用管理</a>
                        </li>
                        <li class="<?php echo checkIfActive('record'); ?>">
                            <a href="record.php"><i class="fa fa-history fa-fw"></i> 发送记录</a>
                        </li>
                        <li class="<?php echo checkIfActive('smtp'); ?>">
                            <a href="smtp.php"><i class="fa fa-server fa-fw"></i> SMTP管理</a>
                        </li>
                        <li class="<?php echo checkIfActive('set'); ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-fw"></i> 系统管理 <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="./set.php?mod=site"><i class="fa fa-cog fa-fw"></i> 站点设置</a></li>
                                <li><a href="./set.php?mod=iptype"><i class="fa fa-shield fa-fw"></i> 用户IP地址设置</a></li>
                                <li><a href="./set.php?mod=account"><i class="fa fa-lock fa-fw"></i> 管理员设置</a></li>
                            </ul>
                        </li>
                        <li><a href="#" onclick="return logout();"><i class="fa fa-sign-out"></i> 退出登录</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->
        <script>
            function logout() {
                layer.confirm('确定退出登录 ？', {
                    icon: 3,
                    btn: ['确定', '取消']
                }, function() {
                    var ii = layer.load(2);
                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?act=logout',
                        dataType: 'json',
                        success: function(data) {
                            layer.close(ii);
                            if (data.code == 0) {
                                layer.alert(data.msg, {
                                    icon: 1,
                                    closeBtn: false
                                }, function() {
                                    window.location.href = 'login.php';
                                });
                            } else {
                                layer.alert(data.msg, {
                                    icon: 2
                                });
                            }
                        },
                        error: function(data) {
                            layer.close(ii);
                            layer.msg('服务器错误');
                        }
                    });
                });
            }
        </script>
    <?php } ?>