<?php
/**
 * SH-API Style Premium Theme Homepage - HTML Notice Support
 */
include("./includes/common.php");
include("./includes/api_stats.php");

$count = $DB->getColumn("SELECT count(id) FROM `api_apilist`") ?? 0;
$weihu = $DB->getColumn("SELECT count(id) FROM `api_apilist` WHERE `status`='0'") ?? 0;
$keyong = $DB->getColumn("SELECT count(id) FROM `api_apilist` WHERE `status`='1'") ?? 0;
$links = $DB->getAll("SELECT * FROM api_youlian ORDER BY id ASC") ?? [];
$apilist = $DB->getAll("SELECT * FROM `api_apilist` ORDER BY `views` DESC") ?? [];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $system['title'] ?> - 专业 API 服务平台</title>
    <link rel="shortcut icon" href="<?= $system['ico'] ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#3b82f6', dark: '#0f172a' },
                    borderRadius: { '4xl': '2.5rem' }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/css/layui.css">
    <script src="<?= $system['icon_iconfont'] ?>" type="text/javascript" charset="utf-8"></script>
    <style>
        body {
            font-family: 'Outfit', 'PingFang SC', sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.8);
        }

        .hero-bg {
            background-image: radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(255, 172, 199, 0.1) 0px, transparent 50%);
        }

        ::-webkit-scrollbar {
            width: 0;
            height: 0;
            background-color: transparent;
        }

        .back-to-top {
            position: fixed;
            bottom: 120px;
            right: 40px;
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: white;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.4s;
            opacity: 0;
            pointer-events: none;
            z-index: 9999;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .back-to-top.show {
            opacity: 1;
            pointer-events: auto;
        }

        .back-to-top:hover {
            transform: translateY(-8px);
            background: #3b82f6;
            color: white;
        }

        .dark .back-to-top {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        #notice-toast {
            position: fixed;
            bottom: 40px;
            left: 40px;
            width: 320px;
            z-index: 9998;
            transform: translateX(-120%);
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #notice-toast.show {
            transform: translateX(0);
        }

        .premium-toast {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 10001;
            transform: translateX(120%);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .premium-toast.show {
            transform: translateX(0);
        }

        /* 公告详情弹窗样式 */
        .notice-modal-content {
            border-radius: 2.5rem !important;
            overflow: hidden !important;
            background: white !important;
        }

        .dark .notice-modal-content {
            background: #1e293b !important;
        }
    </style>
</head>

<body class="dark:bg-dark dark:text-gray-100 transition-colors duration-500 hero-bg min-h-screen">
    <header class="fixed top-12 left-0 right-0 z-50 px-4">
        <div class="container mx-auto max-w-7xl">
            <div
                class="glass border border-white/30 dark:border-white/5 rounded-full px-4 py-3 flex items-center justify-between shadow-2xl">
                <div class="flex items-center gap-8">
                    <a href="./" class="flex items-center gap-3 pl-4">
                        <div
                            class="h-9 w-9 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                            <i class="fas fa-cube text-lg"></i>
                        </div>
                        <span
                            class="text-xl font-black tracking-tight text-slate-800 dark:text-white uppercase"><?= $system['title'] ?></span>
                    </a>
                    <nav class="hidden lg:flex items-center bg-slate-100/50 dark:bg-slate-800 rounded-full px-2 py-1">
                        <a href="./"
                            class="bg-white dark:bg-slate-700 shadow-sm px-6 py-2 rounded-full text-slate-800 dark:text-white font-bold text-sm flex items-center gap-2 font-black uppercase"><i
                                class="fas fa-home-alt"></i> 首页</a>
                        <button onclick="openNoticeModal()"
                            class="px-6 py-2 rounded-full text-slate-500 dark:text-slate-400 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2 font-black uppercase"><i
                                class="fas fa-bullhorn"></i> 查看公告</button>
                        <a href="<?= theme ?>links.php"
                            class="px-6 py-2 rounded-full text-slate-500 dark:text-slate-400 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2 font-black uppercase"><i
                                class="fas fa-layer-group"></i> 合作伙伴</a>
                    </nav>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative hidden sm:block">
                        <button id="open-search"
                            class="h-10 px-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-full flex items-center gap-3 text-xs font-bold border border-transparent hover:border-primary/20 transition-all">
                            <i class="fas fa-search"></i> 搜索接口 (Ctrl+K)
                        </button>
                    </div>
                    <button id="theme-toggle"
                        class="h-10 w-10 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/5 text-slate-500 shadow-sm"><i
                            class="fas fa-moon dark:hidden"></i><i class="fas fa-sun hidden dark:block"></i></button>
                    <a href="<?= $system['qqlink'] ?>" target="_blank"
                        class="bg-primary text-white px-6 py-2.5 rounded-full font-black text-sm shadow-xl shadow-primary/20 flex items-center gap-2 font-black uppercase">立即开始</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-48 pb-20">
        <div class="container mx-auto px-6 max-w-7xl text-center lg:text-left">
            <section class="mb-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in-up">
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-8">
                        <div
                            class="px-4 py-1.5 rounded-xl bg-white dark:bg-slate-800 shadow-sm text-primary text-[10px] font-bold uppercase tracking-widest border border-slate-100 dark:border-white/5">
                            稳定 (STABLE)</div>
                        <div
                            class="px-4 py-1.5 rounded-xl bg-white dark:bg-slate-800 shadow-sm text-primary text-[10px] font-bold uppercase tracking-widest border border-slate-100 dark:border-white/5">
                            高效 (EFFICIENT)</div>
                        <div
                            class="px-4 py-1.5 rounded-xl bg-white dark:bg-slate-800 shadow-sm text-primary text-[10px] font-bold uppercase tracking-widest border border-slate-100 dark:border-white/5">
                            安全 (SECURE)</div>
                    </div>
                    <h1
                        class="text-6xl md:text-7xl font-black mb-6 leading-tight text-slate-800 dark:text-white uppercase">
                        <span class="text-primary italic">API</span> Platform
                    </h1>
                    <p
                        class="text-xl text-slate-500 dark:text-slate-400 mb-12 font-bold leading-relaxed max-w-lg italic">
                        全方位的接口能力支持，打造数字化转型的枢纽核心。</p>
                    <div class="grid grid-cols-3 gap-8 text-center sm:text-left">
                        <div>
                            <div class="text-4xl font-black text-slate-800 dark:text-white mb-1"><?= $count ?></div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">接口总数</div>
                        </div>
                        <div>
                            <div class="text-4xl font-black text-slate-800 dark:text-white mb-1"><?= $keyong ?>+</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">目前可用</div>
                        </div>
                        <div>
                            <div class="text-4xl font-black text-slate-800 dark:text-white mb-1">99.9%</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">可用率</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end hidden lg:flex">
                    <div class="glass p-8 rounded-4xl border border-white/40 dark:border-white/5 shadow-2xl relative w-full max-w-[420px]"
                        id="weather-card">
                        <div id="weather-loading"
                            class="text-slate-400 font-bold flex items-center justify-center h-48 italic">正在同步实时环境数据...
                        </div>
                        <div id="weather-ui" style="display:none" class="animate-fade-in font-black italic">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <div class="flex items-center gap-2 text-primary text-xl"><i
                                            class="fas fa-location-dot"></i> <span id="w-city">--</span></div>
                                    <div class="text-slate-400 text-xs mt-2 uppercase tracking-tighter" id="w-type">--
                                    </div>
                                </div>
                                <div id="w-icon" class="text-4xl"></div>
                            </div>
                            <div class="flex justify-between items-end mb-8">
                                <div class="flex items-start"><span class="text-8xl font-black"
                                        id="w-temp">--</span><span class="text-3xl mt-4 ml-1">°C</span></div>
                                <div class="text-slate-400 text-sm mb-4"><i class="fas fa-thermometer-half mr-2"></i>体感
                                    <span id="w-feel">--</span>°
                                </div>
                            </div>
                            <div
                                class="flex justify-between py-6 border-y border-slate-100 dark:border-white/5 mb-6 text-center text-xs uppercase tracking-widest font-black">
                                <div class="flex-1"><i
                                        class="fas fa-droplet text-primary/40 block mb-2 text-base"></i><span
                                        id="w-humid">--</span>
                                    <div class="text-[8px] text-slate-400 mt-1">湿度</div>
                                </div>
                                <div class="flex-1 border-x border-slate-100 dark:border-white/5"><i
                                        class="fas fa-wind text-primary/40 block mb-2 text-base"></i><span
                                        id="w-wind">--</span>
                                    <div class="text-[8px] text-slate-400 mt-1">KM/H</div>
                                </div>
                                <div class="flex-1"><i class="fas fa-eye text-primary/40 block mb-2 text-base"></i><span
                                        id="w-vis">--</span>
                                    <div class="text-[8px] text-slate-400 mt-1">能见度</div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3"><span id="w-aqi"
                                        class="px-4 py-1.5 rounded-full text-white text-[10px] shadow-lg shadow-green-400/20 font-black">--</span><span
                                        class="text-slate-400 text-[10px] font-black" id="w-pm">PM2.5: --</span></div>
                                <span class="text-slate-400 text-[10px] uppercase tracking-widest font-black"
                                    id="w-desc">--</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <h2
                    class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-4 uppercase tracking-tighter">
                    <span class="h-10 w-2 bg-primary rounded-full"></span> 接口实验室 (LAB)
                </h2>
                <div
                    class="flex items-center gap-4 glass p-2 rounded-2xl border border-white/40 shadow-sm font-black text-sm">
                    <div
                        class="flex items-center gap-1.5 px-4 text-slate-400 border-r border-slate-100 dark:border-white/5 uppercase tracking-widest italic">
                        排序依据</div>
                    <select id="sort-order"
                        class="bg-transparent border-none outline-none text-slate-800 dark:text-white cursor-pointer pr-4 uppercase tracking-widest italic">
                        <option value="heat" selected>最高点击 (HEAT)</option>
                        <option value="time">最新上线 (LATEST)</option>
                    </select>
                </div>
            </div>

            <div id="api-list-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php foreach ($apilist as $row): ?>
                    <div class="api-item group cursor-pointer" data-name="<?= $row['name'] ?>"
                        data-views="<?= $row['views'] ?>" data-time="<?= strtotime($row['times'] ?: date('Y-m-d H:i:s')) ?>"
                        onclick="location.href='api.php?alias=<?= $row['alias'] ?>'">
                        <div
                            class="glass border border-white/40 dark:border-white/5 rounded-[2.5rem] p-8 h-full flex flex-col transition-all hover:shadow-3xl hover:-translate-y-3 relative overflow-hidden group-hover:border-primary/30">
                            <div class="flex items-center justify-between mb-8">
                                <div
                                    class="h-16 w-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center group-hover:bg-primary transition-all shadow-xl">
                                    <svg class="w-10 h-10 text-primary group-hover:text-white transition-all">
                                        <use xlink:href="#<?= $row['faimg'] ?>"></use>
                                    </svg>
                                </div>
                                <?php if ($row['status'] == 1): ?><span
                                        class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span><?php else: ?><span
                                        class="px-2 py-0.5 rounded font-black text-[10px] uppercase bg-red-100 text-red-600">OFF</span><?php endif; ?>
                            </div>
                            <h3
                                class="text-lg font-black text-slate-800 dark:text-white mb-2 truncate leading-tight group-hover:text-primary transition-colors">
                                <?= $row['name'] ?>
                            </h3>
                            <p
                                class="text-slate-400 dark:text-slate-500 text-xs line-clamp-2 h-8 leading-relaxed font-bold mb-8 italic">
                                <?= $row['remarks'] ?: '稳定驱动，高效集成。' ?>
                            </p>
                            <div
                                class="mt-auto flex items-center justify-between pt-6 border-t border-slate-100 dark:border-white/5">
                                <div class="flex items-center gap-1.5 font-bold text-xs text-slate-400"><i
                                        class="fas fa-fire text-orange-400"></i><span><?= number_format($row['views']) ?></span>
                                </div>
                                <div
                                    class="h-8 w-8 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer
        class="py-20 bg-white dark:bg-dark border-t border-slate-100 dark:border-white/5 text-center font-black uppercase tracking-widest text-[10px] text-slate-400">
        <div class="container mx-auto px-6 max-w-7xl flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="text-left leading-relaxed">
                <p class="mb-2 italic text-slate-800 dark:text-white">Professional Data Integration Hub.</p>
                <p>&copy; <?= date('Y') ?> <?= $system['title'] ?>. Powered by SH-API.</p>
            </div>
            <div class="flex gap-10 italic">
                <a href="<?= $system['qqlink'] ?>" class="hover:text-primary transition-colors">隐私政策</a>
                <a href="<?= $system['qqlink'] ?>" class="hover:text-primary transition-colors">使用条款</a>
                <span><?= $system['icp'] ?></span>
            </div>
        </div>
    </footer>

    <!-- 精致公告 Toast (图片同款) -->
    <div id="notice-toast"
        class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-3xl border border-slate-100 dark:border-white/5 flex items-start gap-4">
        <div
            class="h-12 w-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-600 dark:text-slate-200 text-xl">
            <i class="fas fa-bullhorn rotate-[-15deg]"></i>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-center mb-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">公告通知</span>
                <button onclick="closeNoticeToast()" class="text-slate-300 hover:text-red-500 transition-colors"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="text-sm font-black text-slate-800 dark:text-white mb-2 line-clamp-1">
                <?= strip_tags($system['gonggao_whole']) ?>
            </div>
            <button onclick="openNoticeModal()"
                class="text-[10px] font-black text-primary hover:underline uppercase tracking-widest italic flex items-center gap-2">查看详情
                <i class="fas fa-chevron-right text-[8px]"></i></button>
        </div>
    </div>

    <!-- 高级 Toast 提示 -->
    <div id="premium-toast"
        class="premium-toast bg-white dark:bg-slate-900 rounded-2xl px-6 py-4 shadow-3xl border border-slate-100 dark:border-white/10 flex items-center gap-3">
        <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs"><i
                class="fas fa-check"></i></div>
        <span class="text-xs font-black text-slate-800 dark:text-white italic tracking-wider uppercase"
            id="toast-msg">操作成功</span>
    </div>

    <!-- 搜索层 -->
    <div id="search-overlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xl opacity-0 pointer-events-none transition-all flex items-start justify-center pt-32 px-4 z-[9999]">
        <div id="search-modal"
            class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[2.5rem] shadow-3xl overflow-hidden border border-white/5 transition-all">
            <div class="p-8 border-b border-slate-100 dark:border-white/5 flex items-center gap-5">
                <i class="fas fa-search text-slate-300 text-xl"></i>
                <input type="text" id="search-input"
                    class="bg-transparent border-none outline-none flex-1 text-lg font-black text-slate-800 dark:text-white placeholder:text-slate-300"
                    placeholder="寻找您需要的 API 能力...">
                <button id="close-search"
                    class="text-[9px] font-black uppercase text-slate-400 border border-slate-200 dark:border-white/10 px-3 py-1.5 rounded-xl">ESC</button>
            </div>
            <div id="search-results" class="max-h-96 overflow-y-auto p-6 space-y-3 font-black">
                <div class="text-center py-12 text-slate-300 text-[10px] uppercase tracking-widest italic">Enter
                    Keywords To Trace...</div>
            </div>
        </div>
    </div>

    <div id="btn-top" class="back-to-top" title="返回顶部"><i class="fas fa-arrow-up"></i></div>

    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.6.8/layui.js"></script>
    <script>
        const themeBtn = document.getElementById('theme-toggle');
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.classList.add('dark');
        themeBtn.onclick = () => { document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); };

        $(window).scroll(function () { if ($(this).scrollTop() > 500) $('#btn-top').addClass('show'); else $('#btn-top').removeClass('show'); });
        $('#btn-top').click(() => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // 高级提示
        function showToast(msg = '操作成功') {
            const $t = $('#premium-toast'); $('#toast-msg').text(msg); $t.addClass('show');
            setTimeout(() => $t.removeClass('show'), 3000);
        }

        // 搜索逻辑
        const searchOverlay = $('#search-overlay');
        const openSearch = () => { searchOverlay.removeClass('opacity-0 pointer-events-none').addClass('search-open'); $('#search-input').focus(); };
        const closeSearch = () => { searchOverlay.addClass('opacity-0 pointer-events-none').removeClass('search-open'); };
        $('#open-search').click(openSearch);
        $('#close-search, #search-overlay').click((e) => { if (e.target.id === 'search-overlay' || e.target.id === 'close-search') closeSearch(); });
        $(document).keydown((e) => { if (e.keyCode === 27) closeSearch(); if (e.ctrlKey && e.keyCode === 75) { e.preventDefault(); openSearch(); } });

        $('#search-input').on('input', function () {
            const val = $(this).val().toLowerCase().trim();
            const results = $('#search-results');
            if (!val) { results.html('<div class="text-center py-12 text-slate-300 text-[10px] uppercase tracking-widest italic">Enter Keywords To Trace...</div>'); return; }
            const matches = $('.api-item').filter(function () { return $(this).data('name').toLowerCase().includes(val); });
            if (!matches.length) { results.html('<div class="text-center py-12 text-slate-300 text-[10px] uppercase tracking-widest italic">No Matches Found.</div>'); return; }
            results.empty();
            matches.each(function () {
                const item = $(this);
                const alias = item.attr('onclick').match(/'([^']+)'/)[1].split('=')[1];
                results.append(`<div onclick="location.href='api.php?alias=${alias}'" class="p-4 hover:bg-primary/5 dark:hover:bg-primary/10 rounded-2xl flex items-center justify-between cursor-pointer group transition-all">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all"><i class="fas fa-plug text-xs"></i></div>
                        <div><div class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-tight">${item.data('name')}</div><div class="text-[9px] text-slate-400 uppercase tracking-widest font-black italic">${item.data('views')} 热度数据</div></div>
                    </div>
                    <i class="fas fa-arrow-right text-xs text-slate-100 group-hover:text-primary transition-all"></i>
                </div>`);
            });
        });

        // 排序逻辑
        const sortApis = (order) => {
            const $grid = $('#api-list-grid');
            const $items = $('.api-item').get();
            $items.sort((a, b) => {
                const valA = order === 'heat' ? parseInt($(a).data('views')) : parseInt($(a).data('time'));
                const valB = order === 'heat' ? parseInt($(b).data('views')) : parseInt($(b).data('time'));
                return valB - valA;
            });
            $grid.empty().append($items);
        };
        $('#sort-order').change(function () { sortApis($(this).val()); });

        // 公告逻辑 - 兼容后台 HTML
        const noticeHTML = `<?= str_replace('`', '\`', $system['gonggao_whole']) ?>`;
        layui.use('layer', function () { window.layer = layui.layer; });

        function openNoticeModal() {
            layer.open({
                type: 1, skin: 'notice-modal-content',
                title: false, closeBtn: 0, shade: 0.7, shadeClose: true,
                area: ['min(90vw, 650px)', 'auto'], anim: 5,
                content: `<div class="p-0 dark:bg-slate-900 relative">
                    <button onclick="layer.closeAll()" class="absolute top-6 right-6 z-10 h-10 w-10 flex items-center justify-center bg-black/10 hover:bg-black/20 dark:bg-white/10 dark:hover:bg-white/20 rounded-full text-slate-600 dark:text-white transition-all"><i class="fas fa-times text-lg"></i></button>
                    <div class="notice-raw-html-container overflow-hidden rounded-[2.5rem]">
                        <style>
                            .notice-raw-html-container div {
                                background-color: #3b82f6 !important;
                                padding: 60px 40px !important;
                                color: white !important;
                                font-family: 'Outfit', sans-serif !important;
                            }
                            .notice-raw-html-container p {
                                text-indent: 0 !important;
                                margin-bottom: 1rem;
                                opacity: 0.9;
                            }
                            .notice-raw-html-container p:nth-child(2) {
                                font-size: 32px !important;
                                font-weight: 800 !important;
                                margin-bottom: 2rem !important;
                                color: white !important;
                                letter-spacing: -1px;
                            }
                            .notice-raw-html-container span {
                                font-size: 16px !important;
                            }
                            .notice-raw-html-container a {
                                color: white !important;
                                text-decoration: underline !important;
                                font-weight: 700;
                            }
                        </style>
                        ${noticeHTML}
                    </div>
                    <div class="p-10 pt-4 bg-white dark:bg-slate-900">
                        <button onclick="layer.closeAll()" class="w-full bg-primary py-5 rounded-2xl text-white text-xs font-black uppercase tracking-[0.4em] shadow-xl shadow-primary/20 hover:scale-[1.02] transition-all italic">我已阅读并知晓 (UNDERSTOOD)</button>
                    </div>
                </div>`,
                success: function (layero) { layero.css({ 'background': 'transparent', 'box-shadow': 'none' }); }
            });
        }

        function closeNoticeToast() { $('#notice-toast').removeClass('show'); }

        $(document).ready(() => {
            if (document.cookie.indexOf('notice=1') === -1) {
                setTimeout(() => $('#notice-toast').addClass('show'), 2000);
            }
            sortApis('heat');
        });

        // 天气加载
        async function loadWeather() {
            try {
                const res = await fetch('https://api.cenguigui.cn/api/WeatherInfo/tq.php');
                const d = await res.json();
                if (d.success) {
                    $('#weather-loading').hide(); $('#weather-ui').show();
                    $('#w-city').text(d.city); $('#w-temp').text(d.data.high.replace('°C', '')); $('#w-type').text(d.data.type);
                    $('#w-feel').text(parseInt(d.data.high) - 2); $('#w-humid').text('45%'); $('#w-wind').text('11'); $('#w-vis').text('34.1');
                    $('#w-aqi').text(`空气${d.air.aqi_name}`).css('background', d.air.aqi_value <= 50 ? '#00b894' : '#fdcb6e');
                    $('#w-pm').text(`PM2.5: ${Math.round(d.air.aqi_value * 0.7)}`); $('#w-desc').text(parseInt(d.data.high) > 20 ? 'WARM' : 'COOL');
                    const icons = { '晴': '<i class="fas fa-sun text-yellow-400"></i>', '多云': '<i class="fas fa-cloud-sun text-slate-400"></i>', '阴': '<i class="fas fa-cloud text-slate-500"></i>', '雨': '<i class="fas fa-cloud-showers-heavy text-blue-400"></i>' };
                    $('#w-icon').html(icons[d.data.type] || icons['晴']);
                }
            } catch (e) { }
        }
        document.addEventListener('DOMContentLoaded', loadWeather);
    </script>
</body>

</html>