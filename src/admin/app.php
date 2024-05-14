<?php
$mod = 'admin';
include("../includes/common.php");
$title = '应用管理';
include './head.php';
if ($admin_islogin != 1) exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>

<div class="container" style="padding-top:70px;">
    <div class="col-md-12 center-block" style="float: none;">
        <form onsubmit="return searchSubmit()" method="GET" class="form-inline" id="searchToolbar">
            <div class="form-group">
                <label>搜索</label>
                <input type="text" class="form-control" name="id" placeholder="应用ID" style="width: 100px;" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="应用名称" style="width: 120px;" />
            </div>
            <div class="form-group">
                <!-- <label>类型</label> -->
                <select name="type" class="form-control">
                    <option value="">应用类型</option>
                    <option value="1">后台服务</option>
                    <option value="2">网站</option>
                    <option value="3">小程序</option>
                    <option value="4">APP</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索</button>
            <a href="javascript:searchClear()" class="btn btn-default" title="刷新应用列表"><i class="fa fa-refresh"></i> 重置</a>
            <a href="javascript:addApp()" class="btn btn-success"><i class="fa fa-plus"></i> 添加</a>
            <a href="../doc.php" class="btn btn-default" target="_blank"><i class="fa fa-info-circle"></i> 帮助</a>
        </form>

        <table id="listTable"></table>
    </div>
</div>

<form class="form-horizontal" id="form-store" style="padding:15px 15px 0 15px;display: none;">
    <input type="hidden" name="act" value="add" />
    <input type="hidden" name="id" value="" />
    <div class="form-group">
        <label class="col-sm-3 control-label">应用名称</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="app_name" value="" maxlength="128" autocomplete="off" placeholder="请输入应用名称">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">应用类型</label>
        <div class="col-sm-9">
            <select name="app_type" class="form-control">
                <option value="1">后台服务</option>
                <option value="2">网站</option>
                <option value="3">小程序</option>
                <option value="4">APP</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">服务类别</label>
        <div class="col-sm-9">
            <select name="smtp_id" class="form-control"></select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">应用密钥</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="app_secret" value="" maxlength="32" autocomplete="off" placeholder="留空则自动生成">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">发信人名称</label>
        <div class="col-sm-9">
            <input class="form-control" type="text" name="app_from_name" value="" maxlength="32" autocomplete="off" placeholder="为空时，发送人名称为应用名称">
        </div>
    </div>
