<?php if (!defined('IN_CRONLITE')) exit(); ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>请使用浏览器打开</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta name="format-detection" content="telephone=no">
    <meta name="aplus-touch" content="1">
    <style>
        body,
        html {
            width: 100%;
            height: 100%
        }

        * {
            margin: 0;
            padding: 0
        }

        body {
            background-color: #fff
        }

        #browser img {
            width: 50px;
        }

        #browser {
            margin: 0px 10px;
            text-align: center;
        }

        #contens {
            font-weight: bold;
            color: #2466f4;
            margin: -265px 0px 10px;
            text-align: center;
            font-size: 20px;
            margin-bottom: 125px;
        }

        .top-bar-guidance {
            font-size: 15px;
            color: #fff;
            height: 60%;
            line-height: 1.8;
            padding-left: 20px;
            padding-top: 20px;
            background: url(<?php echo $site_url; ?>/assets/browseronly/banner.png) center top/contain no-repeat
        }

        .top-bar-guidance .icon-safari {
            width: 25px;
            height: 25px;
            vertical-align: middle;
            margin: 0 .2em
        }

        .app-download-tip {
            margin: 0 auto;
            width: 290px;
            text-align: center;
            font-size: 15px;
            color: #2466f4;
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAcAQMAAACak0ePAAAABlBMVEUAAAAdYfh+GakkAAAAAXRSTlMAQObYZgAAAA5JREFUCNdjwA8acEkAAAy4AIE4hQq/AAAAAElFTkSuQmCC) left center/auto 15px repeat-x;
            overflow: hidden;
        }

        .app-download-tip .guidance-desc {
            background-color: #fff;
            padding: 0 5px
        }

        .app-download-tip .icon-sgd {
            width: 25px;
            height: 25px;
            vertical-align: middle;
            margin: 0 .2em
        }

        .app-download-btn {
            display: block;
            width: 214px;
            height: 40px;
            line-height: 40px;
            margin: 18px auto 0 auto;
            text-align: center;
            font-size: 18px;
            color: #2466f4;
            border-radius: 20px;
            border: .5px #2466f4 solid;
            text-decoration: none
        }
    </style>
</head>

<body>

    <div class="top-bar-guidance">
        <p>注意：</p>
        <p>请点击右上角<img src="<?php echo $site_url; ?>/assets/browseronly/more.png" class="icon-safari">选择在浏览器打开</p>
    </div>

    <div id="contens">
        <p><br /><br /></p>
        <p>该网站不支持QQ/微信访问</p>
        <p><br /></p>
        <p>请按提示在手机浏览器访问</p>
    </div>

    <div class="app-download-tip">
        <span class="guidance-desc"><?php echo $site_uri; ?></span>
    </div>
    <p><br /></p>
    <div class="app-download-tip">
        <span class="guidance-desc">点击右上角<img src="<?php echo $site_url; ?>/assets/browseronly/more.png" class="icon-sgd"> or 复制网址自行打开</span>
    </div>

    <script src="<?php echo $cdnpublic; ?>jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo $cdnpublic; ?>clipboard.js/2.0.0/clipboard.min.js"></script>
    <a data-clipboard-text="<?php echo $site_uri; ?>" class="app-download-btn">点此复制本站网址</a>
    <script src="<?php echo $cdnpublic; ?>layer/3.1.1/layer.js"></script>
    <script type="text/javascript">
        new ClipboardJS(".app-download-btn");
    </script>
    <script>
        $(".app-download-btn").click(function() {
            layer.msg("复制成功，么么哒", function() {
                //关闭后的操作
            });
        })
    </script>

    <body>

</html>