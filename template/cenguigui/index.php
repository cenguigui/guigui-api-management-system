<?php

/**
 * 首页模版
 * 列表搜索，显示
 * 加载侧栏，打赏，播放器，访客
 **/
// 引入数据库文件
include("./includes/common.php");
// 引入统计
include("./includes/api_stats.php");

// 接口数量
$count = $DB->getColumn("SELECT count(id) FROM `api_apilist`");
// 关闭-维护接口数量
$weihu = $DB->getColumn("SELECT count(id) FROM `api_apilist` WHERE `status`='0'");
// 可用接口数量
$keyong = $DB->getColumn("SELECT count(id) FROM `api_apilist` WHERE `status`='1'");
// 累积调用
$content = $DB->getRow("SELECT count(id) FROM `api_apilist`");
// 总调用
// $views = $DB->getColumn("SELECT SUM(views) FROM `api_apilist` WHERE `status`='1'");
$views = $DB->getColumn("SELECT SUM(views) FROM `api_apilist`");
// 友链
$links = $DB->getAll("SELECT * FROM api_youlian ORDER BY id ASC");
// 接口列表
$apilist = $DB->getAll("SELECT * FROM `api_apilist` order by `views` desc");

/** 开启gzip压缩 */
ob_start('ob_gzhandler');

@header('Content-Type: text/html; charset=UTF-8');
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
  ╔══ ∪∪∪═   <?= $system['title'] ?>     ══∪∪∪═╗
-->
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="baidu_union_verify" content="798b2f00ad9bdb7c4933884b1b6a50d8">
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
    <!--页面样式-->
    <link href="<?= theme ?>css/new.css" rel="stylesheet">
    <!--侧栏导航-->
    <link href="<?= theme ?>css/sidenav.css" rel="stylesheet">
    <!--<link href="<?= theme ?>css/site.min.css" rel="stylesheet">-->
    <!--<link href="<?= theme ?>css/oneui.css" rel="stylesheet">-->
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!--加载弹窗组件样式-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/css/layui.css" rel="stylesheet">
    <script src="<?= theme ?>js/new.js"></script>
    <!--加载jquery-->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/layui.js"></script>
    <!--iconfont-阿里巴巴矢量图标库-->
    <script src="<?= $system['icon_iconfont'] ?>" type="text/javascript" charset="utf-8"></script>

</head>

