<?php

// 判断文件或目录是否有写的权限
function is_really_writable($file)
{
    if (DIRECTORY_SEPARATOR == '/' AND @ ini_get("safe_mode") == FALSE)
    {
        return is_writable($file);
    }
    if (!is_file($file) OR ( $fp = @fopen($file, "r+")) === FALSE)
    {
        return FALSE;
    }

    fclose($fp);
    return TRUE;
}
function checkFunction($function) {
        global $support;
        if(function_exists($function)) {
            return '<span class="green">支持</span>';
        }
        $support = false;
        return '<span class="red">不支持</span>';
    }

    function checkClass($class) {
        global $support;
        if(class_exists($class)) {
            return '<span class="green">支持</span>';
        }
        $support = false;
        return '<span class="red">不支持</span>';
    }

    function checkExtension($extension) {
        global $support;
        if(extension_loaded($extension)) {
            return '<span class="green">支持</span>';
        }
        $support = false;
        return '<span class="red">不支持</span>';
    }

    function checkPHPVersion() {
        global $support;
        $version = phpversion();
        $a = explode('.', $version);
        $result = false;
        // 支持 PHP 5.6 到 PHP 8.5+
        if($a[0] == '5' && isset($a[1]) && $a[1] >= 6) {
            $result = true;
        } elseif($a[0] == '7') {
            $result = true; // PHP 7.0 - 7.4 都支持
        } elseif($a[0] == '8') {
            $result = true; // PHP 8.0 - 8.5+ 都支持
        }
        if($result) {
            return '<span class="green">支持 (PHP ' . $version . ')</span>';
        }
        $support = false;
        return '<span class="red">不支持 (PHP ' . $version . ')</span>';
    }
/**
 * description:TODO 安装信息
 */
