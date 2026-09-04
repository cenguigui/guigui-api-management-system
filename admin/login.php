<?php
/**
 * 登录美化
 **/
include ("../includes/common.php");
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (!empty($isAdmin))
    exit("<script language='javascript'>window.location.href='./';</script>");
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="applicable-device" content="pc, mobile">
    <meta name="renderer" content="webkit">
    <meta name="force-rendering" content="webkit">
    <title>登录 - 后台管理系统</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= $system['ico'] ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="stylesheet" href="/assets/iframe/css/login.css"/>
    <!--不放心可以使用本地的-->
     <!--<link rel="stylesheet" href="/assets/iframe/css/bootstrap.min.css"> -->
     <!--<link rel="stylesheet" href="/assets/iframe/libs/layui/css/layui.css"/>-->
    <!--加载美化组件-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!--加载弹窗组件样式-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/css/layui.css" rel="stylesheet">
    <!--加载jquery-->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<!--<script type="text/javascript" src="/api/djt/api?format=js&charset=utf-8"></script>-->
<body>
    <div class="row bg-white vh-100">
        <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block" style="background-image: url(https://e3f49eaa46b57.cdn.sohucs.com/2026/9/4/10/26/MTAwMTMxXzE3ODg0ODg3NjIxMTY=.jpg); background-size: cover;">
            
            <div class="d-flex vh-100">
                <div class="p-5 align-self-end">
                    <img src="images/logo.png" alt="logo">
                    <br><br>
                    <p class="text-white" id="hitokoto">人间忽晚，山河已秋~</p>
                </div>
            </div>

        </div>

        <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
            <div class="p-5">
                <div class="text-center">
                    <img alt="admin" src="images/logo-sidebar.png">
                </div>
                <p class="text-center text-muted"><small>请填写表单信息后进入系统</small></p>

                <div class="signin-form needs-validation" id="LAY-user-login" novalidate>
                    <div class="mb-3">
                        <label for="username">用户名</label>
                        <input type="text" name="username" id="username" placeholder="用户名" class="form-control"
                            onkeypress="elogin(event)" required>
                    </div>

                    <div class="mb-3">
                        <label for="password">密码</label>
                        <input type="password" name="password" id="password" placeholder="密码" class="form-control" onkeypress="elogin(event)" required>
                    </div>

                    <div class="mb-3 d-grid">
                        <button class="btn btn-primary" type="submit" id="login_submit">立即登录</button>
                    </div>
                </div>
                <p class="text-center text-muted mt-3">Copyright &copy; 2024 <a href="https://blog.cenguigui.cn" target="_blank" rel="noopener noreferrer">笒鬼鬼</a>. All right reserved</p>
            </div>
        </div>
    </div>
     <!--本地化-->
     <!--加载弹窗组件-->
    <script type="text/javascript" src="/assets/iframe/libs/layui/layui.js"></script>
    <script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
    <script src="/assets/iframe/js/nprogress.js"></script>
    
    <script>
        layui.use(['layer', 'form', 'admin', 'notice'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var admin = layui.admin;
            var notice = layui.notice;
            // 管理登录
            $("#login_submit").click(function () {
                var user = $("input[name='username']").val();
                var pass = $("input[name='password']").val();
                if (user == "") {
                    layer.msg("请输入用户名", { icon: 2, anim: 6, time: 1500 }, function () { $('.login').attr('disabled', false); $(".login").html("登 录"); });
                    return false;
                } else if (pass == "") {
                    layer.msg("请输入密码", { icon: 2, anim: 6, time: 1500 }, function () { $('.login').attr('disabled', false); $(".login").html("登 录"); });
                    return false;
                }
                $.ajax({
                    type: "post",
                    url: "auth.php?act=login",
                    data: { username: user, password: pass },
                    dataType: 'json',
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {
                                icon: 6
                                , time: 1000
                            }, function () {
                                var index = layer.msg('正在进入后台管理中心', { icon: 16, time: 0 });
                                location.href = 'index.php';
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                                , anim: 6
                                , time: 1000
                            }, function () { $('.login').attr('disabled', false); $(".login").html("登 录"); });
                        }
                    }
                });
            });
        });
        function elogin(event) {
            var code = event.charCode || event.keyCode;
            if (code == 13) {
                // $('.login').click();
                $('#login_submit').click(); // 触发登录按钮的点击事件
            }
        }
        NProgress.start();
        function neeprog() {
            NProgress.done();
        }
        window.onload = neeprog;

    </script>
</body>

</html>