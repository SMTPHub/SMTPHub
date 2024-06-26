<?php
$mod = 'admin';
include("../includes/common.php");
if ($admin_islogin != 1) exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title = '发信记录';
include './head.php';
?>

<div class="container" style="padding-top: 50px;">
    <div class="col-xs-12 center-block" style="float: none;">
        <h3><?php echo $title; ?></h3>
        <div id="searchToolbar">
            <form onsubmit="return searchSubmit()" method="GET" class="form-inline">
                <input type="hidden" name="did">
                <div class="form-group">
                    <label>搜索</label>
                    <input type="text" class="form-control" name="appid" placeholder="应用ID" style="width: 80px;" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="smtp_id" placeholder="服务ID" style="width: 80px;" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="mail_to" placeholder="接收人" style="width: 120px;" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="mail_subject" placeholder="主题">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="mail_from" placeholder="发信人" style="width: 120px;" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> 搜索</button>&nbsp;
                    <a href="javascript:searchClear()" class="btn btn-default" title="刷新记录列表"><i class="fa fa-repeat"></i> 重置</a>&nbsp;
                </div>
            </form>
        </div>
        <table id="listTable"></table>
    </div>
</div>

<script src="<?php echo $cdnpublic; ?>layer/3.1.1/layer.js"></script>
<script src="<?php echo $cdnpublic; ?>bootstrap-table/1.20.2/bootstrap-table.min.js"></script>
<script src="<?php echo $cdnpublic; ?>bootstrap-table/1.20.2/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js"></script>
<script src="../assets/js/custom.js"></script>
<script>
    $(document).ready(function() {
        updateToolbar();
        const defaultPageSize = 15;
        const pageNumber = typeof window.$_GET['pageNumber'] != 'undefined' ? parseInt(window.$_GET['pageNumber']) : 1;
        const pageSize = typeof window.$_GET['pageSize'] != 'undefined' ? parseInt(window.$_GET['pageSize']) : defaultPageSize;

        $("#listTable").bootstrapTable({
            url: 'ajax_record.php',
            pageNumber: pageNumber,
            pageSize: pageSize,
            classes: 'table table-striped table-hover table-bordered',
            columns: [{
                    field: 'id',
                    title: 'ID',
                    formatter: function(value, row, index) {
                        return '<b>' + value + '</b>';
                    }
                },
                {
                    field: 'appid',
                    title: '应用ID',
                    formatter: function(value, row, index) {
                        return value ? '<a href="app.php?id=' + value + '">' + value + '</a>' : '-';
                    }
                },
                {
                    field: 'smtp_id',
                    title: '服务ID',
                    formatter: function(value, row, index) {
                        return '<a href="smtp.php?id=' + value + '">' + value + '</a>';
                    }
                },
                {
                    field: 'mail_to',
                    title: '接收人'
                },
                {
                    field: 'mail_subject',
                    title: '主题'
                },
                {
                    field: 'mail_from',
                    title: '发送人'
                },
                // {
                //     field: 'ip',
                //     title: 'IP',
                //     formatter: function(value, row, index) {
                //         return '<a href="https://m.ip138.com/iplookup.asp?ip=' + value + '" target="_blank" rel="noreferrer">' + value + '</a>';
                //     }
                // },
                {
                    field: 'mail_date',
                    title: '发送时间'
                },
                {
                    field: 'status',
                    title: '状态',
                    formatter: function(value, row, index) {
                        return value == 1 ? '<span class="label label-success">成功</span>' : '<span class="label label-default">失败</span>';
                    }
                },
                {
                    field: '',
                    title: '操作',
                    formatter: function(value, row, index) {
                        var html = '<a href="javascript:viewEmail(' + row.id + ')" class="btn btn-info btn-xs">预览</a>';
                        return html;
                    }
                }
            ]
        })
    });

    function viewEmail(id) {
        layer.open({
            type: 2,
            area: ['60%', '80%'],
            closeBtn: 2,
            title: '查看邮件内容',
            content: 'view.php?id=' + id
        });
        // var ii = layer.load(2);
        // $.ajax({
        //     type: 'GET',
        //     url: 'ajax_record.php',
        //     data: {
        //         act: 'info',
        //         id: id
        //     },
        //     dataType: 'json',
        //     success: function(data) {
        //         layer.close(ii);
        //         if (data.code == 0) {
        //             layer.open({
        //                 type: 1,
        //                 area: ['60%', '80%'],
        //                 closeBtn: 2,
        //                 title: '查看邮件内容',
        //                 content: data.data.mail_body
        //             })
        //         } else {
        //             layer.alert(data.msg, {
        //                 icon: 2
        //             })
        //         }
        //     },
        //     error: function(data) {
        //         layer.close(ii);
        //         layer.msg('服务器错误');
        //     }
        // });
    };
</script>

</body>

</html>