function installmsg($msg = '当前网站已安装, 如需重复安装请删除/install/install.lock', $die = true){
    echo '
    <!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>温馨提示</title>
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link href="./install/css/style.css" rel="stylesheet">
</head>
<body>
<div id="page-container" class="flex flex-col mx-auto w-full min-h-screen min-w-80 bg-white text-gray-800">
    <header id="page-header" class="flex flex-none items-center bg-white">
        <div class="flex-none container xl:max-w-6xl mx-auto p-8 text-center">
            <a class="group inline-flex items-center space-x-1 font-bold text-lg text-gray-700" href="/">
                <img src="/logo.png" alt="Nathan-Auth" style="width: 150.8px; height: 100%;" draggable="false" onerror="onerror=null;src="/logo.png">
            </a>
        </div>
    </header>

    <main id="page-content" class="flex flex-auto flex-col max-w-full bg-white">
        <div class="overflow-hidden">
            <div class="container xl:max-w-6xl mx-auto px-4 pt-20 pb-20 lg:px-8 md:pt-40 md:pb-40">
                <div class="group relative">
                    <div class="hidden md:block absolute inset-0 -m-16 bg-indigo-100 rounded-3xl transform -rotate-3 translate-y-2 scale-105 transition ease-out duration-500 group-hover:-rotate-2">
                    </div>
                    <div class="hidden md:block absolute inset-0 -m-16 bg-brand-100 rounded-3xl transform rotate-3 translate-y-2 scale-105 transition ease-out duration-500 group-hover:rotate-2">
                    </div>
                    <div class="hidden md:block absolute inset-0 -m-16 bg-white rounded-md shadow-subtle">
                    </div>
                    <div class="flex flex-col md:flex-row items-center space-y-8 md:space-y-0 md:space-x-6 relative">
                    
                        <div class="text-center lg:w-1/2 space-y-8">
                            <div>
                                <svg class="fa-duo fa-envelope-open-text inline-block" fill="currentColor" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4711" width="200" height="200">
                                    <path d="M511.823 67c-208.215-0.153-388.629 144.437-434.067 347.878-45.438 203.44 56.28 411.195 244.73 499.847 188.45 88.653 413.113 34.439 540.528-130.437 8.397-14.92 4.693-33.74-8.73-44.355-13.423-10.615-32.567-9.863-45.119 1.77-116.842 150.752-328.252 189.361-490.73 89.622-162.48-99.738-224-305.889-142.805-478.522 81.195-172.632 279.108-256.47 459.4-194.604 180.293 61.865 285.234 249.623 243.593 435.828a34.8 34.8 0 0 0 8.073 35.292 34.7 34.7 0 0 0 35.034 8.973 34.756 34.756 0 0 0 24.01-27.075c26.5-115.522 5.789-236.857-57.529-337.01C824.893 174.054 724.222 103.391 608.596 77.94A428.763 428.763 0 0 0 511.823 67z" fill="#FD6B6D" p-id="4712">
                                    </path>
                                    <path d="M388.923 332.562l125.04 129.283 129.113-124.25c14.13-13.597 36.595-13.205 50.24 0.877 13.586 14.02 13.234 36.397-0.785 49.982l-0.088 0.085L563.28 512.836l124.996 129.236c13.633 14.095 13.258 36.573-0.837 50.206l-0.04 0.039c-14.145 13.638-36.663 13.245-50.323-0.879L512.034 562.154l-129.11 124.25c-14.13 13.598-36.595 13.206-50.24-0.876-13.586-14.02-13.234-36.397 0.785-49.982l0.088-0.085 129.16-124.298-124.994-129.235c-13.633-14.095-13.258-36.573 0.837-50.206l0.04-0.039c14.145-13.638 36.663-13.245 50.323 0.879z" fill="#FD6B6D" p-id="4713">
                                    </path>
                                </svg>
                            </div>
                        </div>

                                                <div class="lg:w-1/2">
                            <h1 class="text-2xl lg:text-3xl lg:leading-10 font-bold mb-3">
                            '. $msg .'
                            </h1>
                            <h4 class="text-1xl lg:text-1xl lg:leading-10 mb-3">
                                页面将在 <span id="wait">5</span> 秒后自动跳转
                            </h4>
                            <div class="space-x-1 sm:space-x-2">
                                                            <a href="#" onClick="javascript :history.back(-1);" class="inline-flex justify-center items-center space-x-2 rounded border font-medium focus:outline-none px-4 py-2 leading-6 border-opacity-10 bg-red-100 text-red-700 hover:bg-gray-900 hover:text-red-500 active:bg-red-100 active:text-red-700">
                                    <svg t="1627550234650" class="hi-solid hi-briefcase inline-block w-5 h-5 opacity-60" fill="currentColor" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2135">
                                        <path d="M834.77 351.69c-58.72-58.72-136.84-91.07-219.86-91.07H262.82l52.66-45.16c18.61-15.94 20.7-43.93 4.76-62.5-15.94-18.61-43.93-20.74-62.47-4.8L114.15 271.3c-0.53 0.46-1.01 0.96-1.52 1.44-0.41 0.39-0.83 0.76-1.22 1.16-0.64 0.65-1.23 1.33-1.83 2.01-0.37 0.42-0.74 0.84-1.09 1.28-0.55 0.68-1.06 1.39-1.57 2.1-0.35 0.49-0.7 0.99-1.03 1.5-0.45 0.69-0.87 1.39-1.28 2.1-0.34 0.58-0.66 1.17-0.97 1.77-0.35 0.68-0.68 1.37-1 2.08-0.3 0.66-0.57 1.32-0.84 1.99-0.28 0.7-0.54 1.41-0.78 2.12-0.22 0.67-0.43 1.35-0.62 2.04-0.22 0.78-0.42 1.55-0.6 2.34-0.13 0.6-0.25 1.21-0.36 1.83-0.17 0.93-0.32 1.86-0.43 2.8-0.05 0.45-0.09 0.9-0.13 1.36-0.06 0.68-0.16 1.35-0.19 2.04-0.12 3.49 0.18 6.94 0.85 10.31 0.04 0.19 0.07 0.38 0.11 0.57 0.25 1.17 0.55 2.33 0.89 3.48 0.1 0.32 0.19 0.64 0.3 0.96 0.34 1.04 0.71 2.06 1.12 3.07a41.462 41.462 0 0 0 1.83 3.95c0.18 0.35 0.37 0.69 0.57 1.03 0.53 0.94 1.08 1.86 1.67 2.76 0.19 0.29 0.39 0.57 0.59 0.86 0.64 0.92 1.3 1.82 2.01 2.69 0.18 0.22 0.37 0.43 0.55 0.64 0.69 0.82 1.42 1.62 2.17 2.39 0.15 0.15 0.29 0.31 0.44 0.46l143.48 143.44c8.66 8.66 19.98 12.98 31.31 12.98 11.33 0 22.72-4.33 31.38-12.98 17.24-17.31 17.24-45.37-0.07-62.68L250 349.28h364.86c59.37 0 115.2 23.12 157.18 65.1 42.05 42.02 65.21 97.85 65.21 157.25 0 122.63-99.83 222.42-222.46 222.46H266.07c-24.45 0-44.29 19.84-44.29 44.33s19.84 44.33 44.29 44.33h348.84c171.46-0.04 310.97-139.61 310.97-311.11 0-83.08-32.32-161.2-91.11-219.95z" p-id="2136">
                                        </path>
                                    </svg>
                                    <span>返回上一页</span>
                                </a>
                                                                <a id="href" href="/" class="inline-flex justify-center items-center space-x-2 rounded border font-medium focus:outline-none px-4 py-2 leading-6 border-gray-200 bg-gray-200 text-gray-700 hover:text-gray-700 hover:bg-gray-300 hover:border-gray-300 focus:ring focus:ring-gray-500 focus:ring-opacity-50 active:bg-gray-200 active:border-gray-200">
                                    <svg t="1627203648027" class="hi-solid hi-home inline-block w-5 h-5 opacity-60" fill="currentColor" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M755.072 545.472L583.424 717.12a32 32 0 0 0 45.248 45.248l226.304-226.272a31.904 31.904 0 0 0 0-45.248L628.672 264.576a32 32 0 0 0-45.248 45.248l171.648 171.648H213.344a32 32 0 0 0 0 64h541.76z" p-id="4179"></path>
                                    </svg>
                                    <span>立即跳转</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer id="page-footer">
        <div class="container xl:max-w-6xl mx-auto p-4 lg:p-8">
            <div class="flex flex-col items-center justify-between">
                <div class="text-sm md:text-center">
                    <strong>笒鬼鬼API程序</strong> &copy; 2023</div>
            </div>
        </div>
    </footer>
</div>
<script>
    (function(){
        var wait = document.getElementById("wait"),
            href = document.getElementById("href").href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>
';
    if ($die == true) {
        exit;
    }
}
/**
 * description:TODO 提示信息
 */
function msg($msg = '未知的异常', $die = true){
    echo '
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>站点提示信息</title>
        <style type="text/css">
            html {
                background: #eee
            }

            body {
                background: #fff;
                color: #333;
                font-family: "微软雅黑", "Microsoft YaHei", sans-serif;
                margin: 2em auto;
                padding: 1em 2em;
                max-width: 700px;
                -webkit-box-shadow: 10px 10px 10px rgba(0, 0, 0, .13);
                box-shadow: 10px 10px 10px rgba(0, 0, 0, .13);
                opacity: .8
            }

            h1 {
                border-bottom: 1px solid #dadada;
                clear: both;
                color: #666;
                font: 24px "微软雅黑", "Microsoft YaHei",, sans-serif;
                margin: 30px 0 0 0;
                padding: 0;
                padding-bottom: 7px
            }

            #error-page {
                margin-top: 50px
            }

            h3 {
                text-align: center
            }

            #error-page p {
                font-size: 9px;
                line-height: 1.5;
                margin: 25px 0 20px
            }

            #error-page code {
                font-family: Consolas, Monaco, monospace
            }

            ul li {
                margin-bottom: 10px;
                font-size: 9px
            }

            a {
                color: #21759B;
                text-decoration: none;
                margin-top: -10px
            }

            a:hover {
                color: #D54E21
            }

            .button {
                background: #f7f7f7;
                border: 1px solid #ccc;
                color: #555;
                display: inline-block;
                text-decoration: none;
                font-size: 9px;
                line-height: 26px;
                height: 28px;
                margin: 0;
                padding: 0 10px 1px;
                cursor: pointer;
                -webkit-border-radius: 3px;
                -webkit-appearance: none;
                border-radius: 3px;
                white-space: nowrap;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0, 0, 0, .08);
                box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0, 0, 0, .08);
                vertical-align: top
            }

            .button.button-large {
                height: 29px;
                line-height: 28px;
                padding: 0 12px
            }

            .button:focus, .button:hover {
                background: #fafafa;
                border-color: #999;
                color: #222
            }

            .button:focus {
                -webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, .2);
                box-shadow: 1px 1px 1px rgba(0, 0, 0, .2)
            }

            .button:active {
                background: #eee;
                border-color: #999;
                color: #333;
                -webkit-box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, .5);
                box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, .5)
            }

            table {
                table-layout: auto;
                border: 1px solid #333;
                empty-cells: show;
                border-collapse: collapse
            }

            th {
                padding: 4px;
                border: 1px solid #333;
                overflow: hidden;
                color: #333;
                background: #eee
            }

            td {
                padding: 4px;
                border: 1px solid #333;
                overflow: hidden;
                color: #333
            }
        </style>
    </head>
    <body id="error-page"><h3>站点提示信息</h3>
    '. $msg .'
    </body>
    </html>';
    if ($die == true) {
        exit;
    }
}