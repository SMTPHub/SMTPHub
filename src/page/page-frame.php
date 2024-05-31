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
        html, body {
            border: none;
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
        }
    </style>
</head>

<frameset framespacing="0" border="0" rows="0" frameborder="0">
    <frame name="main" src="<?php echo $conf['homepage_url']; ?>" scrolling="auto" noresize>
</frameset>

</html>