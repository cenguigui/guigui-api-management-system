<?php

/**
 * 首页模版
 * 列表搜索，显示
 * 加载侧栏，打赏，播放器，访客
 **/
// 引入数据库文件
include("./includes/common.php");

$count = $DB->getColumn("SELECT count(id) FROM `api_apilist`");
$views = $DB->getColumn("SELECT SUM(views) FROM `api_apilist`");
$apilist = $DB->getAll("SELECT * FROM `api_apilist` order by `views` desc");
@header('Content-Type: text/html; charset=UTF-8');

// 统计
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
file_get_contents($protocol . "://" . $_SERVER['HTTP_HOST'] . '/api/tongji/?t=1');
?>
<!DOCTYPE html>
<!-- 
            ◢＼　 ☆　　 ／◣
    　  　∕　　﹨　╰╮∕　　﹨
    　  　▏　　～～′′～～ 　｜
    　　  ﹨／　　　　　　 　＼∕
    　 　 ∕ 　　●　　　 ●　＼
      ＝＝　○　∴·╰╯　∴　○　＝＝
    　    ╭──╮　　　　　╭──╮
  ╔══ ∪∪∪═   笒鬼鬼api     ══∪∪∪═╗
-->
<html data-theme="cenguigui_cn" lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <!--360Web漏洞检测-->
    <meta name="tianyu-site-verification" content="ae43dfb80d82838c7fa72d45dd06c542" />
    <!--360Web漏洞检测 end-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport"
        content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?= $system['title'] ?></title>
    <meta name="keywords" content="<?= $system['keywords'] ?>">
    <meta name="description" content="<?= $system['description'] ?>">
    <meta property="og:description" content="<?= $system['description'] ?>">
    <meta property="og:site_name" content="<?= $system['title'] ?>">
    <meta property="og:title" content="<?= $system['title'] ?>">
    <meta property="og:url" content="<?= url ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= $system['ico'] ?>">
    <!--<link rel="stylesheet" href="<?= theme ?>style/layui/css/layui.css">-->
    <link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.4/css/layui.min.css">
    <link rel="stylesheet" href="<?= theme ?>style/css/style.css">
    <!--<link href="<?= theme ?>style/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        rel="stylesheet">
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/sweetalert2/11.10.3/sweetalert2.min.js"></script>
    <!--iconfont-阿里巴巴矢量图标库-->
    <script src="<?= $system['icon_iconfont'] ?>" type="text/javascript" charset="utf-8"></script>
</head>
<!--定义背景图 --guigui_bg_img  -->
<!--https://api.cenguigui.cn/api/weibo/api.php?url=https://tvax4.sinaimg.cn/large/008DVBeIly1hvgf74px6lj31hc0u07bf.jpg&type=img-->

