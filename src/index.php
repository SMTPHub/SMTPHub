<?php
$mod = isset($_GET['mod']) ? $_GET['mod'] : 'home';
include("./includes/common.php");

if($conf['homepage']==2){
    echo '<html><frameset framespacing="0" border="0" rows="0" frameborder="0">
    <frame name="main" src="'.$conf['homepage_url'].'" scrolling="auto" noresize>
  </frameset></html>';
  exit;
}elseif($conf['homepage']==1){
    require_once ROOT. '/page/page-blank.php';
    exit(0);
    // exit("<script language='javascript'>window.location.href='./user/';</script>");
}
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta name="keywords" content="<?php echo $conf['keywords']?>">
    <meta name="description" content="<?php echo $conf['description']?>" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <title><?php echo $conf['title']?></title>
    <link rel="shortcut icon" href="favicon.ico">

    <link href="<?php echo $cdnpublic?>twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cdnpublic?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="./assets/css/site.css" rel="stylesheet">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="/">首页</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./doc.php">开发文档</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./agreement.php">服务协议</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="./about.php">关于我们</a>
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

    <section class="page-banner text-center">
        <div class="row" style="width:100%">
            <div class="col-sm-6 col-xs-12 banner-title">
                <h1><?php echo $conf['site_name']?></h1>
                <p><?php echo $conf['title']?></p>
                <div class="page-banner-buttons">
                  <a class="btn bg-white" href="./doc.php"><i class="fa fa-book fa-fw"></i> 开发文档</a>
                    <a class="btn bg-white" href="https://github.com/SMTPHub/SMTPHub" target="_blank"><i class="fa fa-github fa-fw"></i> Github</a>
                    <a class="btn bg-white" href="https://gitee.com/SMTPHub/SMTPHub" target="_blank"><i class="fa fa-coffee fa-fw"></i> Gitee</a>
                </div>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <img src="./assets/img/TB14WC0uAL0gK0jSZFAXXcA9pXa-1001-800.png">
            </div>
        </div>
    </section>

    <section class="page-section page-info text-center">
        <div class="container">
            <div class="page-section-title">
                <h2><?php echo $conf['site_name']?> 是什么？</h2>
            </div>

            <p class="text-left">
                <?php echo $conf['site_name']?> 是一款使用 SMTP 服务进行邮件统一发送的系统，类似于邮件推送 API 服务，
                可实现对接多个业务站点，多个业务站点可以统一调用本系统接口实现邮件发送。
                有完善的开发文档与 SDK，方便开发者快速接入。
            </p>
        </div>
    </section>

    <section class="page-section page-functions text-center">
      <div class="page-section-title">
          <h2>它有什么特点？</h2>
      </div>
      <div class="container">
        <div class="row">
          <div class="um-uapp-insight-card l-pic-r-word">
            <div class="um-uapp-insight-card-imgwrap">
              <img class="um-uapp-insight-card-img" src="./assets/img/TB1RDFDurr1gK0jSZFDXXb9yVXa-1120-460.jpg">
            </div>
            <div class="um-uapp-insight-card-content">
              <div class="um-uapp-insight-card-title">全面覆盖国内外主流互联网平台</div>
              <div class="um-uapp-insight-card-desc">
                <img style="width: 19px;height: 13px;" src="./assets/img/TB16YZfr.T1gK0jSZFhXXaAtVXa-40-28.png" alt="">
                覆盖国内主流邮箱平台，包括：网易、QQ、新浪、Tom、搜狐邮箱、Gmail、Outlook，等支持 SMTP 的邮箱服务
              </div>
            </div>
          </div>
          <div class="um-uapp-insight-card r-pic-l-word">
            <div class="um-uapp-insight-card-imgwrap">
              <img class="um-uapp-insight-card-img" src="./assets/img/TB1L31Zurr1gK0jSZR0XXbP8XXa-4672-1914.jpg">
            </div>
            <div class="um-uapp-insight-card-content">
              <div class="um-uapp-insight-card-title">集成成本低、速度快</div>
              <div class="um-uapp-insight-card-desc">
                <img style="width: 19px;height: 13px;" src="./assets/img/TB16YZfr.T1gK0jSZFhXXaAtVXa-40-28.png" alt="">
                规避三方平台差异性，统一封装极简接口，多个平台一次搞定。
              </div>
            </div>
          </div>
          <div class="um-uapp-insight-card l-pic-r-word">
            <div class="um-uapp-insight-card-imgwrap">
              <img class="um-uapp-insight-card-img" src="./assets/img/TB1cx4DuET1gK0jSZFrXXcNCXXa-1120-460.jpg">
            </div>
            <div class="um-uapp-insight-card-content">
              <div class="um-uapp-insight-card-title">创建应用、无需审核</div>
              <div class="um-uapp-insight-card-desc">
                <img style="width: 19px;height: 13px;" src="./assets/img/TB16YZfr.T1gK0jSZFhXXaAtVXa-40-28.png" alt="">
                不需要进行邮件模板申请，只需在在后台创建应用即可直接使用。
              </div>
            </div>
          </div>
          <div class="um-uapp-insight-card r-pic-l-word">
            <div class="um-uapp-insight-card-imgwrap">
              <img class="um-uapp-insight-card-img" src="./assets/img/TB1RPO2urY1gK0jSZTEXXXDQVXa-4673-1918.jpg">
            </div>
            <div class="um-uapp-insight-card-content">
              <div class="um-uapp-insight-card-title">完善的控制面板与统计</div>
              <div class="um-uapp-insight-card-desc">
                <img style="width: 19px;height: 13px;" src="./assets/img/TB16YZfr.T1gK0jSZFhXXaAtVXa-40-28.png" alt="">
                通过控制面板，可以实时掌握网站服务情况，包含各项统计数据。
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-links" <?php if(!$conf['links']){echo 'style="display:none;"';}?>>
        <div class="container">友情链接：<?php echo $conf['links']?></div>
    </section>

    <footer class="page-footer text-center">
        <p>
            Copyright &copy;<?php echo date("Y")?> <?php echo $conf['orgname'] ?> All Rights Reserved.
            <?php if ($conf['site_icp']) { ?><br /><a href="https://beian.miit.gov.cn/#/Integrated/index" class="nav-link" target="_blank"><?php echo $conf['site_icp'] ?></a><?php } ?>

        </p>
        <?php echo $conf['footer'] ?>

    </footer>

    <script src="<?php echo $cdnpublic?>jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo $cdnpublic?>twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
    $(function(){
          $(document).scroll(function() {
            var t = $('.page-info').offset().top - $(document).scrollTop() - $('.page-header').height();
            
            if(t <= 0){
                $('.page-header').addClass('page-header-white');
            }else{
                $('.page-header').removeClass('page-header-white');
            }
        });
    });
    </script>
</body>
</html>