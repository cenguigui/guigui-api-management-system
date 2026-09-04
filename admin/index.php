
<?php
/**
 * api平台
**/
include("../includes/common.php");
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $system['ico'] ?>">
    <title><?=$system['sysname']?> - 总控端</title>
    <meta name="keywords" content="<?=$system['keywords']?>"/>
    <meta name="description" content="<?=$system['description']?>"/>
    <link rel="stylesheet" href="/assets/iframe/libs/layui/css/layui.css"/>
    <!--<link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/css/layui.css"/>-->
    <link rel="stylesheet" href="/assets/iframe/module/admin.css?v=318"/>
    <link rel="stylesheet" href="/assets/font/iconfont.css" media="all">
    <link rel="stylesheet" href="/assets/iframe/css/nprogress.css" media="all">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <!-- 头部 -->
    <div class="layui-header">
        <div class="layui-logo">
            <!--<img src="<?= $system['logo'] ?>"/>-->
            <img src="images/logo-sidebar.png"/>
        </div>
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="flexible" title="侧边伸缩"><i class="layui-icon layui-icon-shrink-right"></i></a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="refresh" title="刷新"><i class="layui-icon layui-icon-refresh-3"></i></a>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layadmin-flexible" lay-unselect="">
            <a href="/" target="_blank" title="前台">
            <i class="iconfont icon-JiuYueYa-logo"style="font-size:18px;">
            </i></a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="note" title="便签"><i class="layui-icon layui-icon-note"></i></a>
            </li>
            <li class="layui-nav-item layui-hide-xs" lay-unselect>
                <a ew-event="fullScreen" title="全屏"><i class="layui-icon layui-icon-screen-full"></i></a>
            </li>
            <li class="layui-nav-item layui-hide-xs" lay-unselect>
                <a ew-event="lockScreen" title="锁屏"><i class="layui-icon layui-icon-password"></i></a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a>
                    <cite><img src="https://q1.qlogo.cn/g?b=qq&nk=<?php echo $system['zzqq']; ?>&s=100&t=" class="layui-nav-img"><?=$name?></cite>
                </a>
                <dl class="layui-nav-child">
                    <dd lay-unselect><a ew-href="set.php?set=pwd">修改密码</a></dd>               
                    <hr>
                    <dd lay-unselect><a  href="javascript:logout()" style="text-align: center;">退出</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="theme" title="主题"><i class="layui-icon layui-icon-more-vertical"></i></a>
            </li>
        </ul>
    </div>

    <!-- 侧边栏 -->
    <div class="layui-side">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree arrow2" lay-filter="admin-side-nav" lay-shrink="_all">
                <li class="layui-nav-item">
                    <a><i class="layui-icon layui-icon-home"></i>&emsp;<cite>控制台</cite></a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="view.php">仪表盘</a></dd>
                    </dl>
                </li>
                
                <li class="layui-nav-item">
                    <a><i class="layui-icon layui-icon-set"></i>&emsp;<cite>系统管理</cite></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a lay-href="./set.php?set=site">网站设置</a>
                        </dd>
                        <dd>
                          <a lay-href="./set.php?set=theme">模板设置</a>
                        </dd>
                   </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon layui-icon-website"></i>&emsp;<cite>接口管理</cite></a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="api/addapi.php">增加接口</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon layui-icon layui-icon layui-icon-table"></i>&emsp;<cite>资源管理</cite></a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="active/write.php">添加资源</a></dd>
                        <dd><a lay-href="active/wrlist.php">资源列表</a></dd>                    
                    </dl>
                </li>
                
                <li class="layui-nav-item">
                    <a><i class="layui-icon layui-icon-link"></i>&emsp;<cite>友链管理</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child" style="">
                        <dd><a lay-href="yl/youlian.php?act=add">添加友链</a></dd>  
                        <dd><a lay-href="yl/youlian.php">友情链接</a></dd>                
                    </dl>
                </li>

                <li class="layui-nav-item">
                    <a lay-href="./set.php?set=pwd"><i class="layui-icon layui-icon-table"></i>&emsp;<cite>修改密码</cite></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- 主体部分 -->
    <div class="layui-body"></div>
    <!-- 底部 -->
    <div class="layui-footer layui-text"style="text-align: center;">
        copyright © <script
                        type="text/javascript">
                        document.write("Copyright © 2021-" + new Date().getFullYear() + "");
                    </script> <a href="https://api.cenguigui.cn" target="_blank">@笒鬼鬼</a> all rights reserved.
    </div>
</div>

<!-- 加载动画 -->
<div class="page-loading">
    <div class="ball-loader">
        <span></span><span></span><span></span><span></span>
    </div>
</div>

<!-- js部分 -->
<?php 
include "foot.php";
?> 
<script>
    layui.use(['index'], function () {
        var $ = layui.jquery;
        var index = layui.index;
        // 默认加载主页
        index.loadHome({
            menuPath: 'view.php',
            menuName: '<i class="layui-icon layui-icon-home"></i>'
        });
    });
    NProgress.start();
  function neeprog() {
  	NProgress.done();
  }
  window.onload=neeprog;
//退出
 function logout() {
        var ii = layer.msg('正在退出', {icon: 16, time: 0});
        $.ajax({
            type: "get",
            url: "auth.php?act=logout",
            dataType: 'json',
            success: function (data) {
                layer.close(ii);
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function () {
                        location.href = './login.php';
                    });

                }
            }
        });
    }

</script>
</body>
</html>