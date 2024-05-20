<?php
define('IN_ADMIN', true);
$mod = 'admin';
include("../includes/common.php");
if ($admin_islogin == 1) {
} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
// $act=isset($_GET['act'])?daddslashes($_GET['act']):null;
$act = isset($_REQUEST['act']) ? daddslashes($_REQUEST['act']) : null;
if (!checkRefererHost()) exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    case 'info':
        $id = intval($_GET['id']);
        $row = $DB->find('app', '*', ['id' => $id]);
        if (!$row) exit('{"code":-1,"msg":"应用不存在！"}');
        exit(json_encode(['code' => 0, 'data' => $row]));
        break;
    case 'options':
        $row = $DB->findAll('app', 'id,app_name,address', ['status' => 1]);
        exit(json_encode(['code' => 0, 'data' => $row]));
        break;
    case 'list':
        $sql = " 1=1";

        $id = intval($_POST['id']);
        $app_name = trim(daddslashes($_POST['name']));
        $app_type = intval($_POST['type']);

        if (!empty($id)) {
            $sql .= " AND `id`='{$id}'";
        }
        if (!empty($app_name)) {
            $sql .= " AND `app_name` LIKE '%{$app_name}%'";
        }
        if (!empty($app_type)) {
            $sql .= " AND `app_type`='{$app_type}'";
        }

        $offset = intval($_POST['offset']);
        $limit = intval($_POST['limit']);
        $total = $DB->count('app', "{$sql}");
        $list = $DB->findAll('app', '*', "{$sql}", 'id desc');

        exit(json_encode(['code' => 0, 'total' => $total, 'rows' => $list]));
        break;
    case 'set':
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);
        if (empty($id)) exit('{"code":-1,"msg":"id不能为空"}');
        if (!$DB->update('app', ['status' => $status], ['id' => $id])) {
            exit('{"code":-1,"msg":"修改应用失败[' . $DB->error() . ']"}');
        }
        exit('{"code":0,"msg":"修改应用成功！"}');
        break;
    case 'add':
        $app_name = trim(daddslashes($_POST['app_name']));
        $app_type = intval($_POST['app_type']);
        $app_secret = trim(daddslashes($_POST['app_secret']));
        $app_from_name = trim(daddslashes($_POST['app_from_name']));
        $smtp_id = intval($_POST['smtp_id']);
        if (empty($app_name)) exit('{"code":-1,"msg":"名称不能为空"}');
        if (empty($app_type)) exit('{"code":-1,"msg":"类型不能为空"}');
        if (empty($smtp_id)) exit('{"code":-1,"msg":"SMTP不能为空"}');
        if (empty($app_secret)) {
            $app_secret = random(32);
        }
        if (!$DB->insert('app', [
            'app_name' => $app_name,
            'app_type' => $app_type,
            'app_secret' => $app_secret,
            'app_from_name' => $app_from_name,
            'smtp_id' => $smtp_id,
            'status' => 1,
            'addtime' => date("Y-m-d H:i:s")
        ])) exit('{"code":-1,"msg":"添加应用失败[' . $DB->error() . ']"}');
        exit('{"code":0,"msg":"添加应用成功！"}');
        break;
    case 'update':
        $id = intval(trim($_POST['id']));
        $app_name = trim(daddslashes($_POST['app_name']));
        $app_type = intval($_POST['app_type']);
        $app_secret = trim(daddslashes($_POST['app_secret']));
        $app_from_name = trim(daddslashes($_POST['app_from_name']));
        $smtp_id = intval($_POST['smtp_id']);
        if ($id < 1) exit('{"code":-1,"msg":"ID有误"}');
        if (empty($app_name)) exit('{"code":-1,"msg":"名称不能为空"}');
        if (empty($app_type)) exit('{"code":-1,"msg":"类型不能为空"}');
        if (empty($smtp_id)) exit('{"code":-1,"msg":"SMTP不能为空"}');
        if (empty($app_secret)) {
            $app_secret = random(32);
        }
        if (!$DB->update(
            'app',
            [
                'app_name' => $app_name,
                'app_type' => $app_type,
                'app_secret' => $app_secret,
                'app_from_name' => $app_from_name,
                'smtp_id' => $smtp_id,
                'updatetime' => date("Y-m-d H:i:s")
            ],
            ['id' => $id]
        )) exit('{"code":-1,"msg":"修改失败：<br />[' . $DB->error() . ']"}');
        exit('{"code":0,"msg":"修改成功！"}');
        break;
    case 'del':
        $id = intval($_POST['id']);
        $row = $DB->find('app', 'id', ['id' => $id]);
        if (!$row) exit('{"code":-1,"msg":"应用不存在！"}');
        if ($DB->delete('app', ['id' => $id])) {
            exit('{"code":0,"msg":"删除应用成功！"}');
        }
        else exit('{"code":-1,"msg":"删除应用失败[' . $DB->error() . ']"}');
        break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
        break;
}
