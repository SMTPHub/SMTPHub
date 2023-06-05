<?php
define('IN_ADMIN', true);
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;

if (!checkRefererHost()) exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    case 'stat':
        $thtime = date("Y-m-d") . ' 00:00:00';
        $lastday = date("Y-m-d", strtotime("-1 day")) . ' 00:00:00';
        $apps = $DB->count('app');
        $app = $DB->count('app', ['status' => 1]);
        $records_today = $DB->count('record', "mail_date>='$thtime'");
        $record_today = $DB->count('record', "mail_date>='$thtime' AND status='1'");
        $records = $DB->count('record');
        $record = $DB->count('record', ['status' => 1]);
        $smtps = $DB->count('smtp');
        $smtp = $DB->count('smtp', ['status' => 1]);

        $result = [
            "code" => 0,
            "apps" => $apps,
            "app" => $app,
            "records_today" => $records_today,
            "record_today" => $record_today,
            "records" => $records,
            "record" => $record,
            "smtps" => $smtps,
            "smtp" => $smtp
        ];
        exit(json_encode($result));
        break;
    case 'set':
        // 修改配置
        if (isset($_POST['green_label_porn'])) {
            $_POST['green_label_porn'] = implode(',', $_POST['green_label_porn']);
        }
        if (isset($_POST['green_label_terrorism'])) {
            $_POST['green_label_terrorism'] = implode(',', $_POST['green_label_terrorism']);
        }
        foreach ($_POST as $k => $v) {
            saveSetting($k, $v);
        }
        exit('{"code":0,"msg":"保存成功"}');
        break;
    case 'password':
        // 修改密码
        $admin_user = isset($_POST['admin_user']) ? trim($_POST['admin_user']) : '';
        $admin_pwd  = isset($_POST['admin_pwd'])  ? trim($_POST['admin_pwd']) : '';
        $newpwd     = isset($_POST['newpwd'])     ? trim($_POST['newpwd']) : '';
        $newpwd2    = isset($_POST['newpwd2'])    ? trim($_POST['newpwd2']) : '';

        if (empty($admin_user)) exit('{"code":-1,"msg":"用户名不能为空"}');
        if (empty($admin_pwd)) exit('{"code":-1,"msg":"旧密码不能为空"}');

        if ($conf['admin_pwd'] != $admin_pwd) exit('{"code":-1,"msg":"旧密码不正确"}');
        // 修改用户名
        saveSetting('admin_user', $admin_user);

        if (!empty($newpwd) && !empty($newpwd2)) {
            // 修改密码
            if ($newpwd != $newpwd2) exit('{"code":-1,"msg":"两次新密码输入不一致"}');
            saveSetting('admin_pwd', $newpwd2);
            $session = md5($admin_user . $newpwd2 . $password_hash);
        } else {
            $session = md5($admin_user . $admin_pwd . $password_hash);
        }
        $expiretime = time() + 2592000;
        $token = authcode("{$admin_user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
        ob_clean();
        setcookie("admin_token", $token, time() + 2592000);
        exit('{"code":0,"msg":"保存成功"}');
        break;
    case 'iptype':
        $result = [
            ['name' => '0_X_FORWARDED_FOR', 'ip' => real_ip(0), 'city' => get_ip_city(real_ip(0))],
            ['name' => '1_X_REAL_IP', 'ip' => real_ip(1), 'city' => get_ip_city(real_ip(1))],
            ['name' => '2_REMOTE_ADDR', 'ip' => real_ip(2), 'city' => get_ip_city(real_ip(2))]
        ];
        exit(json_encode($result));
        break;
    case 'userList':
        $sql = " 1=1";
        $type_arr = ['qq' => 'QQ', 'wx' => '微信'];
        if (isset($_POST['dstatus']) && $_POST['dstatus'] > -1) {
            $dstatus = intval($_POST['dstatus']);
            $sql .= " AND `enable`={$dstatus}";
        }
        if (isset($_POST['kw']) && !empty($_POST['kw'])) {
            $type = intval($_POST['type']);
            $kw = trim(daddslashes($_POST['kw']));
            if ($type == 1) {
                $sql .= " AND `uid`='{$kw}'";
            } elseif ($type == 2) {
                $sql .= " AND `openid`='{$kw}'";
            } elseif ($type == 3) {
                $sql .= " AND `nickname` LIKE '%{$kw}%'";
            } elseif ($type == 4) {
                $sql .= " AND `loginip`='{$kw}'";
            }
        }
        $offset = intval($_POST['offset']);
        $limit = intval($_POST['limit']);
        $total = $DB->getColumn("SELECT count(*) from pre_user WHERE{$sql}");
        $list = $DB->getAll("SELECT * FROM pre_user WHERE{$sql} order by uid desc limit $offset,$limit");
        $list2 = [];
        foreach ($list as $row) {
            $row['type'] = $type_arr[$row['type']];
            $list2[] = $row;
        }

        exit(json_encode(['total' => $total, 'rows' => $list2]));
        break;
    case 'setUserEnable':
        $uid = intval($_POST['uid']);
        $enable = intval($_POST['enable']);
        $sql = "UPDATE pre_user SET enable='$enable' WHERE uid='$uid'";
        if ($DB->exec($sql) !== false) exit('{"code":0,"msg":"修改用户成功！"}');
        else exit('{"code":-1,"msg":"修改用户失败[' . $DB->error() . ']"}');
        break;
    case 'saveUserInfo':
        $uid = intval($_POST['uid']);
        $level = intval($_POST['level']);
        $sql = "UPDATE pre_user SET level='$level' WHERE uid='$uid'";
        if ($DB->exec($sql) !== false) exit('{"code":0,"msg":"修改用户成功！"}');
        else exit('{"code":-1,"msg":"修改用户失败[' . $DB->error() . ']"}');
        break;
    case 'delUser':
        $uid = intval($_POST['uid']);
        $row = $DB->getRow("select * from pre_user where uid='$uid' limit 1");
        if (!$row)
            exit('{"code":-1,"msg":"当前用户不存在！"}');
        $sql = "DELETE FROM pre_user WHERE uid='$uid'";
        if ($DB->exec($sql)) exit('{"code":0,"msg":"删除文件成功！"}');
        else exit('{"code":-1,"msg":"删除文件失败[' . $DB->error() . ']"}');
        break;
    case 'logout':
        setcookie("admin_token", "", time() - 2592000);
        exit('{"code":0,"msg":"您已成功注销本次登陆！"}');
    default:
        exit('{"code":-4,"msg":"No Act"}');
        break;
}
