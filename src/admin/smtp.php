<?php
$mod = 'admin';
include("../includes/common.php");
$title = 'SMTP 服务管理';
include './head.php';
if ($admin_islogin != 1) exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>

<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title">SMTP 修改/添加</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form-store">
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">服务名称</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name" placeholder="仅用于显示，不要重复">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">SMTP主机</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_host" id="smtp_host" maxlength="50" placeholder="SMTP服务器，如 smtp.qq.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">SMTP端口</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_port" id="smtp_port" maxlength="5" placeholder="SMTP端口，如 25">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">SMTP账号</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_username" id="smtp_username" maxlength="100" placeholder="邮箱账号，如 mail@company.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">SMTP密码</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_password" id="smtp_password" maxlength="64" placeholder="邮箱密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">发信人名称</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_from_name" id="smtp_from_name" maxlength="100" placeholder="邮件的发件人名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">发信人地址</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="smtp_from" id="smtp_from" maxlength="100" placeholder="邮件的发信人地址，如 mail@company.com">
                            <small>自定义发信人地址需服务商支持，否则请留空或填写SMTP账号</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="store" onclick="save()">保存</button>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding-top: 50px;">
    <div class="col-md-12 center-block" style="float: none;">
        <h3><?php echo $title; ?></h3>
        <form onsubmit="return searchSubmit()" method="GET" class="form-inline" id="searchToolbar">
            <div class="form-group">
                <label>搜索</label>
                <input type="text" class="form-control" name="name" placeholder="名称" style="width: 100px;" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="id" placeholder="ID" style="width: 100px;" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="smtp_host" placeholder="SMTP主机" style="width: 100px;" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="smtp_username" placeholder="SMTP账号" style="width: 100px;" />
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索</button>
            <a href="javascript:searchClear()" class="btn btn-default" title="刷新服务列表"><i class="fa fa-refresh"></i> 重置</a>
            <a href="javascript:addframe()" class="btn btn-success"><i class="fa fa-plus"></i> 添加</a>
            <a href="../doc.php" class="btn btn-default" target="_blank"><i class="fa fa-info-circle"></i> 帮助</a>
        </form>
        <table id="listTable"></table>
    </div>
</div>

