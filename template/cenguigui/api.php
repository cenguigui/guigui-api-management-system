<?php


include("./includes/common.php");
$alias = trim(strip_tags(daddslashes($_GET['alias'])));
$content = $DB->getRow("SELECT * FROM `api_apilist` WHERE `alias`='{$alias}'");
if (empty($content)) {
    exit('<script language="javascript">window.location.href="/404.html";</script>');
}
$views = $DB->getColumn("SELECT SUM(views) FROM `api_apilist` WHERE `status`='1'");
ApiViews($alias);

include("./includes/api_stats.php");
updateApiStatsByAlias('' . $alias . '');

/** 开启gzip压缩 */
ob_start('ob_gzhandler');

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title><?= $content['name'] ?> - <?= $system['sysname'] ?></title>
    <meta name="keywords" content="<?= $system['keywords'] ?>">
    <meta name="description" content="<?= $system['description'] ?>">
    <meta property="og:description" content="<?= $system['description'] ?>">
    <meta property="og:site_name" content="<?= $system['title'] ?>">
    <meta property="og:title" content="<?= $system['title'] ?>">
    <meta property="og:url" content="<?= url ?>">
    <link rel="stylesheet" href="<?= theme ?>css/api.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $system['ico'] ?>">
    <!-- Font Awesome 图标 -->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css 动画库 -->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Prism.js 代码高亮样式 -->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/themes/prism.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Prism.js 核心库 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.27.0/prism.min.js"></script>
    <!-- Clipboard.js 剪贴板库 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <!-- Particles.js 粒子效果 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <!-- 引入 Prism.js 核心库 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/prism.min.js"></script>
    <!-- 引入 Prism.css 样式 -->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/themes/prism.min.css" rel="stylesheet">
    <!-- 常用语言支持 -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-javascript.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-css.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-json.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-typescript.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-python.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-java.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-php.min.js"></script>
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/prism/1.9.0/components/prism-csharp.min.js"></script>
</head>

