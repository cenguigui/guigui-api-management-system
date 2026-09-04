<?php
// 定义可用的特效数组
$backgroundEffects = [
    // 背景圆点
    [
        'html' => '<canvas id="canvas-bg"></canvas>
                    <style type="text/css">
                    #canvas-bg {
                        position: fixed; /* 固定定位 */
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        z-index: -1; /* 确保画布在其他内容下方 */
                        pointer-events: none; /* 防止画布拦截鼠标事件 */
                    }
                    
                    /* 确保页面内容不会被背景遮挡 */
                    .content {
                        position: relative;
                        z-index: 1;
                    }
                            /* 动态背景样式 */
                            /*
                    
                            #canvas-bg {
                                position: fixed;
                                top: 0;
                                left: 0;
                                z-index: -1;
                                pointer-events: none;
                            }
                    */
                    </style>',
        'script' => '<script>
        // 优化粒子动画
        (function () {
            const canvas = document.getElementById("canvas-bg");
            const ctx = canvas.getContext("2d");
            let animationFrame;

            function initCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;

                const particles = [];
                const particleCount = Math.floor(window.innerWidth / 50);

                class Particle {
                    constructor() {
                        this.reset();
                        this.vy = (Math.random() - 0.5) * 0.3;
                    }

                    reset() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.vx = (Math.random() - 0.5) * 0.8;
                        this.radius = Math.random() * 5 + 1;
                        this.color = Math.random() > 0.9 ?
                            "rgba(255, 182, 193, 0.6)" : // 粉色粒子
                            "rgba(99, 102, 241, 0.3)";   // 蓝色粒子
                    }

                    update() {
                        this.x += this.vx;
                        this.y += this.vy;

                        if (this.x > canvas.width + 50 || this.x < -50) this.vx *= -1;
                        if (this.y > canvas.height + 50 || this.y < -50) this.reset();
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = this.color;
                        ctx.fill();
                    }
                }

                for (let i = 0; i < particleCount; i++) {
                    particles.push(new Particle());
                }

                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });
                    animationFrame = requestAnimationFrame(animate);
                }

                animate();
            }

            let resizeTimer;
            window.addEventListener("resize", () => {
                cancelAnimationFrame(animationFrame);
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(initCanvas, 200);
            });

            initCanvas();
        })();
    </script>'
    ],
    // 粒子特效
    [
        'html' => '<canvas id="canvas-bg"></canvas>
    <style>
        #canvas-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
            opacity: 0.7;
            transition: opacity 0.5s ease;
        }
        #canvas-bg:hover {
            opacity: 0.9;
        }
    </style>',
        'script' => '<script>
    // 优化粒子动画
    (function () {
        const canvas = document.getElementById(\'canvas-bg\');
        const ctx = canvas.getContext(\'2d\');
        let animationFrame;

        function initCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const particles = [];
            const particleCount = Math.floor(window.innerWidth / 50);

            class Particle {
                constructor() {
                    this.reset();
                    this.vy = (Math.random() - 0.5) * 0.3;
                }

                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.8;
                    this.radius = Math.random() * 5 + 1;
                    this.color = Math.random() > 0.9 ?
                        \'rgba(255, 182, 193, 0.6)\' : // 粉色粒子
                        \'rgba(99, 102, 241, 0.3)\';   // 蓝色粒子
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    if (this.x > canvas.width + 50 || this.x < -50) this.vx *= -1;
                    if (this.y > canvas.height + 50 || this.y < -50) this.reset();
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = this.color;
                    ctx.fill();
                }
            }

            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                animationFrame = requestAnimationFrame(animate);
            }

            animate();
        }

        let resizeTimer;
        window.addEventListener(\'resize\', () => {
            cancelAnimationFrame(animationFrame);
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(initCanvas, 200);
        });

        initCanvas();
    })();
    </script>'
    ],
    // 弹幕特效
    [
        'html' => '<div class="bg-pattern"></div>
                  <div id="danmu-container"></div>
                  <style>
                  /* 动态背景 */
                  .bg-pattern {
                      position: fixed;
                      top: 0;
                      left: 0;
                      width: 100vw;
                      height: 100vh;
                      background:
                          radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                          radial-gradient(circle at 90% 80%, rgba(129, 140, 248, 0.05) 0%, transparent 50%);
                      z-index: -1;
                  }

                  /* 弹幕容器 */
                  #danmu-container {
                      position: fixed;
                      top: 0;
                      left: 0;
                      width: 100vw;
                      height: 100vh;
                      pointer-events: none;
                      overflow: hidden;
                      z-index: 0;
                      mix-blend-mode: multiply;
                  }

                  .danmu {
                      position: absolute;
                      white-space: nowrap;
                      font-size: 16px;
                      opacity: 0.8;
                      animation: danmuMove linear forwards;
                      will-change: transform;
                      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                      transition: opacity 0.3s;
                      left: 100%;
                  }

                  @keyframes danmuMove {
                      from { transform: translateX(0); }
                      to { transform: translateX(calc(-100% - 100vw)); }
                  }
                  </style>',
        'script' => '<script>
                  (function() {
                      // 弹幕生成器
                      function createDanmu(text) {
                          const container = document.getElementById("danmu-container");
                          const danmu = document.createElement("div");
                          danmu.className = "danmu";
                          danmu.textContent = randomDecorator(text);
                          
                          // 随机样式
                          const top = Math.random() * 90;
                          const speed = 8 + Math.random() * 6;
                          const hue = 240 + Math.random() * 60;
                          const opacity = 0.6 + Math.random() * 0.3;
                          const size = 14 + Math.random() * 6;
                          
                          danmu.style.cssText = `
                              top: ${top}%;
                              animation-duration: ${speed}s;
                              color: hsla(${hue}, 80%, 70%, ${opacity});
                              font-size: ${size}px;
                              font-weight: ${Math.random() > 0.8 ? 600 : 400};
                          `;
                          
                          danmu.style.animationDelay = `${Math.random() * 2}s`;
                          
                          danmu.addEventListener("animationend", () => {
                              danmu.style.opacity = "0";
                              setTimeout(() => danmu.remove(), 300);
                          });
                          
                          container.appendChild(danmu);
                      }
                      
                      function randomDecorator(text) {
                          const decorators = [" ", "～", "！", "...", "♪ ", "❤️ ", "✓ "];
                          return decorators[Math.floor(Math.random() * decorators.length)] + text;
                      }
                      
                      // 弹幕内容库
                      const elegantTexts = [
                          "API 文档写得太棒了！", "这个接口设计真优雅～", "RESTful YYDS！", "GraphQL 请求成功 ✅",
                          "调试 API 中...", "Postman 测试通过！", "Swagger 页面加载完成", "OpenAPI 3.0 规范好评！",
                          "JWT Token 已刷新", "OAuth2 授权成功", "WebSocket 连接建立", "Webhook 回调触发",
                          "API 站点好看到哭了 😭", "502 Bad Gateway", "401 Unauthorized", "200 OK！",
                          "这个接口性能炸裂！", "响应时间 < 100ms 🚀", "API查询优化成功", "缓存命中率 99%",
                          "curl 请求示例：", "fetch() 调用成功", "axios.interceptors 真香", "API 版本控制很重要"
                      ];
                      
                      // 添加站点标题相关弹幕
                      const siteTitle = document.title;
                      if (siteTitle) {
                          elegantTexts.push(`「${siteTitle}」API 文档真清晰！`);
                          elegantTexts.push(`正在调试「${siteTitle}」的接口～`);
                      }
                      
                      // 初始弹幕
                      elegantTexts.forEach((text, i) => {
                          setTimeout(() => createDanmu(text), i * 200);
                      });
                      
                      // 定时生成弹幕
                      setInterval(() => {
                          const text = elegantTexts[Math.floor(Math.random() * elegantTexts.length)];
                          createDanmu(text);
                      }, 500);
                      
                      // 鼠标交互效果
                      document.addEventListener("mousemove", (e) => {
                          const danmus = document.querySelectorAll(".danmu");
                          danmus.forEach(danmu => {
                              const rect = danmu.getBoundingClientRect();
                              const distance = Math.sqrt(
                                  Math.pow(e.clientX - (rect.left + rect.width / 2), 2) +
                                  Math.pow(e.clientY - (rect.top + rect.height / 2), 2)
                              );
                              
                              danmu.style.opacity = distance < 150 ? "0.3" : "0.8";
                          });
                      });
                  })();
                  </script>'
    ]
];

// 随机选择一个特效
$randomEffect = $backgroundEffects[array_rand($backgroundEffects)];
// 输出特效HTML
echo $randomEffect['html'];
echo $randomEffect['script'];