<script src="//cdn.staticfile.org/bootstrap-table/1.20.2/bootstrap-table.min.js"></script>
<script src="//cdn.staticfile.org/bootstrap-table/1.20.2/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js"></script>
<script src="../assets/js/custom.js"></script>
<script>
    $(document).ready(function() {
        updateToolbar();
        const defaultPageSize = 15;
        const pageNumber = typeof window.$_GET['pageNumber'] != 'undefined' ? parseInt(window.$_GET['pageNumber']) : 1;
        const pageSize = typeof window.$_GET['pageSize'] != 'undefined' ? parseInt(window.$_GET['pageSize']) : defaultPageSize;

        $("#listTable").bootstrapTable({
            url: 'ajax_smtp.php?act=list',
            pageNumber: pageNumber,
            pageSize: pageSize,
            classes: 'table table-striped table-hover table-bordered',
            columns: [{
                    field: 'id',
                    title: '服务ID'
                },
                {
                    field: 'name',
                    title: '名称'
                },
                {
                    field: 'smtp_host',
                    title: 'SMTP主机'
                },
                {
                    field: 'smtp_username',
                    title: 'SMTP账号'
                },
                {
                    field: 'smtp_port',
                    title: 'SMTP端口'
                },
                {
                    field: 'addtime',
                    title: '添加时间'
                },
                {
                    field: 'updatetime',
                    title: '最后更新时间'
                },
                {
                    field: 'status',
                    title: '状态',
                    formatter: function(value, row, index) {
                        switch (value) {
                            case '1':
                                return '<a href="javascript:setStatus(' + row.id + ', 0)" class="btn btn-success btn-xs" title="点击关闭">已启用</a>';
                                break;
                            default:
                                return '<a href="javascript:setStatus(' + row.id + ', 1)" class="btn btn-warning btn-xs" title="点击启用">已关闭</a>';
                                break;
                        }
                    }
                },
                {
                    field: '',
                    title: '操作',
                    formatter: function(value, row, index) {
                        var html = '<a href="javascript:editframe(' + row.id + ')" class="btn btn-info btn-xs">编辑</a> <a href="javascript:delItem(' + row.id + ')" class="btn btn-danger btn-xs">删除</a> <a href="javascript:checkItem(' + row.id + ')" class="btn btn-default btn-xs" title="发送测试邮件">验证</a>';
                        return html;
                    }
                }
            ]
        })
    })

    function addframe() {
        $("#modal-store").modal('show');
        $("#modal-title").html("新增 SMTP 服务");
        $("#action").val("add");
        $("#id").val('');
        $("#name").val('');
        $("#smtp_host").val('');
        $("#smtp_port").val(25);
        $("#smtp_username").val('');
        $("#smtp_password").val('');
        $("#smtp_from").val('');
    }

    function editframe(id) {
        var ii = layer.load(2);
        $.ajax({
            type: 'GET',
            url: 'ajax_smtp.php',
            data: {
                act: 'info',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                layer.close(ii);
                if (data.code == 0) {
                    $("#modal-store").modal('show');
                    $("#modal-title").html("修改 SMTP 服务配置");
                    $("#action").val("edit");
                    $("#id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $("#smtp_host").val(data.data.smtp_host);
                    $("#smtp_port").val(data.data.smtp_port);
                    $("#smtp_username").val(data.data.smtp_username);
                    $("#smtp_password").val(data.data.smtp_password);
                    $("#smtp_from").val(data.data.smtp_from);
                    $("#smtp_from_name").val(data.data.smtp_from_name);
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
    }

    function save() {
        if ($("#name").val() == '' || $("#smtp_host").val() == '' || $("#smtp_port").val() == '' || $("#smtp_username").val() == '' || $("#smtp_password").val() == '') {
            layer.alert('请确保各项不能为空！');
            return false;
        }
        var ii = layer.load(2);
        $.ajax({
            type: 'POST',
            url: 'ajax_smtp.php?act=save',
            data: $("#form-store").serialize(),
            dataType: 'json',
            success: function(data) {
                layer.close(ii);
                if (data.code == 0) {
                    layer.alert(data.msg, {
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
    }

    function setStatus(id, status) {
        var ii = layer.load(2, {
            shade: [0.1, '#fff']
        });
        $.ajax({
            type: 'post',
            url: 'ajax_smtp.php',
            data: {
                act: 'set',
                id: id,
                status: status
            },
            dataType: 'json',
            success: function(ret) {
                layer.close(ii);
                if (ret.code != 0) {
                    alert(ret.msg);
                }
                searchSubmit();
            },
            error: function(data) {
                layer.close(ii);
                layer.msg('服务器错误');
            }
        });
    }

    function delItem(id) {
        var confirmobj = layer.confirm('你确实要删除此SMTP服务器吗？', {
            btn: ['确定', '取消']
        }, function() {
            var ii = layer.load(2);
            $.ajax({
                type: 'POST',
                url: 'ajax_smtp.php',
                data: {
                    act: 'del',
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    layer.close(ii);
                    if (data.code == 0) {
                        layer.alert(data.msg, {
                            icon: 1,
                            closeBtn: false
                        }, function() {
                            window.location.reload()
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
        }, function() {
            layer.close(confirmobj);
        });
    }

    function checkItem(id) {
        var adduid = $("input[name='uid']").val();
        layer.open({
            type: 1,
            area: ['350px'],
            closeBtn: 2,
            title: '验证 SMTP 配置信息',
            content: '<div style="padding:15px 15px 0 15px"><p>请输入邮箱地址，接收测试邮件，用于验证SMTP配置信息是否正确可用。</p><div class="form-group"><input class="form-control" type="text" name="content" value="" autocomplete="off" placeholder="请输入邮箱地址"></div></div>',
            btn: ['发送测试邮件', '取消'],
            yes: function() {
                var content = $("input[name='content']").val();
                if (content == '') {
                    $("input[name='content']").focus();
                    return;
                }
                var ii = layer.load(2, {
                    shade: [0.1, '#fff']
                });
                $.ajax({
                    type: 'POST',
                    url: 'ajax_smtp.php',
                    data: {
                        act: 'check',
                        id: id,
                        to: content
                    },
                    dataType: 'json',
                    success: function(data) {
                        layer.close(ii);
                        if (data.code == 0) {
                            layer.alert(data.msg, {
                                icon: 1
                            }, function() {
                                layer.closeAll();
                                searchSubmit()
                            });
                        } else {
                            layer.alert(data.msg, {
                                icon: 0
                            });
                        }
                    },
                    error: function(data) {
                        layer.close(ii);
                        layer.msg('服务器错误');
                    }
                });
            }
        });
    }
</script>

</body>

</html>