<body>
    <!-- 加载动画 -->
    <div class="loader">
        <div class="spinner"></div>
    </div>

    <!-- 主题切换动画 -->
    <div class="theme-switch-animation">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="moon-icon">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sun-icon">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
    </div>

    <!-- 背景动效 -->
    <div class="bg-animation">
        <div class="bg-gradient"></div>
        <div class="bg-gradient"></div>
    </div>

    <!-- 头部导航 -->
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <a href="/" class="logo">
                    <!--<div class="logo-icon">API</div>-->
                    <!--<div class="logo-text"><?= $system['title'] ?></div>-->
                    <img class="logo-icon" src="<?= $system['logo'] ?>" alt="<?= $system['sysname'] ?>"></a>
                </a>

                <nav class="nav-links">
                    <a href="/" class="nav-link active">首页</a>
                    <a class="nav-link" id="showNoticeButton">查看公告</a>
                    <a href="<?= $system['qqlink'] ?>" class="nav-link" target="_blank">联系站长/申请友链/咨询源码</a>
                    <!--<a href="<?= $system['qqlink'] ?>" class="nav-link" target="_blank">接口购买</a>-->
                </nav>
                <div class="header-actions">
                    <!-- 仅在移动端显示 -->
                    <button class="header-btn mobile-menu-btn" id="mobile-menu-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <button class="header-btn" id="theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- 主要内容 -->
    <main class="main">
        <div class="container">
            <!-- 头部区域 -->
            <section class="hero">
                <h1 class="waptxt"><a href="/"><?= $system['title'] ?></a></h1>
                <p class="hero-subtitle">笒鬼鬼自用API数据接口调用服务平台、平台稳定、快速、 API 接口服务<br>
                    <span class="package-amount">
                        共 <strong><span style="color: #00BFFF; "><?= $count ?></span> </strong>个接口 ·
                        有<strong><span style="color: #ff0000; "><?= $weihu ?></span> </strong>个接口关闭 ·
                        可用<strong><span style="color: #00BFFF; "><?= $keyong ?></span> </strong>个接口 ·
                        今日调用 <span style="color: #FF8C00; "><?php echo number_format(getTodayTotalCalls()); ?></span> 次 ·
                        累积调用 <span style="color: #00cb7d; "><?php echo number_format(getAllTimeTotalCalls()); ?></span> 次
                    </span>
                </p>
                <p class="hero-subtitle" id="time-and-date">
                    本站已安全运行449天7时7分39秒
                </p>
                <script id="CenGuiGuiApi" time='<?= $system['run_time'] ?>' src="<?= theme ?>js/time.js" type="text/javascript"></script>
            </section>

            <!-- 搜索栏 -->
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="搜索API如：一言">
                <button class="search-btn">
                    <!--<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"-->
                    <!--    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">-->
                    <!--    <circle cx="11" cy="11" r="8"></circle>-->
                    <!--    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>-->
                    <!--</svg>-->
                </button>
            </div>

            <!-- 新增：搜索结果统计 -->
            <div class="search-results" style="margin: 10px 0; text-align: center; display: none;">
                找到 <span class="result-count">0</span> 个与 "<span class="search-keyword"></span>" 相关的API接口
            </div>

            <!-- 文档卡片网格 -->
            <div class="tools-grid">
                <?php foreach ($apilist as $row) { ?>
                    <!-- 单个文档卡片 -->
                    <div class="tool-card">
                        <!--<a href="/api/<?= $row['alias'] ?>.html" target="_blank" class="tool-link" title="<?= $row['name'] ?>">-->
                        <a href="<?= $row['status'] == 1 ? '/api/' . $row['alias'] . '.html' : 'javascript:void(0);' ?>"
                            onclick="<?= $row['status'] != 1 ? 'showNotification(\'该接口已关闭，需要源码请联系' . $system['title'] . '购买\'); return false;' : '' ?>"
                            target="_blank"
                            class="tool-link"
                            title="<?= $row['name'] ?>">
                            <div class="tool-header">
                                <!-- 文档图标-->
                                <div class="tool-icon">
                                    <svg class="guigui_icon" aria-hidden="true"
                                        style="width:40px; height:40px;margin:5px;">
                                        <use xlink:href="#<?= $row['faimg'] ?>"></use>
                                    </svg>
                                </div>
                                <!-- 文档标题和标签 -->
                                <div class="tool-title">
                                    <h3 class="tool-name"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= $row['name'] ?></h3>
                                    <span class="tool-tag"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 26" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>累计调用：<?= $row['views'] ?>次</span>
                                </div>
                            </div>
                            <!-- 文档描述 -->
                            <p class="tool-description"
                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= $row['desc'] ?></p>
                            <!-- 文档元数据（状态和用户数） -->
                            <div class="tool-meta">
                                <div class="tool-status">
                                    <span class="status-dot" style="background: <?= $row['status'] == 1 ? '#28a745' : '#dc3545'; ?>; 
                                        animation: status-pulse-normal 2s infinite;"></span>
                                    <span class="status-text" style="font-weight: bold; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
                                        color: <?= $row['status'] == 1 ? '#28a745' : '#dc3545'; ?>;">
                                        <?= $row['status'] == 1 ? '运行中' : '已关闭'; ?> </span>
                                </div>
                                <div class="tool-usage" style="display: flex; align-items: center; gap: 4px;">
                                    <span
                                        style="font-weight: bold; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
                                        color: #0958d9; background: #e6f4ff; border: 1px solid #91caff; padding: 0 4px; border-radius: 4px;">
                                        免费接口 </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>

    </main>

    <div class="wapnone fk_service">
        <ul>
            <li>
                <div class="fk_service_consult_cont1" style="display: none;">
                    <span class="fk_service_triangle"></span>在线咨询
                </div>
            </li>
            <li class="fk_service_box fk_service_consult">
                <div class="fk_service_consult_cont"><span class="fk_service_triangle"></span>
                    <div class="fk_service_consult_cont_top">
                        <span class="fk_service_hint">
                            <span class="fk_service_icon"></span>
                            <span>如遇问题，请联系站长</span>
                        </span>
                        <span class="fk_service_button"
                            onclick="window.open('<?= $system['qqlink'] ?>')">QQ联系</span>
                        <span class="fk_service_button"
                            onclick="window.open('http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?= $system['qqmail'] ?>')">发送邮件</span>
                    </div>
                    <span class="fk_service_phone">添加时请注明来意</span>
                    <span class="fk_service_check_site">
                        <span class="fk_service_icon"></span>
                        <span onclick="window.open('<?= $system['qqlink'] ?>')">开源购买</span>
                    </span>
                </div>
            </li>
            <!--<li class="fk_service_box fk_service_ax" onclick="AddFavorite(window.location,document.title)">-->
            <!--    <div class="fk_service_ax_cont"><span class="fk_service_triangle"></span>点击收藏本站</div>-->
            <!--</li>-->
            <li class="fk_service_box fk_service_dh" onclick="window.open('<?= $system['qunurl'] ?>')">
                <div class="fk_service_dh_cont"><span class="fk_service_triangle"></span>笒鬼鬼Api交流群</div>
            </li>
            <li class="fk_service_box fk_service_dz" onclick="Reward(window.location,document.title)">
                <div class="fk_service_dz_cont"><span class="fk_service_triangle"></span>打赏站长</div>
            </li>
            <a class="fk_service_box fk_service_upward" href="#" id="top" rel="go-top"></a>
            <li class="fk_service_box fk_service_upward" onclick="scrollToTop();" style="display: block;">
                <div class="fk_service_upward_cont"><span class="fk_service_triangle"></span><span>返回顶部</span></div>
            </li>
        </ul>
    </div>

    <script>
        /* 打赏提示 */
        function Reward(sURL, sTitle) {
            sURL = encodeURI(sURL);
            try {
                window.external.addFavorite(sURL, sTitle);
            } catch (e) {
                try {
                    window.sidebar.addPanel(sTitle, sURL, "");
                } catch (e) {
                    // 使用 layer.open 展示包含图片的消息框
                    layer.open({
                        title: '感谢支持！',
                        btn: ['已支持'], // 按钮
                        area: ['600px', '360px'],
                        content: '<div style="display: flex; justify-content: space-between; text-align: center;">' +
                            '<div>' +
                            '<img src="<?= $system['zfbskm'] ?>" alt="支付宝" style="width:180px;height:180px;">' +
                            '<p style="margin-top: 10px; font-size: 14px; color: #333;">支付宝打赏</p>' +
                            '</div>' +
                            '<div>' +
                            '<img src="<?= $system['wxskm'] ?>" alt="微信" style="width:180px;height:180px;">' +
                            '<p style="margin-top: 10px; font-size: 14px; color: #333;">微信打赏</p>' +
                            '</div>' +
                            '<div>' +
                            '<img src="<?= $system['qqskm'] ?>" alt="QQ" style="width:180px;height:180px;">' +
                            '<p style="margin-top: 10px; font-size: 14px; color: #333;">QQ打赏</p>' +
                            '</div>' +
                            '</div>'
                    });
                }
            }
        }
    </script>

    <!--底部-->
    <footer class="footer">
        <div class="container">
            <!-- 友情链接部分 -->
            <div class="footer-section">
                <h4 class="footer-heading">友情链接</h4>
                <div class="footer-links-grid">
                    <?php foreach ($links as $item) { ?>
                        <a href="<?= htmlspecialchars($item['domain']) ?>" target="_blank" class="footer-card" title="<?= htmlspecialchars($item['content']) ?>">
                            <!-- 使用方案一的占位图 -->
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='10' fill='%23f0f2f5'/%3E%3Ccircle cx='50' cy='40' r='20' fill='%23d9e1e8'/%3E%3Crect x='30' y='70' width='40' height='10' rx='5' fill='%23d9e1e8'/%3E%3C/svg%3E"
                                data-src="<?= htmlspecialchars($item['icon']) ?>"
                                alt="<?= htmlspecialchars($item['title']) ?>"
                                class="lazy-load"
                                loading="lazy"
                                onerror="this.onerror=null;this.classList.add('error');this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Crect width=\'100\' height=\'100\' rx=\'10\' fill=\'%23f8f9fa\'/%3E%3Cpath d=\'M30,30 L70,70 M70,30 L30,70\' stroke=\'%23dc3545\' stroke-width=\'6\' stroke-linecap=\'round\'/%3E%3Ctext x=\'50\' y=\'90\' font-size=\'12\' text-anchor=\'middle\' fill=\'%236c757d\'%3E加载失败%3C/text%3E%3C/svg%3E';">
                            <span><?= htmlspecialchars($item['title']) ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
            
            <!-- 关于我们部分 -->
            <div class="footer-section">
                <div class="about-section">
                    <h4 class="about-heading">
                        <div class="huliku_beat_heart">
                            <div class="huliku_beat_left"></div>
                            <div class="huliku_beat_right"></div>
                        </div>
                        关于 <a href="/" target="_blank"><?= $system['title'] ?></a>
                    </h4>

                    <div class="about-content">
                        <p>
                            <strong><?= $system['title'] ?> </strong>：是由 <a href="/" target="_blank">笒鬼鬼</a> 支持并维护的免费 API
                            接口项目，旨在为用户提供稳定、高效的 API 服务。
                        </p>
                        <p>
                            本网站提供的 API 为个人兴趣开发，仅供学习交流使用。特此声明：开发过程中未进行任何破解行为，仅对目标站点的官方 API 进行了封装，所有数据均直接来源于目标站点官方。本人不对站点内容承担任何责任。
                        </p>
                        <p>
                            <strong>免责声明</strong>：任何单位或个人因使用本 API
                            所引发的任何意外、疏忽、违约、诽谤、版权或知识产权侵权等问题，以及由此产生的任何直接、间接、附带或衍生损失，本网站均不承担任何法律责任，一切后果由使用者自行承担。
                        </p>
                        <p>
                            如有任何反馈或建议，欢迎发送邮件至：<a href="mailto:<?= $system['qqmail'] ?>"><?= $system['qqmail'] ?></a>。
                        </p>
                    </div>

                    <div class="footer-brand">
                        <div class="brand-name"><?= $system['title'] ?></div>
                        <!--<div class="brand-tagline">此页面由<?= $system['title'] ?>技术支持</div>-->
                        <!-- 版权信息部分 -->
                        <div class="footer-section">
                            <div class="copyright-info">
                                <script type="text/javascript">
                                    document.write("Copyright © 2021-" + new Date().getFullYear() + "");
                                </script>
                                <?= $system['title'] ?> - 数据接口调用服务平台、平台稳定、快速、 API 接口服务
                            </div>
                        </div>
                    </div>

                    <div class="guigui-beian">
                        <svg t="1748675227758" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4648" width="23" height="23">
                            <path d="M778.24 163.84c-76.8-40.96-165.888-61.44-269.312-61.44s-192.512 20.48-269.312 61.44h-133.12l23.552 337.92c8.192 113.664 67.584 217.088 162.816 280.576l215.04 144.384 215.04-144.384c96.256-63.488 155.648-166.912 163.84-280.576l23.552-337.92H778.24z m47.104 333.824c-7.168 94.208-56.32 181.248-135.168 233.472l-181.248 120.832L327.68 731.136c-78.848-53.248-129.024-139.264-135.168-233.472L173.056 225.28h136.192v-26.624c58.368-23.552 124.928-34.816 199.68-34.816s141.312 12.288 199.68 34.816V225.28H844.8l-19.456 272.384z" fill="#FF6A00" p-id="4649"></path>
                            <path d="M685.056 328.704v-46.08H455.68c2.048-4.096 6.144-9.216 11.264-15.36 5.12-7.168 9.216-12.288 11.264-15.36L419.84 240.64c-31.744 46.08-75.776 87.04-133.12 123.904 4.096 4.096 10.24 11.264 18.432 21.504l17.408 17.408c23.552-15.36 45.056-31.744 63.488-50.176 26.624 25.6 49.152 43.008 67.584 51.2-46.08 15.36-104.448 27.648-175.104 35.84 2.048 5.12 6.144 13.312 9.216 24.576 4.096 11.264 6.144 19.456 7.168 24.576l39.936-7.168v218.112H389.12V680.96h238.592v19.456h54.272V481.28H348.16c60.416-12.288 114.688-27.648 163.84-46.08 49.152 19.456 118.784 34.816 210.944 46.08 5.12-17.408 10.24-34.816 17.408-51.2-62.464-4.096-116.736-12.288-161.792-24.576 38.912-20.48 74.752-46.08 106.496-76.8z m-150.528 194.56h94.208v41.984h-94.208v-41.984z m0 78.848h94.208v41.984h-94.208v-41.984z m-144.384-78.848h94.208v41.984H390.144v-41.984z m0 78.848h94.208v41.984H390.144v-41.984zM424.96 326.656h182.272c-26.624 22.528-57.344 41.984-94.208 57.344-31.744-15.36-61.44-34.816-88.064-57.344z" fill="#FF6A00" p-id="4650"></path>
                        </svg>
                        <a href="https://beian.miit.gov.cn" target="_blank"><?= $system['icp'] ?></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script id="ApiTitle" ApiTitle='<?= $system['card_two'] ?>' src="<?= theme ?>js/cenguigui.js"></script>

    <script>
        // 笒鬼鬼新公告弹窗
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;

            // 储存弹窗Cookies(24小时一次)
            window.onload = function() {
                var s = document.cookie;
                if (s.indexOf('notice=1') != -1) return;
                var d = new Date();
                d.setHours(d.getHours() + 24);
                document.cookie = 'notice=1;expires=' + d.toGMTString();

                setTimeout(function() {
                    popnotice();
                }, 3000);
            };

            // 触发弹窗事件
            window.popnotice = function popnotice() {
                var pageWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                var popupWidth = Math.min(pageWidth * 0.8, 500);

                layer.open({
                    type: 1,
                    skin: 'modern-notice',
                    title: '<i class="layui-icon layui-icon-notice" style="margin-right:8px;"></i>最新公告',
                    closeBtn: 1,
                    area: popupWidth + 'px',
                    shade: 0.5,
                    shadeClose: true,
                    id: 'Mainnotice',
                    btn: ['联系笒鬼鬼', '我知道了'],
                    btnAlign: 'c',
                    moveType: 1,
                    content: `<?= $system['gonggao_whole'] ?>`,
                    success: function(layero) {
                        var btn = layero.find('.layui-layer-btn');
                        btn.find('.layui-layer-btn0').attr({
                            href: '<?= $system['qqlink'] ?>',
                            target: '_blank'
                        });
                    }
                });
            };

            $('#showNoticeButton').on('click', function() {
                popnotice();
            });
        });


        // 添加按钮到HTML中
        // document.body.innerHTML += '<button id="showNoticeButton" style="position:fixed;bottom:20px;right:20px;z-index:9999;" class="layui-btn layui-btn-normal">显示公告</button>';
        //笒鬼鬼新公告弹窗结束
    </script>
    <!--特效-->
    <?php
    include("特效.php");
    ?>
</body>

</html>