<body class="card_close" style="--guigui_bg_img: url('<?= $system['bg_img'] ?>');">
    <div style="background-color: rgba(0, 0, 0, 0.3);height: 100vh;width: 100vw;position: fixed;z-index: -1;top:0px;">
    </div>
    <div class="layui-fluid" style="padding: 0;margin: 0;">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2">
                <div class="hansheader">
                    <a class="hanlogo" href="/" title="<?= $system['sysname'] ?>">
                        <img class="logo" src="<?= $system['logo'] ?>" alt="<?= $system['sysname'] ?>"></a>
                    <ul class="rightico">
                        <li><a href="https://www.cenguigui.cn" target="_blank" title="笒鬼鬼博客">
                                <img src="./home.svg">
                                <span class="hans-hidden">联系站长</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2">
                <h1 style="margin-top: 10vh;text-align: center;">
                    <div class="layui-anim layui-anim-scaleSpring"><strong>
                            <?= $system['sysname'] ?>
                        </strong></div>
                </h1>
                <h4 style="text-align: center;margin-top: 26px;"><strong>免费为各站长提供API接口服务</strong></h4>
                <p style="text-align: center;font-weight: bold;">共 <span style="color:#ff7070;">
                        <?= $count ?>
                    </span>
                    个接口</p>
                <div class="hansdiv layui-anim layui-anim-scale">
                    <div class="hansgg">
                        <h3>站点公告</h3>
                        <h2 class="hanshr">
                            <?= $system['gonggao'] ?>
                            <h2>
                    </div>
                </div>
                <input id="search" type="text" placeholder="找不到？搜一下看看~" class="layui-input"
                    style="background: rgba(0, 0, 0, 0);color: #ffffff;margin-top: 30px;">
                <section class="theme-feature-container layui-anim layui-anim-upbit">
                    <ul id="api-list">
                        <?php foreach ($apilist as $row) { ?>
                        <li>
                            <a href="/api/<?= $row['alias'] ?>.html" target="_blank" title="<?= $row['name'] ?>">
                                <div class="item-box">
                                    <svg class="guigui_icon" aria-hidden="true"
                                        style="width:40px; height:40px;margin:5px;">
                                        <use xlink:href="#<?= $row['faimg'] ?>"></use>
                                    </svg>
                                    <!--<i class="fa fa-2x" style="color:#fff"></i>-->
                                    <h3>
                                        <?= $row['name'] ?>
                                    </h3>
                                    <span class="hans-hidden">
                                        <?= $row['remarks'] ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </section>
            </div>
        </div>
    </div>
    <!--侧栏-->
    <?php
        include("links/links.php");
    ?>
    <!--打赏-->
    <?php
        include("reward/reward.php");
    ?>
    <div class="footer">
        <ul>
            <li>
                <!--<a href="<?= $system['qunurl'] ?>" target="_blank" title="QQ交流群">-->
                <a href="JavaScript:;" id="guigui-PicBlackbox" data-pic="https://e3f49eaa46b57.cdn.sohucs.com/2026/9/4/10/2/MTAwMTMxXzE3ODg0ODczMzY5MzU=.png"
                    data-text="扫码加博主Q">
                    <i class="fa fa-qq fa-2x" style="color:#fff"></i><span class="hans-hidden">QQ</span></a>
            </li>
        </ul>
        <div class="hancentext">
            <p style="font-weight: bold;">
                <?= $system['sysname'] ?> 共被调用 <span style="color:#fa6400;">
                    <?= $views ?>
                </span> 次(调用统计不准)
            </p>
            <p><a href="https://beian.miit.gov.cn/" target="_blank">
                    <?= $system['icp'] ?>
                </a></p>
            <p><a class="left_nav" title="友情链接">友情链接</a></p>
            <p><a href="/" target="_blank">Copyright ©
                    <?= date('Y') ?>
                    <?= $system['sysname'] ?>
                </a></p>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md12">
            <svg class="hans-container" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28" preserveAspectRatio="none">
                <defs>
                    <path id="hans-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="hans-parallax">
                    <use xlink:href="#hans-wave" x="50" y="0" fill="rgba(224,233,239,.5)"></use>
                    <use xlink:href="#hans-wave" x="50" y="3" fill="rgba(224,233,239,.5)"></use>
                    <use xlink:href="#hans-wave" x="50" y="6" fill="rgba(224,233,239,.5)"></use>
                </g>
            </svg>
        </div>
    </div>
    <!--<script src="<?= theme ?>style/layui/layui.js"></script>-->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.4/layui.js"></script>
    <!--gonggao传入公告字段-->
    <script id="gonggaoScript" gonggao='<?= $system['gonggao_whole'] ?>' src="<?= theme ?>style/cenguigui.js">
    </script>
    <!--音效接口 笒鬼鬼api-->
    <!--<script src="https://api.cenguigui.cn/api/bjyinyue"></script>-->
    <!--音效接口 笒鬼鬼api  end-->
    <!-- 访客信息 -->
    <!--<script src="https://api.cenguigui.cn/api/fangke"></script>-->
    <!-- 访客信息 end-->
    <!--加载图片暗盒-->
    <!-- <script src="https://api.cenguigui.cn/assets/js/guigui-PictureBlackbox.min.js"></script> -->
    <!-- 引入音乐播放器插件开始 -->
    <!--<script src="https://cdn.cenguigui.cn/music/js/newindex.js"></script>-->
    <style>
        #GuiMusiczr {
            /* 距离网页右侧的距离，请根据需要自行更改 */
            right: 30px;
            /* 距离网页底部的距离，请根据需要自行更改 */
            bottom: 250px;
        }
    </style>
    <!-- 引入音乐播放器插件结束 -->
    <!--加载图片暗盒 end-->
    <!--笒鬼鬼播放器-->
    <!--<div id="music" key="64a2b85c43be6"></div>-->
    <!--<script id="xplayer" src="https://y.cenguigui.cn/Static/player14/js/player.js" key="64a2b85c43be6" m="1"></script>-->
    <!--<script id="xplayer" src="https://y.cenguigui.cn/Static/player12/js/player.js" key="64a2b85c43be6" m = "1"></script>-->

    <!--笒鬼鬼播放器 end-->
</body>

</html>