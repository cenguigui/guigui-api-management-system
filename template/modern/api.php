<?php
/**
 * Professional High-Fidelity API Detail Page - Refined with Premium Feedback
 */
include("./includes/common.php");
include("./includes/api_stats.php");

$alias = trim(strip_tags(daddslashes($_GET['alias'])));
$content = $DB->getRow("SELECT * FROM `api_apilist` WHERE `alias`='{$alias}'");

if (empty($content)) {
    header("Location: ./index.php");
    exit;
}

ApiViews($alias);
updateApiStatsByAlias($alias);
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $content['name'] ?> - 接口中心 - <?= $system['title'] ?></title>
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
    <link rel="stylesheet"
        href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/themes/prism-tomorrow.min.css">
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

        pre[class*="language-"] {
            border-radius: 1.5rem;
            background: #0f172a !important;
            padding: 1.5rem !important;
            margin: 0 !important;
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
        }

        .dark .back-to-top {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* 吐司提示 (Top Right) */
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

        .lab-pane {
            min-height: 320px;
        }

        .input-dark {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 700;
            width: 100%;
            outline: none;
            transition: all 0.3s;
        }

        .dark .input-dark {
            background: #1e293b;
            border-color: #334155;
            color: #f1f5f9;
        }

        .input-dark:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .lab-btn-active {
            border-bottom: 3px solid #3b82f6;
            color: #3b82f6 !important;
        }

        .image-result {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="dark:bg-[#0f172a] dark:text-gray-100 transition-colors duration-500">
    <header class="fixed top-8 left-0 right-0 z-50 px-4">
        <div class="container mx-auto max-w-7xl">
            <div
                class="glass border border-white/30 dark:border-white/5 rounded-full px-6 py-3 flex items-center justify-between shadow-xl">
                <a href="./"
                    class="flex items-center gap-3 text-slate-800 dark:text-white font-black hover:text-primary transition-all group uppercase text-sm italic">
                    <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform mr-2"></i> 返回广场
                </a>
                <div class="flex items-center gap-4">
                    <button id="theme-toggle"
                        class="h-10 w-10 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/5 text-slate-500 shadow-sm"><i
                            class="fas fa-moon dark:hidden"></i><i class="fas fa-sun hidden dark:block"></i></button>
                    <a href="<?= theme ?>links.php"
                        class="hidden md:block font-black text-[10px] uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">合作伙伴
                        (PARTNERS)</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-36 pb-20">
        <div class="container mx-auto px-6 max-w-7xl">
            <!-- 头部卡片 -->
            <div
                class="glass p-10 rounded-4xl border border-white/40 dark:border-white/5 shadow-2xl mb-10 flex flex-col md:flex-row items-center gap-10">
                <div
                    class="h-32 w-32 bg-primary rounded-3xl flex items-center justify-center text-white shadow-2xl shadow-primary/30">
                    <svg class="w-16 h-16">
                        <use xlink:href="#<?= $content['faimg'] ?>"></use>
                    </svg>
                </div>
                <div class="text-center md:text-left flex-1">
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 mb-3">
                        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white">
                            <?= $content['name'] ?>
                        </h1>
                        <span
                            class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?= $content['status'] == 1 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>"><?= $content['status'] == 1 ? '在线 (Enabled)' : '维护 (Disabled)' ?></span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-lg leading-relaxed max-w-2xl italic">
                        <?= $content['remarks'] ?: $content['desc'] ?>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-10">
                    <div class="glass p-8 rounded-4xl border border-white/40 dark:border-white/5">
                        <h3 class="text-xl font-black mb-6 uppercase tracking-tight flex items-center gap-3 italic"><i
                                class="fas fa-link text-primary"></i> 网关出口 (ENDPOINT)</h3>
                        <div
                            class="bg-slate-900 rounded-2xl p-6 flex items-center justify-between border border-white/5">
                            <code
                                class="text-blue-400 font-black break-all mr-6 text-sm"><?= $content['apiurl'] ?></code>
                            <button onclick="copyAction('<?= $content['apiurl'] ?>', '接口地址已复制')"
                                class="bg-white/10 hover:bg-white/20 text-white px-6 py-2.5 rounded-xl text-xs font-black transition-all whitespace-nowrap uppercase tracking-widest">复制地址</button>
                        </div>
                    </div>
                    <div class="glass p-8 rounded-4xl border border-white/40 dark:border-white/5">
                        <h3 class="text-xl font-black mb-8 italic uppercase tracking-widest flex items-center gap-3"><i
                                class="fas fa-list-check text-primary"></i> 协议参数 (PROTOCOL)</h3>
                        <div
                            class="overflow-hidden rounded-2xl border border-slate-100 dark:border-white/5 font-bold text-sm">
                            <table class="w-full text-left font-black">
                                <thead
                                    class="bg-slate-50 dark:bg-slate-800/50 text-[10px] uppercase tracking-widest text-slate-400">
                                    <tr>
                                        <th class="px-6 py-5">参数名</th>
                                        <th class="px-6 py-5">类型</th>
                                        <th class="px-6 py-5">含义说明</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                                    <?= $content['explain'] ?: '<tr class="text-center italic"><td colspan="3" class="py-12 text-slate-400">遵循基础网关协议。</td></tr>' ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="glass p-8 rounded-4xl border border-white/40 dark:border-white/5">
                        <h3 class="text-xl font-black mb-8 italic uppercase tracking-widest flex items-center gap-3"><i
                                class="fas fa-code text-primary"></i> 集成示例 (CODE)</h3>
                        <div class="flex gap-4 mb-8 overflow-x-auto pb-4 scrollbar-hide" id="code-tabs-nav">
                            <?php $lgs = ['PHP', 'JS', 'Python', 'Java', 'C#'];
                            foreach ($lgs as $ix => $lang): ?>
                                <button
                                    class="px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all <?= $ix === 0 ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' ?> code-tab-btn"
                                    data-lang="<?= strtolower($lang) ?>"><?= $lang ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div id="code-panes" class="font-bold">
                            <!-- PHP -->
                            <div class="code-pane block" id="pane-php">
                                <pre><code class="language-php"><?= htmlspecialchars("<?php\n// 专业 PHP cURL 示例\n\$url = \"" . $content['apiurl'] . "\";\n\$ch = curl_init();\ncurl_setopt(\$ch, CURLOPT_URL, \$url);\ncurl_setopt(\$ch, CURLOPT_RETURNTRANSFER, 1);\n\$res = curl_exec(\$ch);\ncurl_close(\$ch);\necho \$res;\n?>") ?></code></pre>
                            </div>
                            <!-- JavaScript -->
                            <div class="code-pane hidden" id="pane-js">
                                <pre><code class="language-javascript"><?= htmlspecialchars("// JS Fetch API 示例\nconst url = '" . $content['apiurl'] . "';\n\nfetch(url)\n  .then(response => {\n    if (!response.ok) throw new Error('Network response was not ok');\n    return response.json();\n  })\n  .then(data => console.log(data))\n  .catch(error => console.error('Error:', error));") ?></code></pre>
                            </div>
                            <!-- Python -->
                            <div class="code-pane hidden" id="pane-python">
                                <pre><code class="language-python"><?= htmlspecialchars("# Python Requests 示例\nimport requests\n\nurl = '" . $content['apiurl'] . "'\ntry:\n    response = requests.get(url)\n    response.raise_for_status()\n    print(response.json())\nexcept Exception as e:\n    print(f\"An error occurred: {e}\")") ?></code></pre>
                            </div>
                            <!-- Java -->
                            <div class="code-pane hidden" id="pane-java">
                                <pre><code class="language-java"><?= htmlspecialchars("// Java HttpClient 示例 (Java 11+)\nimport java.net.URI;\nimport java.net.http.HttpClient;\nimport java.net.http.HttpRequest;\nimport java.net.http.HttpResponse;\n\npublic class ApiClient {\n    public static void main(String[] args) throws Exception {\n        HttpClient client = HttpClient.newHttpClient();\n        HttpRequest request = HttpRequest.newBuilder()\n                .uri(URI.create(\"" . $content['apiurl'] . "\"))\n                .build();\n\n        client.sendAsync(request, HttpResponse.BodyHandlers.ofString())\n                .thenApply(HttpResponse::body)\n                .thenAccept(System.out::println)\n                .join();\n    }\n}") ?></code></pre>
                            </div>
                            <!-- C# -->
                            <div class="code-pane hidden" id="pane-c#">
                                <pre><code class="language-csharp"><?= htmlspecialchars("// C# HttpClient 示例\nusing System;\nusing System.Net.Http;\nusing System.Threading.Tasks;\n\nclass Program {\n    static async Task Main() {\n        using var client = new HttpClient();\n        try {\n            string response = await client.GetStringAsync(\"" . $content['apiurl'] . "\");\n            Console.WriteLine(response);\n        } catch (HttpRequestException e) {\n            Console.WriteLine($\"Error: {e.Message}\");\n        }\n    }\n}") ?></code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-10">
                    <div
                        class="glass p-10 rounded-4xl border border-white/40 dark:border-white/5 shadow-2xl bg-primary/5 text-center">
                        <h3 class="text-2xl font-black mb-4 uppercase italic tracking-tighter">在线调试室</h3>
                        <p class="text-slate-500 text-[10px] font-black mb-10 uppercase tracking-[0.2em] italic">
                            全功能请求实验室 · 实时数据追踪</p>
                        <button id="open-debugger"
                            class="w-full bg-primary hover:bg-blue-600 text-white py-4 rounded-2xl font-black shadow-2xl transition-all hover:scale-[1.03] active:scale-95 uppercase tracking-widest text-sm italic">进入专业调试室
                            <i class="fas fa-rocket ml-2"></i></button>
                    </div>

                    <div
                        class="glass p-8 rounded-4xl border border-white/40 dark:border-white/5 font-black uppercase tracking-widest text-[10px] space-y-5 italic text-slate-500">
                        <div class="flex justify-between items-center"><span>请求类型 (METHOD)</span> <span
                                class="bg-primary/10 text-primary px-3 py-1 rounded-lg"><?= $content['request'] ?></span>
                        </div>
                        <div class="flex justify-between items-center"><span>输出格式 (FORMAT)</span> <span
                                class="bg-primary/10 text-primary px-3 py-1 rounded-lg"><?= $content['apiformat'] ?></span>
                        </div>
                        <div class="flex justify-between items-center"><span>调用热度 (VIEWS)</span> <span
                                class="bg-primary/10 text-primary px-3 py-1 rounded-lg"><?= number_format($content['views']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 高级 Toast 提示 -->
    <div id="premium-toast"
        class="premium-toast bg-white dark:bg-slate-900 rounded-2xl px-6 py-4 shadow-3xl border border-slate-100 dark:border-white/10 flex items-center gap-3">
        <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs"><i
                class="fas fa-check"></i></div>
        <span class="text-xs font-black text-slate-800 dark:text-white italic tracking-wider uppercase"
            id="toast-msg">操作成功</span>
    </div>

    <!-- 实验室 -->
    <div id="debug-overlay"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-3xl z-[100] transition-all opacity-0 pointer-events-none flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-6xl h-[88vh] rounded-[3rem] shadow-3xl overflow-hidden flex flex-col font-black border border-white/10 transition-transform scale-90 duration-500"
            id="debug-modal">
            <div
                class="px-10 py-7 border-b border-slate-100 dark:border-white/5 flex justify-between items-center bg-slate-50 dark:bg-slate-800/60">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 bg-primary rounded-xl flex items-center justify-center text-white"><i
                            class="fas fa-shield-halved text-xs"></i></div>
                    <span class="text-xl uppercase tracking-tighter italic">SH-API <span
                            class="text-primary italic">LABORATORY</span></span>
                </div>
                <button id="close-debugger"
                    class="h-10 w-10 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"><i
                        class="fas fa-times"></i></button>
            </div>
            <div
                class="flex-1 overflow-hidden flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-slate-100 dark:divide-white/5">
                <!-- 左侧 -->
                <div class="w-full lg:w-1/2 p-10 overflow-y-auto space-y-8 scrollbar-hide">
                    <div class="flex gap-4 font-black">
                        <select id="req-method"
                            class="bg-slate-100 dark:bg-slate-800 px-6 py-4 rounded-2xl outline-none text-primary uppercase text-xs shadow-sm border border-transparent focus:border-primary/20 transition-all font-black">
                            <option>GET</option>
                            <option>POST</option>
                            <option>PUT</option>
                            <option>DELETE</option>
                        </select>
                        <input type="text" id="req-url" value="<?= $content['apiurl'] ?>"
                            class="flex-1 bg-slate-100 dark:bg-slate-800 px-6 py-4 rounded-2xl outline-none text-xs shadow-sm border border-transparent focus:border-primary/20 transition-all font-black">
                    </div>
                    <div
                        class="flex gap-8 border-b border-slate-100 dark:border-white/5 pb-2 text-[10px] uppercase tracking-widest font-black text-slate-400 italic">
                        <button class="lab-tab lab-btn-active pb-2" data-lab="params">查询参数 (QUERY)</button>
                        <button class="lab-tab pb-2" data-lab="headers">头部信息 (HEADERS)</button>
                        <button class="lab-tab pb-2" data-lab="body">消息主体 (BODY)</button>
                    </div>
                    <div id="lab-panes">
                        <div class="lab-pane block" id="pane-params">
                            <div id="param-rows" class="space-y-3 mb-6"></div>
                            <button
                                class="add-row w-full py-4 border-2 border-dashed border-slate-100 dark:border-white/5 text-slate-400 hover:text-primary hover:border-primary/20 rounded-2xl text-[10px] transition-all font-black uppercase tracking-widest"
                                data-type="param">+ 新增参数行 (ADD PARAMETER)</button>
                        </div>
                        <div class="lab-pane hidden" id="pane-headers">
                            <div id="header-rows" class="space-y-3 mb-6"></div>
                            <button
                                class="add-row w-full py-4 border-2 border-dashed border-slate-100 dark:border-white/5 text-slate-400 hover:text-primary hover:border-primary/20 rounded-2xl text-[10px] transition-all font-black uppercase tracking-widest"
                                data-type="header">+ 新增头部行 (ADD HEADER)</button>
                        </div>
                        <div class="lab-pane hidden" id="pane-body">
                            <div class="flex gap-4 mb-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="body-type" value="json" checked class="accent-primary">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest italic text-slate-400">Application/Json</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="body-type" value="form" class="accent-primary">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest italic text-slate-400">Multipart/Form-Data</span>
                                </label>
                            </div>
                            <div id="body-json-area">
                                <textarea id="body-editor"
                                    class="w-full h-72 bg-slate-50 dark:bg-black/20 p-6 rounded-2xl font-mono text-[11px] outline-none border border-slate-100 dark:border-white/5 text-slate-600 dark:text-gray-300 focus:border-primary/20 transition-all font-black placeholder:italic"
                                    placeholder='{"key": "value"}'></textarea>
                            </div>
                            <div id="body-form-area" class="hidden space-y-3 mb-6">
                                <div id="form-rows" class="space-y-3 mb-6"></div>
                                <button
                                    class="add-row w-full py-4 border-2 border-dashed border-slate-100 dark:border-white/5 text-slate-400 hover:text-primary hover:border-primary/20 rounded-2xl text-[10px] transition-all font-black uppercase tracking-widest"
                                    data-type="form">+ 新增表单行 (ADD FORM DATA)</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 右侧 -->
                <div class="w-full lg:w-1/2 flex flex-col bg-slate-50 dark:bg-black/10">
                    <div
                        class="p-8 border-b border-slate-100 dark:border-white/5 flex justify-between items-center font-black">
                        <div class="flex items-center gap-4">
                            <span id="res-status"
                                class="px-5 py-2 rounded-full bg-slate-200 dark:bg-slate-800 text-[10px] uppercase italic tracking-widest">就绪
                                (READY)</span>
                            <span id="res-time" class="text-[10px] text-slate-400 italic">-- MS</span>
                        </div>
                        <button onclick="copyAction($('#res-data').text(), '内容已复制')"
                            class="text-[10px] text-primary hover:underline italic font-black uppercase">复制响应内容</button>
                    </div>
                    <div class="flex-1 p-10 overflow-auto font-mono text-[11px] leading-relaxed whitespace-pre font-black select-all"
                        id="res-data">// 实验室接入点在线，正在等待数据流...</div>
                    <div class="p-10 border-t border-slate-100 dark:border-white/5">
                        <button id="btn-fire"
                            class="w-full bg-primary text-white py-6 rounded-3xl text-sm uppercase tracking-[0.4em] font-black shadow-3xl shadow-primary/30 transition-all hover:scale-[1.03] active:scale-95 italic">发起数据追踪
                            (FIRE TRACKING) <i class="fas fa-location-arrow ml-3"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="btn-top" class="back-to-top" title="返回顶部"><i class="fas fa-arrow-up"></i></div>

    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/prism.min.js"></script>
    <!-- 常用语言支持 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-php.min.js"></script>
    <script
        src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-javascript.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-python.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-java.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-csharp.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/components/prism-json.min.js"></script>
    <script>
        const themeBtn = document.getElementById('theme-toggle');
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.classList.add('dark');
        themeBtn.onclick = () => { document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); };

        $(window).scroll(function () { if ($(this).scrollTop() > 500) $('#btn-top').addClass('show'); else $('#btn-top').removeClass('show'); });
        $('#btn-top').click(() => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // 高级提示
        function showToast(msg = '操作成功') {
            const $t = $('#premium-toast');
            $('#toast-msg').text(msg);
            $t.addClass('show');
            setTimeout(() => $t.removeClass('show'), 3000);
        }

        function copyAction(text, msg) {
            navigator.clipboard.writeText(text).then(() => showToast(msg));
        }

        $('.code-tab-btn').click(function () {
            $('.code-tab-btn').removeClass('bg-primary text-white shadow-xl shadow-primary/20').addClass('bg-slate-100 dark:bg-slate-800 text-slate-400');
            $(this).removeClass('bg-slate-100 dark:bg-slate-800 text-slate-400').addClass('bg-primary text-white shadow-xl shadow-primary/20');
            $('.code-pane').addClass('hidden');
            $(`#pane-${$(this).data('lang')}`).removeClass('hidden');
        });

        $('#open-debugger').click(() => { $('#debug-overlay').removeClass('opacity-0 pointer-events-none').find('#debug-modal').removeClass('scale-90'); });
        $('#close-debugger').click(() => { $('#debug-overlay').addClass('opacity-0 pointer-events-none').find('#debug-modal').addClass('scale-90'); });

        $('.lab-tab').click(function () {
            $('.lab-tab').removeClass('lab-btn-active').addClass('text-slate-400');
            $(this).addClass('lab-btn-active').removeClass('text-slate-400');
            $('.lab-pane').addClass('hidden');
            $(`#pane-${$(this).data('lab')}`).removeClass('hidden');
        });

        $('input[name="body-type"]').change(function () {
            if ($(this).val() === 'json') {
                $('#body-json-area').removeClass('hidden');
                $('#body-form-area').addClass('hidden');
            } else {
                $('#body-json-area').addClass('hidden');
                $('#body-form-area').removeClass('hidden');
            }
        });

        const addRow = (container, k = "", v = "") => {
            $(`#${container}`).append(`<div class="flex gap-2 group animate-fade-in"><input class="w-1/3 input-dark font-black k" value="${k}" placeholder="Key"><input class="flex-1 input-dark font-black v" value="${v}" placeholder="Value"><button class="px-4 text-slate-300 hover:text-red-500 remove-row transition-all"><i class="fas fa-times"></i></button></div>`);
        };
        $('.add-row').click(function () { addRow($(this).data('type') + '-rows'); });
        $(document).on('click', '.remove-row', function () { $(this).parent().remove(); });

        $('#btn-fire').click(async function () {
            const $btn = $(this); $btn.prop('disabled', true).html('正在进行数据包追踪 (TRACING)...');
            const start = Date.now();
            const method = $('#req-method').val();
            let url = $('#req-url').val();

            const params = {}; $('#param-rows > div').each(function () { let k = $(this).find('.k').val().trim(); if (k) params[k] = $(this).find('.v').val().trim(); });
            if (Object.keys(params).length) url += (url.includes('?') ? '&' : '?') + new URLSearchParams(params).toString();

            const headers = {}; $('#header-rows > div').each(function () { let k = $(this).find('.k').val().trim(); if (k) headers[k] = $(this).find('.v').val().trim(); });

            let config = { method, headers };
            if (method !== 'GET') {
                const bodyType = $('input[name="body-type"]:checked').val();
                if (bodyType === 'json') {
                    config.headers['Content-Type'] = 'application/json';
                    config.body = $('#body-editor').val();
                } else {
                    const formData = new FormData();
                    $('#form-rows > div').each(function () {
                        let k = $(this).find('.k').val().trim();
                        if (k) formData.append(k, $(this).find('.v').val().trim());
                    });
                    config.body = formData;
                    // Note: Fetch auto-sets Content-Type for FormData, so we delete it if manually set
                    delete config.headers['Content-Type'];
                }
            }

            try {
                const resp = await fetch(url, config);
                const time = Date.now() - start;
                const contentType = resp.headers.get('Content-Type');
                $('#res-status').text(resp.status + ' ' + (resp.statusText || 'OK')).css('background', resp.ok ? '#22c55e' : '#ef4444').css('color', 'white');
                $('#res-time').text(time + ' MS');

                if (contentType && contentType.toLowerCase().includes('image')) {
                    const blob = await resp.blob();
                    const imageUrl = URL.createObjectURL(blob);
                    $('#res-data').html(`<div class="py-10 flex flex-col items-center gap-6"><img src="${imageUrl}" class="image-result" /><div class="text-[10px] text-slate-400 uppercase italic">DETECTED IMAGE ASSET</div></div>`);
                } else {
                    const str = await resp.text();
                    try { $('#res-data').text(JSON.stringify(JSON.parse(str), null, 4)); } catch (e) { $('#res-data').text(str); }
                }
            } catch (e) {
                $('#res-status').text('FAILED').css('background', '#ef4444').css('color', 'white');
                $('#res-data').text('追踪链路异常: ' + e.message);
            }
            $btn.prop('disabled', false).html('发起数据追踪 (FIRE TRACKING) <i class="fas fa-location-arrow ml-3"></i>');
        });
    </script>
</body>

</html>