</form>
<script src="//cdn.staticfile.org/layer/3.1.1/layer.js"></script>
<script src="//cdn.staticfile.org/bootstrap-table/1.20.2/bootstrap-table.min.js"></script>
<script src="//cdn.staticfile.org/bootstrap-table/1.20.2/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js"></script>
<script src="../assets/js/custom.js"></script>
<script>
    $(document).ready(function() {
        updateToolbar();
        loadOptions();
        const defaultPageSize = 15;
        const pageNumber = typeof window.$_GET['pageNumber'] != 'undefined' ? parseInt(window.$_GET['pageNumber']) : 1;
        const pageSize = typeof window.$_GET['pageSize'] != 'undefined' ? parseInt(window.$_GET['pageSize']) : defaultPageSize;

        $("#listTable").bootstrapTable({
            url: 'ajax_app.php?act=list',
            pageNumber: pageNumber,
            pageSize: pageSize,
            classes: 'table table-striped table-hover table-bordered',
            columns: [{
                    field: 'id',
                    title: 'AppID'
                },
                {
                    field: 'app_name',
                    title: '应用名称'
                },
                {
                    field: 'app_from_name',
                    title: '发信人名称'
                },
                {
                    field: 'smtp_id',
                    title: '服务ID',
                    formatter: function(value, row, index) {
                        return '<a href="smtp.php?id=' + row.smtp_id + '">' + row.smtp_id + '</a>';
                    }
                },
                {
                    field: 'app_type',
                    title: '类别',
                    formatter: function(value, row, index) {
                        switch (String(value)) {
                            case '1':
                                return '后台服务';
                                break;
                            case '2':
                                return '网站';
                                break;
                            case '3':
                                return '小程序';
                                break;
                            case '4':
                                return 'APP';
                                break;
                            default:
                                return '-未分类-'
                        }
                    }
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
                        var html = '<a href="javascript:showAppSecret(' + row.id + ')" class="btn btn-info btn-xs">密钥</a> <a href="javascript:updateApp(' + row.id + ')" class="btn btn-info btn-xs">编辑</a> <a href="javascript:delApp(' + row.id + ')" class="btn btn-danger btn-xs">删除</a> <a href="./record.php?appid=' + row.id + '" class="btn btn-default btn-xs">发送记录</a>';
                        return html;
                    }
                },
            ],
        })
    })

    function loadOptions(id) {
        $.ajax({
            type: 'GET',
            url: 'ajax_smtp.php',
            data: {
                act: 'options'
            },
            dataType: 'json',
            success: function(data) {
                if (data.code == 0) {
                    console.log('data.data', data.data);
                    var html_options = '';
                    data.data.forEach(i => {
                        html_options += '<option value="' + i.id + '">' + i.name + '</option>';
                    });
                    $('#form-store select[name="smtp_id"]').append(html_options);
                }
            }
        });
    }

    function addApp() {
        $("#form-store")[0].reset();
        $("#form-store input[name='act']").val('add');
        layer.open({
            type: 1,
            area: ['430px'],
            closeBtn: 2,
            title: '添加授权应用',
            content: $('#form-store'),
            btn: ['保存', '取消'],
            yes: function() {
                var app_name = $("#form-store input[name='app_name']").val();
                var app_type = $("#form-store select[name='app_type']").val();
                if (app_name == '') {
                    $("#form-store input[name='app_name']").focus();
                    return;
                } else if (app_type == '') {
                    $("#form-store select[name='app_type']").focus();
                    return;
                }
                var ii = layer.load(2, {
                    shade: [0.1, '#fff']
                });
                $.ajax({
                    type: 'POST',
                    url: 'ajax_app.php',
                    data: $("#form-store").serialize(),
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

    function updateApp(id) {
        $("#form-store")[0].reset();
        $("#form-store input[name='id']").val(id);
        $("#form-store input[name='act']").val('update');
        var ii = layer.load(2);
        $.ajax({
            type: 'GET',
            url: 'ajax_app.php',
            data: {
                act: 'info',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                layer.close(ii);
                if (data.code == 0) {
                    $("#form-store input[name='app_name']").val(data.data.app_name);
                    $("#form-store select[name='app_type']").val(data.data.app_type);
                    $("#form-store input[name='app_secret']").val(data.data.app_secret);
                    $("#form-store input[name='app_from_name']").val(data.data.app_from_name);
                    $("#form-store select[name='smtp_id']").val(data.data.smtp_id);
                    layer.open({
                        type: 1,
                        area: ['430px'],
                        closeBtn: 2,
                        title: '编辑授权应用',
                        content: $('#form-store'),
                        btn: ['保存', '取消'],
                        yes: function() {
                            var app_name = $("#form-store input[name='app_name']").val();
                            var app_type = $("#form-store select[name='app_type']").val();
                            if (app_name == '') {
                                $("#form-store input[name='app_name']").focus();
                                return;
                            } else if (app_type == '') {
                                $("#form-store select[name='app_type']").focus();
                                return;
                            }
                            var ii = layer.load(2, {
                                shade: [0.1, '#fff']
                            });
                            $.ajax({
                                type: 'POST',
                                url: 'ajax_app.php',
                                data: $("#form-store").serialize(),
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

    function showAppSecret(id) {
        var ii = layer.load(2);
        $.ajax({
            type: 'GET',
            url: 'ajax_app.php',
            data: {
                act: 'info',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                layer.close(ii);
                if (data.code == 0) {
                    layer.open({
                        title: '查看应用密钥(AppSecret)',
                        content: data.data.app_secret,
                    });
                }
            }
        });
    }

    function setStatus(id, status) {
        var ii = layer.load(2, {
            shade: [0.1, '#fff']
        });
        $.ajax({
            type: 'post',
            url: 'ajax_app.php',
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

    function delApp(id) {
        layer.confirm('确定要删除此应用吗 ？', {
            icon: 3,
            btn: ['确定', '取消']
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'ajax_app.php',
                data: {
                    act: 'del',
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.code == 0) {
                        layer.msg('删除成功', {
                            icon: 1,
                            time: 1000
                        });
                        searchSubmit();
                    } else {
                        layer.alert(data.msg, {
                            icon: 2
                        });
                    }
                }
            });
        });
    }
</script>
</body>
</html>