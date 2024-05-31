<?php

/**
 * 系统设置
 **/
define('IN_ADMIN', true);
$mod = 'admin';
include("../includes/common.php");
$title = '系统设置';
include './head.php';
if ($admin_islogin != 1) exit("<script language='javascript'>window.location.href='./login.php';</script>");

$mod = isset($_GET['mod']) ? $_GET['mod'] : 'site';
?>
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <?php if ($mod == 'site') : ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">网站信息设置</h3>
                </div>
                <div class="panel-body">
                    <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站标题</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">站点名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="site_name" required autocomplete="off" value="<?php echo $conf['site_name'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">站点LOGO</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="site_logo" autocomplete="off" value="<?php echo $conf['site_logo'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公司名称</label>
                            <div class="col-sm-10"><input type="text" name="orgname" value="<?php echo $conf['orgname']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">站点ICP备案号</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="site_icp" autocomplete="off" value="<?php echo $conf['site_icp'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关键字</label>
                            <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站描述</label>
                            <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系地址</label>
                            <div class="col-sm-10"><input type="text" name="address" value="<?php echo $conf['address']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系邮箱</label>
                            <div class="col-sm-10"><input type="text" name="email" value="<?php echo $conf['email']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">客服ＱＱ</label>
                            <div class="col-sm-10"><input type="text" name="kfqq" value="<?php echo $conf['kfqq']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ＱＱ群链接</label>
                            <div class="col-sm-10"><input type="text" name="qqqun" value="<?php echo $conf['qqqun']; ?>" class="form-control" /></div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="col-sm-2 control-label">禁止手机QQ/微信访问</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="qqjump" lay-search lay-filter="qqjump">
                                    <option <?php echo $conf['qqjump'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                                    <option <?php echo $conf['qqjump'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                                </select>
                                <small>此功能没有任何防红效果，理论上直接在QQ发域名推广都会拦截，建议生成防红链接进行访问</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公共静态资源CDN</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="cdnpublic" default="<?php echo $conf['cdnpublic'] ?>">
                                    <option <?php echo $conf['cdnpublic'] == 0 ? 'selected ' : '' ?> value="0">本地自有 - /assets/</option>
                                    <option <?php echo $conf['cdnpublic'] == 1 ? 'selected ' : '' ?> value="1">七牛云CDN - https://cdn.staticfile.org/</option>
                                    <option <?php echo $conf['cdnpublic'] == 2 ? 'selected ' : '' ?> value="2">七牛云CDN - https://cdn.staticfile.net/</option>
                                    <option <?php echo $conf['cdnpublic'] == 3 ? 'selected ' : '' ?> value="3">360CDN - https://lib.baomitu.com/</option>
                                    <option <?php echo $conf['cdnpublic'] == 4 ? 'selected ' : '' ?> value="4">BootCDN - https://cdn.bootcdn.net/ajax/libs/</option>
                                    <option <?php echo $conf['cdnpublic'] == 5 ? 'selected ' : '' ?> value="5">今日头条CDN - https://s1.pstatp.com/cdn/expire-1-M/</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">首页显示模式</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="homepage" default="<?php echo $conf['homepage'] ?>">
                                    <option <?php echo $conf['homepage'] == 0 ? 'selected ' : '' ?> value="0">默认显示首页</option>
                                    <option <?php echo $conf['homepage'] == 1 ? 'selected ' : '' ?> value="1">显示空白首页</option>
                                    <option <?php echo $conf['homepage'] == 2 ? 'selected ' : '' ?> value="2">显示其它指定网址</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="setform4" style="<?php echo $conf['homepage'] != 2 ? 'display:none;' : null; ?>">
                            <label class="col-sm-2 control-label">显示网址URL</label>
                            <div class="col-sm-10">
                                <input type="text" name="homepage_url" value="<?php echo $conf['homepage_url']; ?>" class="form-control" placeholder="将以frame方式显示" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">禁止访问IP</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="blackip" rows="2" placeholder="多个IP用|隔开"><?php echo $conf['blackip'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">友情链接</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="links" rows="2"><?php echo $conf['links'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">页脚代码</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="footer" rows="2"><?php echo $conf['footer']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" name="submit" value="修改" class="btn btn-primary form-control" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php elseif ($mod == 'iptype') : ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">用户IP地址获取设置</h3>
                </div>
                <div class="panel-body">
                    <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户IP地址获取方式</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="ip_type" default="<?php echo $conf['ip_type'] ?>">
                                    <option value="0">0_X_FORWARDED_FOR</option>
                                    <option value="1">1_X_REAL_IP</option>
                                    <option value="2">2_REMOTE_ADDR</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" name="submit" value="修改" class="btn btn-primary form-control" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    此功能设置用于防止用户伪造IP请求。<br />
                    X_FORWARDED_FOR：之前的获取真实IP方式，极易被伪造IP<br />
                    X_REAL_IP：在网站使用CDN的情况下选择此项，在不使用CDN的情况下也会被伪造<br />
                    REMOTE_ADDR：直接获取真实请求IP，无法被伪造，但可能获取到的是CDN节点IP<br />
                    <b>你可以从中选择一个能显示你真实地址的IP，优先选下方的选项。</b>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?act=iptype",
                        dataType: 'json',
                        async: true,
                        success: function(data) {
                            $("select[name='ip_type']").empty();
                            var defaultv = $("select[name='ip_type']").attr('default');
                            $.each(data, function(k, item) {
                                $("select[name='ip_type']").append('<option value="' + k + '" ' + (defaultv == k ? 'selected' : '') + '>' + item.name + ' - ' + item.ip + ' ' + item.city + '</option>');
                            })
                        }
                    });
                })
            </script>
        <?php else : ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">管理账号设置</h3>
                </div>
                <div class="panel-body">
                    <form onsubmit="return saveSetting(this, 'password')" method="post" class="form" role="form">
                        <div class="form-group">
                            <label>用户名：</label><br />
                            <input type="text" name="admin_user" value="<?php echo $conf['admin_user']; ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>旧密码：</label>
                            <input type="password" name="admin_pwd" value="" class="form-control" placeholder="请输入当前的管理员密码" />
                        </div>
                        <div class="form-group">
                            <label>新密码：</label>
                            <input type="password" name="newpwd" value="" class="form-control" placeholder="不修改请留空" />
                        </div>
                        <div class="form-group">
                            <label>重输密码：</label>
                            <input type="password" name="newpwd2" value="" class="form-control" placeholder="不修改请留空" />
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" name="submit" value="保存" class="btn btn-success btn-block" />
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <script>
            $("select[name='homepage']").change(function() {
                if ($(this).val() == 2) {
                    $("#setform4").show();
                } else {
                    $("#setform4").hide();
                }
            });
            function saveSetting(obj, type) {
                var ii = layer.load(2, {
                    shade: [0.1, '#fff']
                });
                $.ajax({
                    type: 'POST',
                    url: type == 'password' ? 'ajax.php?act=password' : 'ajax.php?act=set',
                    data: $(obj).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        layer.close(ii);
                        if (data.code == 0) {
                            layer.alert('保存成功！', {
                                icon: 1,
                                closeBtn: false
                            }, function() {
                                window.location.reload()
                            });
                        } else {
                            layer.alert(data.msg, {
                                icon: 2
                            })
                        }
                    },
                    error: function(data) {
                        layer.close(ii);
                        layer.msg('服务器错误');
                    }
                });
                return false;
            }
        </script>