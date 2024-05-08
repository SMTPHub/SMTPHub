<?php

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
// error_reporting(-1);

if (defined('IN_CRONLITE')) return;
define('IN_CRONLITE', true);
define('SYSTEM_MODE', 'prod');
define('SYSTEM_ROOT', dirname(__FILE__));
define('ROOT', dirname(SYSTEM_ROOT));
define('APP_VERSION', '1.1.3');
define('VERSION', '1002');
define('DB_VERSION', '1001');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");

@header('Content-Type: text/html; charset=UTF-8');

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('require PHP >= 5.4 !');
}

if (!$nosession) session_start();

if (!function_exists("is_https")) {
    function is_https()
    {
        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
            return true;
        } elseif (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
            return true;
        } elseif (isset($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https') {
            return true;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            return true;
        } elseif (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') {
            return true;
        } elseif (isset($_SERVER['HTTP_EWS_CUSTOME_SCHEME']) && $_SERVER['HTTP_EWS_CUSTOME_SCHEME'] == 'https') {
            return true;
        }
        return false;
    }
}

$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$site_path = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$site_http = (is_https() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
$site_url = $site_http . $site_path;

include_once(SYSTEM_ROOT . '/txprotect.php');
include_once(SYSTEM_ROOT . '/autoloader.php');
Autoloader::register();

include ROOT . '/config.php';

if (!$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname']) //检测安装1
{
    exit('你还没安装！<a href="' . $site_http . '/install/">点此安装</a>');
}

$DB = new \lib\PdoHelper($dbconfig);

if ($DB->query("select * from pre_config where 1") == FALSE) //检测安装2
{
    exit('你还没安装！<a href="' . $site_http . '/install/">点此安装</a>');
}

if (!file_exists(ROOT . '/install/install.lock') && file_exists(ROOT . '/install/index.php')) {
    sysmsg('<h2>检测到无 install.lock 文件</h2><ul><li><font size="4">如果您尚未安装本程序，请<a href="' . $site_http . '/install/">前往安装</a></font></li><li><font size="4">如果您已经安装本程序，请手动放置一个空的 install.lock 文件到 /install 文件夹下，<b>为了您站点安全，在您完成它之前我们不会工作。</b></font></li></ul><br/><h4>为什么必须建立 install.lock 文件？</h4>它是安装保护文件，如果检测不到它，就会认为站点还没安装，此时任何人都可以安装/重装你的网站。<br/><br/>');
    exit;
}

include_once(SYSTEM_ROOT . "/functions.php");

$conf = getAllSetting();
define('SYS_KEY', $conf['syskey']);
$password_hash = '!@#%!s!0';

if (!$conf['version'] || $conf['version'] < DB_VERSION) {
    if (!$install) {
        exit('请先完成网站升级！<a href="' . $site_http . '/install/update.php"><font color=red>点此升级</font></a>');
    }
}

if (defined('IN_API')) return;

if ($mod != 'api') {
    // 非接口模块访问限制
    if (($conf['qqjump'] == 1 && (is_qq() || is_weixin()))) {
        $site_uri = $site_http . $_SERVER['REQUEST_URI'];
        require_once ROOT . '/page/page-browseronly.php';
        exit(0);
    }
}

if ($conf['cdnpublic'] == 1) {
    $cdnpublic = 'https://lib.baomitu.com/';
} elseif ($conf['cdnpublic'] == 2) {
    $cdnpublic = 'https://cdn.bootcdn.net/ajax/libs/';
} elseif ($conf['cdnpublic'] == 4) {
    $cdnpublic = 'https://s1.pstatp.com/cdn/expire-1-M/';
} else {
    $cdnpublic = 'https://cdn.staticfile.org/';
}

$admin_islogin = 0;

if (isset($_COOKIE["admin_token"])) {
    $token = authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
    if ($token) {
        list($user, $sid, $expiretime) = explode("\t", $token);
        $session = md5($conf['admin_user'] . $conf['admin_pwd'] . $password_hash);
        if ($session == $sid && $expiretime > time()) {
            $admin_islogin = 1;
        }
    }
}

if (defined('IN_ADMIN')) return;

$clientip = real_ip(isset($conf['ip_type']) ? $conf['ip_type'] : 0);
$denyip = explode('|', $conf['blackip']);
if (in_array($clientip, $denyip) && !$admin_islogin) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

$user_islogin = 0;
if (defined('IN_USER')) {
    if (!$conf['user_login']) {
        exit('<script type="text/javascript">alert("未开启登录");window.location.href="' . $site_http . '";</script>');
    }

    if (isset($_COOKIE["user_token"])) {
        $token = authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
        if ($token) {
            list($uid, $sid, $expiretime) = explode("\t", $token);
            if ($userrow = $DB->getRow("SELECT * FROM pre_user WHERE uid='" . intval($uid) . "' LIMIT 1")) {
                $session = md5($userrow['type'] . $userrow['openid'] . $password_hash);
                if ($session === $sid && $expiretime > time()) {
                    if ($userrow['enable'] == 1) {
                        $user_islogin = 1;
                    } else {
                        $_SESSION['user_block'] = true;
                    }
                }
            }
        }
    }
}
