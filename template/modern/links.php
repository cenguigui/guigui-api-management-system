<?php
/**
 * SH-API Style Premium Links Page - Refined & Localized
 */
include("../../includes/common.php");
$links = $DB->getAll("SELECT * FROM api_youlian ORDER BY id ASC") ?? [];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>合作伙伴 - <?= $system['title'] ?></title>
    <link rel="shortcut icon" href="<?= $system['ico'] ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#3b82f6' },
                    borderRadius: { '4xl': '2.5rem' }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', 'PingFang SC', sans-serif;
            background: #f8fafc;
            transition: background 0.5s ease;
            scroll-behavior: smooth;
        }

        .dark body {
            background: #0f172a;
            color: #f1f5f9;
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
            bottom: 40px;
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
            border-color: #3b82f6;
        }

        .dark .back-to-top {
            background: #1e293b;
            color: #3b82f6;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .dark .back-to-top:hover {
            background: #3b82f6;
            color: white;
        }
    </style>
</head>

<body class="dark:text-gray-100 min-h-screen hero-bg">
    <header class="fixed top-12 left-0 right-0 z-50 px-4">
        <div class="container mx-auto max-w-7xl">
            <div
                class="glass border border-white/30 dark:border-white/5 rounded-full px-4 py-3 flex items-center justify-between shadow-2xl">
                <a href="./" class="flex items-center gap-3 pl-4">
                    <div
                        class="h-9 w-9 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                        <i class="fas fa-cube text-lg"></i></div>
                    <span
                        class="text-xl font-black tracking-tight text-slate-800 dark:text-white uppercase"><?= $system['title'] ?></span>
                </a>
                <div class="flex items-center gap-3">
                    <button id="theme-toggle"
                        class="h-10 w-10 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/5 text-slate-500 shadow-sm"><i
                            class="fas fa-moon dark:hidden"></i><i class="fas fa-sun hidden dark:block"></i></button>
                    <a href="/"
                        class="hidden md:block font-black text-[10px] uppercase tracking-widest text-slate-400 hover:text-primary transition-colors italic">返回首页
                        (HOME)</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-48 pb-20 font-bold">
        <div class="container mx-auto px-6 max-w-7xl text-center">
            <h1 class="text-6xl font-black mb-10 text-slate-800 dark:text-white uppercase tracking-tighter italic">
                合作伙伴联盟</h1>
            <p class="text-slate-500 dark:text-slate-400 mb-20 font-black uppercase tracking-widest text-xs italic">
                与优秀的开发者及平台共同构建高效稳定的数据生态。</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($links as $item): ?>
                    <a href="<?= htmlspecialchars($item['domain']) ?>" target="_blank"
                        class="glass border border-white/50 dark:border-white/5 rounded-4xl p-10 hover:shadow-3xl hover:-translate-y-2 transition-all flex flex-col items-center group">
                        <img src="<?= htmlspecialchars($item['icon']) ?>"
                            class="h-24 w-24 rounded-3xl mb-8 shadow-2xl object-cover "
                            onerror="this.src='https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f310.png'">
                        <h3 class="text-xl font-black mb-3 group-hover:text-primary transition-colors">
                            <?= htmlspecialchars($item['title']) ?></h3>
                        <p
                            class="text-[10px] text-slate-400 dark:text-slate-500 mb-8 uppercase tracking-widest font-black italic">
                            <?= htmlspecialchars($item['content']) ?: '技术合作伙伴' ?></p>
                        <div
                            class="text-[10px] font-black uppercase tracking-[0.3em] text-primary/40 group-hover:text-primary transition-colors italic">
                            查看主站 <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="py-12 text-center text-[10px] font-black uppercase tracking-widest text-slate-400 italic">
        Powered by Hub & Intelligence. &copy; <?= date('Y') ?>
    </footer>

    <div id="btn-top" class="back-to-top" title="返回顶部"><i class="fas fa-arrow-up"></i></div>

    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        const themeBtn = document.getElementById('theme-toggle');
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.classList.add('dark');
        themeBtn.onclick = () => { document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); };

        $(window).scroll(function () { if ($(this).scrollTop() > 500) $('#btn-top').addClass('show'); else $('#btn-top').removeClass('show'); });
        $('#btn-top').click(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
    </script>
</body>

</html>