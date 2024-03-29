<?php if (!defined('IN_CRONLITE')) exit(); ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $conf['title']; ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'] ?>">
    <meta name="description" content="<?php echo $conf['description'] ?>">

    <!-- Mobile support -->
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <style>
        html,
        body,
        .container {
            height: 100%;
            width: 100%;
        }
        body {
            height: 100%;
            font-family: '微软雅黑', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: #fafafa;
            text-align: center;
            background: url(./assets/img/btbg.png) no-repeat fixed bottom;
            background-size: 100% auto;
        }
        .container {
            display: table;
        }
        .title_logo {
            display: table-cell;
            vertical-align: middle;
        }
        h1 {
            margin-top: 0;
            font-size: 30px;
        }
        img {
            max-width: 96%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title_logo">
            <h1><?php echo $conf['title']; ?></h1>
            <img src="./assets/img/smtp.jpg" class="icon" alt="SMTPHub">
        </div>
    </div>
</body>

</html>