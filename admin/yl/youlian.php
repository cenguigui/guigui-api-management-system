<?php
/**
 * 友情链接
**/
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$title='友情链接';
include '../head.php';
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>

<div class="layui-fluid">
    <div class="layui-card">
        <?php
if($_GET['act'] == 'edit'){
$id=intval($_GET['id']);
$row=$DB->getRow("select * from api_youlian where id='$id' limit 1");
?>
        <div id="divLoading">
            <div class="layui-card-header">修改
                <?=$title;?>
            </div>
            <div class="layui-card-body layui-form">
                <form class="layui-form formBasForm" role="form">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="layui-form-item">
                        <label class="layui-form-label">友链名称</label>
                        <div class="layui-input-block">
                            <input class="layui-input" type="text" id="title" name="title"
                                value="<?php echo $row['title']; ?>" placeholder="友链名称">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">友链图标</label>
                        <div class="layui-input-block">
                            <input class="layui-input" type="text" id="icon" name="icon"
                                value="<?php echo $row['icon']; ?>" placeholder="友链图标">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">友链链接</label>
                        <div class="layui-input-block">
                            <input class="layui-input" type="text" id="domain" name="domain"
                                value="<?php echo $row['domain']; ?>" placeholder="友链链接">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">友链描述</label>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea" id="content" name="content" placeholder="友链描述"
                                rows="5"><?php echo htmlspecialchars($row['content']); ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button type="button" class="layui-btn" lay-filter="edit" lay-submit>确 定</button>
                        <button type="button" class="layui-btn layui-btn-primary"
                            onclick="javascript:history.back(-1);return false;">返 回</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php }elseif($_GET['act'] == 'add'){ ?>
<div id="divLoading">
    <div class="layui-card-header">添加
        <?=$title;?>
    </div>
    <div class="layui-card-body layui-form">
        <form class="layui-form formBasForm" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">友链名称</label>
                <div class="layui-input-block">
                    <input class="layui-input" type="text" id="title" name="title" placeholder="友链名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">友链图标</label>
                <div class="layui-input-block">
                    <input class="layui-input" type="text" id="icon" name="icon" placeholder="友链图标">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">友链链接</label>
                <div class="layui-input-block">
                    <input class="layui-input" type="text" id="domain" name="domain" placeholder="友链链接">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">友链描述</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" id="content" name="content" placeholder="友链描述" rows="5"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button type="button" class="layui-btn" lay-filter="add" lay-submit>确 定</button>
                <button type="button" class="layui-btn layui-btn-primary"
                    onclick="javascript:history.back(-1);return false;">返 回</button>
            </div>
    </div>
</div>
</div>
</div>
<?php }else{?>
<div id="divLoading">
    <div class="layui-card-header">
        <?=$title;?>列表
    </div>
    <div class="layui-card-body layui-form">
        <form class="layui-form toolbar table-tool-mini">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label w-auto">搜索:</label>
                    <div class="layui-input-inline">
                        <input name="where" class="layui-input" type="text" placeholder="输入搜索内容" />
                    </div>
                </div>
                <div class="layui-inline" style="padding-right: 110px;">
                    <button class="layui-btn icon-layui-btn" lay-filter="roleTbSearch" lay-submit>
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                    <a href="./youlian.php?act=add" class="layui-btn icon-layui-btn">
                        <i class="layui-icon layui-icon-add-1"></i>添加
                    </a>
                </div>
            </div>
        </form>
        <table class="layui-hide" id="list" lay-filter="list"></table>
        <script id="table_button" type="text/html">
        <a lay-event="edit" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
        <a lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs"><i class="layui-icon layui-icon-delete"></i>删除</a>
    </script>
        <?php
}
?>

        <?php include '../foot.php';?>
        <script>
            layui.use(['layer', 'notice', 'form', 'table'], function () {
                var $ = layui.jquery;
                var layer = layui.layer;
                var notice = layui.notice;
                var form = layui.form;
                var table = layui.table;

                var insTb = table.render({
                    elem: '#list',
                    url: './yldate.php?act=youlianlist',
                    text: {
                        none: '哇哦没发现数据哟 T^T ！' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
                    },
                    page: true,
                    toolbar: ['<p>', '<button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del_table"><i class="layui-icon layui-icon-delete" style="font-size:20px;"></i>删除</button>&nbsp;', '</p>'].join(''),
                    cellMinWidth: 100,
                    limit: 10,
                    cols: [[{
                        type: 'checkbox',
                    },
                    {
                        field: 'id',
                        title: 'ID',
                        sort: true
                    },
                    {
                        field: 'title',
                        title: '名称',
                        sort: true
                    },
                    {
                        field: 'icon',
                        title: '图标',
                        sort: true
                    },
                    {
                        field: 'domain',
                        title: '链接',
                        sort: true
                    },
                    {
                        field: 'content',
                        title: '描述',
                        sort: true
                    },
                    {
                        field: 'date',
                        title: '时间',
                        sort: true
                    },
                    {
                        field: "action",
                        title: "功能操作",
                        toolbar: "#table_button",
                        width: 150
                    }]]
                });

                /* 表格搜索 */
                form.on('submit(roleTbSearch)', function (data) {
                    var ii = layer.msg("正在查找数据……", {
                        icon: 16
                    });
                    insTb.reload({
                        where: data.field,
                        page: {
                            curr: 1
                        }
                    });
                    layer.close(ii);
                    return false;
                });
                form.on('submit(add)', function (data) {
                    notice.msg('正在执行中..', { icon: 4, close: true });
                    $.ajax({
                        type: "POST",
                        url: "./yldate.php?act=addyoulian",
                        data: data.field,
                        dataType: "json",
                        success: function (data) {
                            notice.destroy();
                            if (data.code == 0) {
                                notice.success({
                                    title: '消息通知',
                                    message: data.msg,
                                    position: 'topCenter',
                                    audio: '2'
                                });
                            } else {
                                notice.error({
                                    title: '消息通知',
                                    message: data.msg,
                                    position: 'topCenter',
                                    audio: '2'
                                });
                            }
                        }
                    });
                    return false;
                });
                form.on('submit(edit)', function (data) {
                    notice.msg('正在执行中..', { icon: 4, close: true });
                    $.ajax({
                        type: "POST",
                        url: "./yldate.php?act=yleditSubmit",
                        data: data.field,
                        dataType: "json",
                        success: function (data) {
                            notice.destroy();
                            if (data.code == 0) {
                                notice.success({
                                    title: '消息通知',
                                    message: data.msg,
                                    position: 'topCenter',
                                    audio: '2'
                                });
                            } else {
                                notice.error({
                                    title: '消息通知',
                                    message: data.msg,
                                    position: 'topCenter',
                                    audio: '2'
                                });
                            }
                        }
                    });
                    return false;
                });

                /* 批量删除 */
                table.on('toolbar(list)', function (obj) {
                    if (obj.event === "del_table") {
                        var checkRows = table.checkStatus('list');
                        if (checkRows.data.length === 0) {
                            notice.warning({
                                title: '消息通知',
                                message: '请选择要删除的数据！',
                                position: 'topCenter',
                                audio: '2'
                            });
                            return;
                        }
                        var ids = checkRows.data.map(function (d) {
                            return d.id;
                        });

                        layer.confirm('确定要删除吗？', {
                            icon: 3, shade: 0.1, title: '提示'
                        },
                            function (index) {
                                $.ajax({
                                    type: 'POST',
                                    url: './yldate.php?act=delyoulian',
                                    data: { data: ids.join(',') },
                                    dataType: 'json',
                                    success: function (data) {
                                        if (data.code == 0) {
                                            insTb.reload();
                                            notice.success({
                                                title: '消息通知',
                                                message: data.msg,
                                                position: 'topCenter',
                                                audio: '2'
                                            });
                                        } else {
                                            notice.error({
                                                title: '消息通知',
                                                message: data.msg,
                                                position: 'topCenter',
                                                audio: '2'
                                            });
                                        }
                                    }
                                });
                                layer.close(index);
                            });
                    }
                });

                /* 表格工具栏 */
                table.on('tool(list)', function (obj) {
                    if (obj.event === "del") {
                        layer.confirm('你确实要删除此数据吗？', {
                            btn: ['确定', '取消'],
                            closebtn: 0,
                            icon: 3
                        },
                            function (index) {
                                $.ajax({
                                    type: "POST",
                                    url: "./yldate.php?act=delyoulian",
                                    data: {
                                        id: obj.data.id
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        if (data.code == 0) {
                                            notice.success({
                                                title: '消息通知',
                                                message: data.msg,
                                                position: 'topCenter',
                                                audio: '2'
                                            });
                                            insTb.reload();
                                        } else {
                                            notice.error({
                                                title: '消息通知',
                                                message: data.msg,
                                                position: 'topCenter',
                                                audio: '2'
                                            });
                                        }
                                    }
                                });
                                layer.close(index);
                            }, function () { });
                    } else if (obj.event === "edit") {
                        window.location.href = "youlian.php?act=edit&id=" + obj.data.id;
                    }
                });

            });
        </script>