<body>
    <!-- 通知提示容器 -->
    <div class="notification-container"></div>
    
    <!-- 卡通装饰元素 -->
    <div class="cartoon-decoration top-left">
        <div class="cloud"></div>
    </div>
    <div class="cartoon-decoration top-right">
        <div class="star"></div>
    </div>
    <div class="cartoon-decoration bottom-left">
        <div class="sun"></div>
    </div>
    <div class="cartoon-decoration bottom-right">
        <div class="heart"></div>
    </div>
    
    <div class="particles" id="particles-js"></div>
    <div class="container">
        <header class="animate__animated animate__fadeIn">
            <a href="/" class="back-home animate__animated animate__fadeInLeft">
                <i class="fas fa-arrow-left"></i> 返回首页
            </a>
            <button class="theme-switch animate__animated animate__fadeInRight" id="themeSwitch">
                <i class="fas fa-moon"></i>
            </button>
            <div class="header-content">
                <h1><i class="fas fa-star"></i> <?= $content['name'] ?></h1>
                <p><?= $content['remarks'] ?></p>
                <div class="api-meta">
                    <span class="meta-item"><i class="fas fa-eye"></i> 浏览: <?= $content['views'] ?></span>
                    <span class="meta-item"><i class="fas fa-clock"></i> 最后更新: <?= $content['times'] ?></span>
                </div>
            </div>
        </header>

        <section class="api-section animate__animated animate__fadeInUp">
            <div class="api-title">
                <h2><i class="fas fa-info-circle"></i> 接口说明</h2>
                <div class="api-description">
                    <?= $content['desc'] ?? '此接口提供高效稳定的服务，支持多种参数配置，返回格式清晰易用。' ?>
                </div>
            </div>

            <h2><i class="fas fa-user-circle"></i> 接口基本信息</h2>
            <div class="detail-card">
                <div class="detail-item">
                    <h3><i class="fas fa-link"></i> API地址</h3>
                    <p style="word-break: break-all;"><?= $content['apiurl'] ?></p>
                </div>
                <div class="detail-item">
                    <h3><i class="fas fa-exchange-alt"></i> 请求方式</h3>
                    <p><span class="tag tag-<?= strtolower($content['request']) ?>"><?= $content['request'] ?></span></p>
                </div>
                <div class="detail-item">
                    <h3><i class="fas fa-file-code"></i> 返回格式</h3>
                    <p><span class="tag tag-<?= strtolower($content['apiformat']) ?>"><?= $content['apiformat'] ?></span></p>
                </div>
                <div class="detail-item">
                    <h3><i class="fas fa-power-off"></i> 接口状态</h3>
                    <p><i class="fas fa-check-circle"></i> <span style="color: var(--text-color);">正常启用</span></p>
                </div>
            </div>

            <div class="api-actions">
                <button class="btn btn-copy"><i class="fas fa-copy"></i> 复制API地址</button>
                <button class="btn btn-test" id="testApiBtn"><i class="fas fa-play-circle"></i> 在线调试</button>
            </div>
        </section>

        <section class="api-section animate__animated animate__fadeInUp animate-delay-1">
            <h2><i class="fas fa-list-ul"></i> 参数说明</h2>
            <p>以下参数为接口所需调用信息</p>

            <div class="table-responsive">
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>参数</th>
                            <th>是否必填</th>
                            <th>类型</th>
                            <th>说明</th>
                            <th>示例</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $content['explain'] ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="api-section animate__animated animate__fadeInUp animate-delay-2">
            <h2><i class="fas fa-code-branch"></i> 请求示例</h2>
            <div class="detail-card">
                <div class="detail-item">
                    <h3><i class="fas fa-globe"></i> HTTP请求</h3>
                    <pre><code class="language-http"><?= $content['apirequest'] ?></code></pre>
                </div>
            </div>
        </section>
        
        <section class="api-section animate__animated animate__fadeInUp animate-delay-3">
            <h2><i class="fas fa-laptop-code"></i> 调用示例</h2>
            <div class="detail-card">
                <div class="detail-item">
                    <h3><i class="fas fa-code"></i> 代码示例</h3>
                    <pre><code class="language-javascript"><?= htmlspecialchars($content['example']) ?></code></pre>
                </div>
            </div>
        </section>

        <section class="api-section animate__animated animate__fadeInUp animate-delay-3">
            <h2><i class="fas fa-reply"></i> 返回结果</h2>
            <div class="response-container">
                <div class="response-header">
                    <div class="response-code">HTTP 200 OK</div>
                    <div class="response-actions">
                        <button class="btn-sm copy-response"><i class="fas fa-copy"></i> 复制</button>
                    </div>
                </div>
                <div class="response-data">
                    <pre><code class="language-json"><?= $content['return'] ?></code></pre>
                </div>
            </div>
        </section>

        <section class="api-section animate__animated animate__fadeInUp animate-delay-4">
            <h2><i class="fas fa-code"></i> 调用示例</h2>
            <div class="code-tabs">
                <div class="tabs-nav">
                    <button class="tab-btn active" data-lang="javascript">JavaScript</button>
                    <button class="tab-btn" data-lang="python">Python</button>
                    <button class="tab-btn" data-lang="java">Java</button>
                    <button class="tab-btn" data-lang="php">PHP</button>
                    <button class="tab-btn" data-lang="csharp">C#</button>
                </div>
                <div class="tabs-content">
                    <div class="tab-pane active" id="javascript">
                        <div class="code-actions">
                            <button class="btn-sm copy-code" data-target="javascript"><i class="fas fa-copy"></i> 复制代码</button>
                        </div>
                        <pre><code class="language-javascript"><?= htmlspecialchars($content['example_js'] ?? '// JavaScript调用示例
fetch("' . $content['apirequest'] . '", {
  method: "' . $content['request'] . '",
  headers: {
    "Content-Type": "application/json"
  }' . ($content['request'] === 'POST' ? ',
  body: JSON.stringify({
    // 请求参数
  })' : '') . '
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error("Error:", error));') ?></code></pre>
                    </div>
                    <div class="tab-pane" id="python">
                        <div class="code-actions">
                            <button class="btn-sm copy-code" data-target="python"><i class="fas fa-copy"></i> 复制代码</button>
                        </div>
                        <pre><code class="language-python"><?= htmlspecialchars($content['example_python'] ?? '# Python调用示例
import requests

url = "' . $content['apirequest'] . '"' . ($content['request'] === 'POST' ? '

data = {
    # 请求参数
}

response = requests.post(url, json=data)' : '

response = requests.get(url)') . '

print(response.json())') ?></code></pre>
                    </div>
                    <div class="tab-pane" id="java">
                        <div class="code-actions">
                            <button class="btn-sm copy-code" data-target="java"><i class="fas fa-copy"></i> 复制代码</button>
                        </div>
                        <pre><code class="language-java"><?= htmlspecialchars($content['example_java'] ?? '// Java调用示例
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.time.Duration;

public class ApiExample {
    public static void main(String[] args) throws Exception {
        HttpClient client = HttpClient.newBuilder()
                .version(HttpClient.Version.HTTP_2)
                .connectTimeout(Duration.ofSeconds(10))
                .build();
                
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create("' . $content['apirequest'] . '"))' . ($content['request'] === 'POST' ? '
                .header("Content-Type", "application/json")
                .POST(HttpRequest.BodyPublishers.ofString("{\"key\":\"value\"}"))' : '') . '
                .build();
                
        client.sendAsync(request, HttpResponse.BodyHandlers.ofString())
                .thenApply(HttpResponse::body)
                .thenAccept(System.out::println)
                .join();
    }
}') ?></code></pre>
                    </div>
                   <div class="tab-pane" id="php">
    <div class="code-actions">
        <button class="btn-sm copy-code" data-target="php"><i class="fas fa-copy"></i> 复制代码</button>
    </div>
    <pre><code class="language-php"><?= htmlspecialchars($content['example_php'] ?? '<?php
// PHP调用示例
$url = "' . ($content['apirequest'] ?? '') . '";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);' . (($content['request'] ?? '') === 'POST' ? '

$postData = [
    // 请求参数
];
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);' : '') . '

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
print_r($result);
?>') ?></code></pre>
                    </div>
                    <div class="tab-pane" id="csharp">
                        <div class="code-actions">
                            <button class="btn-sm copy-code" data-target="csharp"><i class="fas fa-copy"></i> 复制代码</button>
                        </div>
                        <pre><code class="language-csharp"><?= htmlspecialchars($content['example_csharp'] ?? '// C#调用示例
using System;
using System.Net.Http;
using System.Threading.Tasks;

class Program
{
    static async Task Main()
    {
        using var client = new HttpClient();
        var url = "' . $content['apirequest'] . '";' . ($content['request'] === 'POST' ? '
        
        var data = new {
            // 请求参数
        };
        var response = await client.PostAsJsonAsync(url, data);' : '
        
        var response = await client.GetAsync(url);') . '
        
        var result = await response.Content.ReadAsStringAsync();
        Console.WriteLine(result);
    }
}') ?></code></pre>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer-content animate__animated animate__fadeIn">
            <div class="footer-grid">
            <div class="footer-main">
                <div class="footer-brand">
                    <p>Powered by <span class="brand-highlight"><?= $system['sysname'] ?> API Platform</span></p>
                </div>
                
                <div class="footer-links">
                    <a href="<?= $system['qqlink'] ?>" class="footer-link">联系笒鬼鬼</a>
                    <a href="<?= $system['qunurl'] ?>" class="footer-link">交流群</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>© <?= date('Y') ?> <?= $system['sysname'] ?> 版权所有</p>
                </div>
                
                <?php if (!empty($system['icp'])): ?>
                    <div class="footer-icp">
                        <svg t="1748675227758" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4648" width="18" height="18">
                            <path d="M778.24 163.84c-76.8-40.96-165.888-61.44-269.312-61.44s-192.512 20.48-269.312 61.44h-133.12l23.552 337.92c8.192 113.664 67.584 217.088 162.816 280.576l215.04 144.384 215.04-144.384c96.256-63.488 155.648-166.912 163.84-280.576l23.552-337.92H778.24z m47.104 333.824c-7.168 94.208-56.32 181.248-135.168 233.472l-181.248 120.832L327.68 731.136c-78.848-53.248-129.024-139.264-135.168-233.472L173.056 225.28h136.192v-26.624c58.368-23.552 124.928-34.816 199.68-34.816s141.312 12.288 199.68 34.816V225.28H844.8l-19.456 272.384z" fill="#ffacc7" p-id="4649"></path>
                            <path d="M685.056 328.704v-46.08H455.68c2.048-4.096 6.144-9.216 11.264-15.36 5.12-7.168 9.216-12.288 11.264-15.36L419.84 240.64c-31.744 46.08-75.776 87.04-133.12 123.904 4.096 4.096 10.24 11.264 18.432 21.504l17.408 17.408c23.552-15.36 45.056-31.744 63.488-50.176 26.624 25.6 49.152 43.008 67.584 51.2-46.08 15.36-104.448 27.648-175.104 35.84 2.048 5.12 6.144 13.312 9.216 24.576 4.096 11.264 6.144 19.456 7.168 24.576l39.936-7.168v218.112H389.12V680.96h238.592v19.456h54.272V481.28H348.16c60.416-12.288 114.688-27.648 163.84-46.08 49.152 19.456 118.784 34.816 210.944 46.08 5.12-17.408 10.24-34.816 17.408-51.2-62.464-4.096-116.736-12.288-161.792-24.576 38.912-20.48 74.752-46.08 106.496-76.8z m-150.528 194.56h94.208v41.984h-94.208v-41.984z m0 78.848h94.208v41.984h-94.208v-41.984z m-144.384-78.848h94.208v41.984H390.144v-41.984z m0 78.848h94.208v41.984H390.144v-41.984zM424.96 326.656h182.272c-26.624 22.528-57.344 41.984-94.208 57.344-31.744-15.36-61.44-34.816-88.064-57.344z" fill="#ffacc7" p-id="4650"></path>
                        </svg>
                        <a href="https://beian.miit.gov.cn/" target="_blank" class="icp-badge">
                            <?= $system['icp'] ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
            <!-- 装饰元素 -->
            <div class="footer-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </footer>
    </div>

    <!-- 在线调试弹窗 -->
    <div class="modal" id="apiTestModal">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h3><i class="fas fa-play-circle"></i> 接口在线调试</h3>
                <button class="modal-close" id="closeModal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="request-section">
                    <div class="request-header">
                        <div class="method-selector">
                            <select id="requestMethod">
                                <option value="GET" <?= strtoupper($content['request']) === 'GET' ? 'selected' : '' ?>>GET</option>
                                <option value="POST" <?= strtoupper($content['request']) === 'POST' ? 'selected' : '' ?>>POST</option>
                                <option value="PUT">PUT</option>
                                <option value="DELETE">DELETE</option>
                            </select>
                        </div>
                        <div class="url-input">
                            <input type="text" id="requestUrl" value="<?= $content['apirequest'] ?>" placeholder="API地址">
                        </div>
                    </div>

                    <div class="request-tabs">
                        <div class="tabs-nav">
                            <button class="tab-btn active" data-tab="params">参数</button>
                            <button class="tab-btn" data-tab="headers">请求头</button>
                            <button class="tab-btn" data-tab="body">请求体</button>
                        </div>
                        <div class="tabs-content">
                            <div class="tab-pane active" id="params">
                                <div class="params-container" id="paramsContainer">
                                    <div class="param-row">
                                        <input type="text" class="param-key" placeholder="参数名">
                                        <input type="text" class="param-value" placeholder="参数值">
                                        <button class="btn-sm remove-param"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn-sm add-param"><i class="fas fa-plus"></i> 添加参数</button>
                            </div>
                            <div class="tab-pane" id="headers">
                                <div class="headers-container" id="headersContainer">
                                    <div class="header-row">
                                        <input type="text" class="header-key" placeholder="Header名">
                                        <input type="text" class="header-value" placeholder="Header值">
                                        <button class="btn-sm remove-header"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn-sm add-header"><i class="fas fa-plus"></i> 添加Header</button>
                            </div>
                            <div class="tab-pane" id="body">
                                <!-- JSON格式输入区域 -->
                                <div class="body-json" style="display: block;">
                                    <div class="json-actions">
                                        <button class="btn-sm format-json"><i class="fas fa-indent"></i> 格式化</button>
                                        <button class="btn-sm compact-json"><i class="fas fa-compress-alt"></i> 压缩</button>
                                    </div>
                                    <textarea id="requestBody" placeholder="请求体内容" rows="6"></textarea>
                                </div>
                                
                                <!-- Form Data格式输入区域 -->
                                <div class="body-form" style="display: none;">
                                    <div class="form-data-container" id="formDataContainer">
                                        <div class="form-row">
                                            <input type="text" class="form-key" placeholder="键">
                                            <input type="text" class="form-value" placeholder="值">
                                            <button class="btn-sm remove-form"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <button class="btn-sm add-form"><i class="fas fa-plus"></i> 添加字段</button>
                                </div>
                                
                                <!-- Text格式输入区域 -->
                                <div class="body-text" style="display: none;">
                                    <textarea id="requestBodyText" placeholder="文本内容" rows="6"></textarea>
                                </div>
                                
                                <div class="body-format">
                                    <select id="bodyFormat">
                                        <option value="json">JSON</option>
                                        <option value="form">Form Data</option>
                                        <option value="text">Text</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="response-section">
                    <h4>响应结果</h4>
                    <div class="response-header">
                        <div class="response-status" id="responseStatus">未请求</div>
                        <div class="response-time" id="responseTime">-</div>
                    </div>
                    <div class="response-content" id="responseContentContainer">
                        <pre><code class="language-json" id="responseContent">// 响应结果将显示在这里</code></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" id="cancelTest">取消</button>
                <button class="btn btn-send" id="sendRequest"><i class="fas fa-paper-plane"></i> 发送请求</button>
            </div>
        </div>
    </div>

    <script>
        // 显示通知提示
        function showNotification(title, message, type = 'info', duration = 3000) {
            const container = document.querySelector('.notification-container');
            
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'error') icon = 'exclamation-circle';
            
            notification.innerHTML = `
                <div class="notification-icon"><i class="fas fa-${icon}"></i></div>
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close"><i class="fas fa-times"></i></button>
            `;
            
            container.appendChild(notification);
            
            // 使用requestAnimationFrame确保DOM更新后再添加show类
            requestAnimationFrame(() => {
                notification.classList.add('show');
            });
            
            // 关闭按钮事件
            notification.querySelector('.notification-close').addEventListener('click', () => {
                closeNotification(notification);
            });
            
            // 自动关闭
            if (duration > 0) {
                setTimeout(() => {
                    closeNotification(notification);
                }, duration);
            }
        }
        
        // 关闭通知
        function closeNotification(notification) {
            // 先移除show类触发动画
            notification.classList.remove('show');
            
            // 监听过渡结束事件，确保动画完成后再移除元素
            notification.addEventListener('transitionend', function handler() {
                notification.removeEventListener('transitionend', handler);
                notification.remove();
            });
            
            // 设置超时作为备用，防止transitionend事件不触发
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }

        $(document).ready(function() {
            // 复制API地址功能
            new ClipboardJS('.btn-copy', {
                text: function() {
                    return '<?= $content['apiurl'] ?>';
                }
            });

            $('.btn-copy').click(function() {
                showNotification('复制成功', 'API地址已复制到剪贴板', 'success');
            });

            // 代码复制功能
            new ClipboardJS('.copy-code', {
                text: function(trigger) {
                    const target = trigger.getAttribute('data-target');
                    return document.querySelector(`#${target} pre code`).textContent;
                }
            });

            $('.copy-code').click(function() {
                showNotification('复制成功', '代码已复制到剪贴板', 'success');
            });

            // 复制响应结果
            new ClipboardJS('.copy-response', {
                text: function() {
                    return document.querySelector('.response-data code').textContent;
                }
            });

            $('.copy-response').click(function() {
                showNotification('复制成功', '响应结果已复制到剪贴板', 'success');
            });

            // 切换代码标签
            $('.tab-btn').click(function() {
                const $this = $(this);
                const $parent = $this.closest('.tabs-nav');
                const target = $this.data('lang') || $this.data('tab');
                
                // 激活当前标签
                $parent.find('.tab-btn').removeClass('active');
                $this.addClass('active');
                
                // 显示对应内容
                const $contentContainer = $parent.next('.tabs-content');
                $contentContainer.find('.tab-pane').removeClass('active');
                $contentContainer.find(`#${target}`).addClass('active');
            });

            // 主题切换
            $('#themeSwitch').click(function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                $(this).html(isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>');
                localStorage.setItem('darkMode', isDark);
                
                // 更新代码高亮主题
                document.documentElement.classList.toggle('dark-mode', isDark);
                
                // 显示主题切换通知
                const themeText = isDark ? '深色' : '浅色';
                showNotification('主题切换', `已切换到${themeText}模式`, 'info');
            });

            // 检查保存的主题设置
            if (localStorage.getItem('darkMode') === 'true') {
                $('body').addClass('dark-mode');
                $('#themeSwitch').html('<i class="fas fa-sun"></i>');
                document.documentElement.classList.add('dark-mode');
            }

            // 在线调试弹窗
            const $modal = $('#apiTestModal');
            
            $('#testApiBtn').click(function() {
                $modal.addClass('active');
                $('body').addClass('modal-open');
            });
            
            $('#closeModal, #cancelTest, .modal-overlay').click(function() {
                $modal.removeClass('active');
                $('body').removeClass('modal-open');
            });

            // 添加参数行
            $('.add-param').click(function() {
                const $newRow = $('<div class="param-row">' +
                    '<input type="text" class="param-key" placeholder="参数名">' +
                    '<input type="text" class="param-value" placeholder="参数值">' +
                    '<button class="btn-sm remove-param"><i class="fas fa-times"></i></button>' +
                '</div>');
                
                $('#paramsContainer').append($newRow);
                attachRemoveHandlers();
            });

            // 添加Header行
            $('.add-header').click(function() {
                const $newRow = $('<div class="header-row">' +
                    '<input type="text" class="header-key" placeholder="Header名">' +
                    '<input type="text" class="header-value" placeholder="Header值">' +
                    '<button class="btn-sm remove-header"><i class="fas fa-times"></i></button>' +
                '</div>');
                
                $('#headersContainer').append($newRow);
                attachRemoveHandlers();
            });

            // 添加Form Data行
            $('.add-form').click(function() {
                const $newRow = $('<div class="form-row">' +
                    '<input type="text" class="form-key" placeholder="键">' +
                    '<input type="text" class="form-value" placeholder="值">' +
                    '<button class="btn-sm remove-form"><i class="fas fa-times"></i></button>' +
                '</div>');
                
                $('#formDataContainer').append($newRow);
                attachRemoveHandlers();
            });

            // 移除行处理函数
            function attachRemoveHandlers() {
                $('.remove-param, .remove-header, .remove-form').click(function() {
                    if ($(this).closest('.param-row, .header-row, .form-row').siblings().length > 0) {
                        $(this).closest('.param-row, .header-row, .form-row').remove();
                    } else {
                        // 至少保留一行
                        $(this).closest('.param-row, .header-row, .form-row').find('input').val('');
                    }
                });
            }

            // 初始绑定移除事件
            attachRemoveHandlers();

            // 切换请求体格式
            $('#bodyFormat').change(function() {
                const format = $(this).val();
                
                // 隐藏所有格式的输入区域
                $('.body-json, .body-form, .body-text').hide();
                
                // 显示选中格式的输入区域
                if (format === 'json') {
                    $('.body-json').show();
                } else if (format === 'form') {
                    $('.body-form').show();
                } else if (format === 'text') {
                    $('.body-text').show();
                }
            });

            // JSON格式化功能
            $('.format-json').click(function() {
                try {
                    const json = JSON.parse($('#requestBody').val());
                    $('#requestBody').val(JSON.stringify(json, null, 2));
                    showNotification('格式化成功', 'JSON已格式化', 'success');
                } catch (e) {
                    showNotification('格式化失败', 'JSON格式不正确', 'error');
                }
            });

            // JSON压缩功能
            $('.compact-json').click(function() {
                try {
                    const json = JSON.parse($('#requestBody').val());
                    $('#requestBody').val(JSON.stringify(json));
                    showNotification('压缩成功', 'JSON已压缩', 'success');
                } catch (e) {
                    showNotification('压缩失败', 'JSON格式不正确', 'error');
                }
            });

            // 发送请求
            $('#sendRequest').click(function() {
                const method = $('#requestMethod').val();
                let url = $('#requestUrl').val().trim();
                
                if (!url) {
                    showNotification('输入错误', '请输入API地址', 'error');
                    return;
                }

                // 收集参数
                const params = {};
                $('.param-row').each(function() {
                    const key = $(this).find('.param-key').val().trim();
                    const value = $(this).find('.param-value').val().trim();
                    if (key) {
                        params[key] = value;
                    }
                });

                // 构建带参数的URL
                if (method === 'GET' && Object.keys(params).length > 0) {
                    const queryString = $.param(params);
                    url += (url.indexOf('?') === -1 ? '?' : '&') + queryString;
                }

                // 收集Headers
                const headers = {};
                $('.header-row').each(function() {
                    const key = $(this).find('.header-key').val().trim();
                    const value = $(this).find('.header-value').val().trim();
                    if (key) {
                        headers[key] = value;
                    }
                });

                // 设置默认Content-Type
                if (!headers['Content-Type'] && method !== 'GET') {
                    const format = $('#bodyFormat').val();
                    headers['Content-Type'] = format === 'json' ? 'application/json' : 
                                            format === 'form' ? 'application/x-www-form-urlencoded' : 
                                            'text/plain';
                }

                // 收集请求体
                let data = null;
                if (method !== 'GET') {
                    const format = $('#bodyFormat').val();
                    
                    if (format === 'json') {
                        const bodyContent = $('#requestBody').val().trim();
                        if (bodyContent) {
                            try {
                                data = JSON.parse(bodyContent);
                            } catch (e) {
                                showNotification('输入错误', 'JSON格式不正确', 'error');
                                return;
                            }
                        } else if (Object.keys(params).length > 0) {
                            data = params;
                        }
                    } else if (format === 'form') {
                        data = {};
                        $('.form-row').each(function() {
                            const key = $(this).find('.form-key').val().trim();
                            const value = $(this).find('.form-value').val().trim();
                            if (key) {
                                data[key] = value;
                            }
                        });
                        // 如果没有填写表单数据但有参数，使用参数
                        if (Object.keys(data).length === 0 && Object.keys(params).length > 0) {
                            data = params;
                        }
                    } else if (format === 'text') {
                        data = $('#requestBodyText').val().trim();
                    }
                }

                // 显示加载状态
                $('#responseStatus').text('加载中...');
                $('#responseContentContainer').html('<pre><code class="language-json" id="responseContent">// 正在发送请求...</code></pre>');
                $('#responseTime').text('');

                const startTime = new Date().getTime();

                // 发送请求
                $.ajax({
                    url: url,
                    method: method,
                    headers: headers,
                    data: data,
                    dataType: 'text', // 关键：明确指定响应类型为文本
                    success: function(response, textStatus, xhr) {
                        const endTime = new Date().getTime();
                        const duration = (endTime - startTime) + 'ms';
                        
                        $('#responseStatus').text(`HTTP ${xhr.status} ${xhr.statusText}`);
                        $('#responseTime').text(`耗时: ${duration}`);
                        
                        // 检查响应类型是否为图片
                        const contentType = xhr.getResponseHeader('Content-Type') || '';
                        const isImage = contentType.startsWith('image/');
                        
                        if (isImage) {
                            try {
                                // 直接使用原始URL显示图片
                                $('#responseContentContainer').html(`
                                    <div class="response-image-container">
                                        <img src="${url}" class="response-image" alt="API返回的图片" 
                                             style="display: block; -webkit-user-select: none; margin: auto; 
                                                    background-color: hsl(0, 0%, 90%); transition: background-color 300ms;">
                                    </div>
                                `);
                            } catch (e) {
                                $('#responseContentContainer').html(`<pre><code class="language-text" id="responseContent">无法显示图片: ${e.message}</code></pre>`);
                            }
                        } else {
                            // 尝试格式化JSON
                            try {
                                const json = JSON.parse(response);
                                $('#responseContentContainer').html(`<pre><code class="language-json" id="responseContent">${JSON.stringify(json, null, 2)}</code></pre>`);
                            } catch (e) {
                                // 非JSON响应，直接显示文本
                                $('#responseContentContainer').html(`<pre><code class="language-text" id="responseContent">${response}</code></pre>`);
                            }
                            
                            // 高亮代码
                            if (typeof Prism !== 'undefined') {
                                Prism.highlightAll();
                            }
                        }
                        
                        showNotification('请求成功', `API请求成功，耗时${duration}`, 'success');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        const endTime = new Date().getTime();
                        const duration = (endTime - startTime) + 'ms';
                        
                        $('#responseStatus').text(`错误: ${xhr.status} ${xhr.statusText}`);
                        $('#responseTime').text(`耗时: ${duration}`);
                        
                        const errorResponse = xhr.responseText || `请求失败: ${errorThrown}`;
                        $('#responseContentContainer').html(`<pre><code class="language-text" id="responseContent">${errorResponse}</code></pre>`);
                        
                        // 高亮代码
                        if (typeof Prism !== 'undefined') {
                            Prism.highlightAll();
                        }
                        
                        showNotification('请求失败', `API请求失败: ${xhr.statusText}`, 'error');
                    }
                });
            });

            // 粒子背景 - 使用粉色系
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 60,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffacc7"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.4,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffacc7",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.5
                            }
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });

            // 添加滚动动画
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.api-section');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            };

            window.addEventListener('scroll', animateOnScroll);
            // 初始检查
            animateOnScroll();
        });
        
        // 返回顶部按钮功能
        const backToTopButton = document.createElement('button');
        backToTopButton.className = 'back-to-top hide';
        backToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTopButton.setAttribute('aria-label', '返回顶部');
        document.body.appendChild(backToTopButton);
        
        // 监听滚动事件
        window.addEventListener('scroll', () => {
          if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('hide');
            backToTopButton.classList.add('show');
          } else {
            backToTopButton.classList.remove('show');
            backToTopButton.classList.add('hide');
          }
        });
        
        // 点击返回顶部
        backToTopButton.addEventListener('click', () => {
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
    </script>
</body>

</html>
