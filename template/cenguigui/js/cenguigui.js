
// 左上角fps
$('body').before('<div id="fps" style="z-index:10000; position:fixed; top:3px; left:3px; font-size:12px; font-weight:bold;"></div>');
var showFPS = (function () {
    var requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback) {
        window.setTimeout(callback, 1000 / 60)
    };
    var fps = 0;
    var last = Date.now();
    var offset;
    var step = function () {
        offset = Date.now() - last;
        fps += 1;
        if (offset >= 1000) {
            last += offset;
            appendFps(fps);
            fps = 0
        }
        requestAnimationFrame(step)
    };
    var appendFps = function (fps) {
        $('#fps').html(fps + 'FPS')
    };
    step();
    return function () { }
})();


// 搜索功能实现
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    const toolCards = document.querySelectorAll('.tool-card');
    const searchResultsEl = document.querySelector('.search-results');
    const resultCountEl = document.querySelector('.result-count');
    const searchKeywordEl = document.querySelector('.search-keyword');

    // 搜索和取消图标
    const searchIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            `;

    const cancelIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            `;

    // 初始化按钮图标
    searchBtn.innerHTML = searchIcon;

    // 高亮关键词函数
    function highlightKeyword(text, keyword) {
        if (!keyword) return text;

        const regex = new RegExp(keyword, 'gi');
        return text.replace(regex, match =>
            `<span class="highlight">${match}</span>`
        );
    }

    // 更新按钮状态
    function updateButtonState() {
        if (searchInput.value.trim() !== '') {
            searchBtn.innerHTML = cancelIcon;
            searchBtn.classList.add('cancel-mode');
        } else {
            searchBtn.innerHTML = searchIcon;
            searchBtn.classList.remove('cancel-mode');
        }
    }

    // 清空搜索
    function clearSearch() {
        searchInput.value = '';
        performSearch();
        searchInput.focus();
    }

    // 搜索函数
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const lowerSearchTerm = searchTerm.toLowerCase();
        let matchCount = 0;

        // 更新按钮状态
        updateButtonState();

        if (searchTerm === '') {
            // 清空搜索时恢复所有卡片
            toolCards.forEach(card => {
                card.style.display = 'block';
                // 恢复原始文本
                const nameEl = card.querySelector('.tool-name');
                const descEl = card.querySelector('.tool-description');
                nameEl.innerHTML = nameEl.textContent;
                descEl.innerHTML = descEl.textContent;
            });
            searchResultsEl.style.display = 'none';
            return;
        }

        toolCards.forEach(card => {
            const nameEl = card.querySelector('.tool-name');
            const descEl = card.querySelector('.tool-description');
            const originalName = nameEl.textContent;
            const originalDesc = descEl.textContent;

            const nameMatch = originalName.toLowerCase().includes(lowerSearchTerm);
            const descMatch = originalDesc.toLowerCase().includes(lowerSearchTerm);

            if (nameMatch || descMatch) {
                card.style.display = 'block';
                matchCount++;

                // 高亮显示关键词
                nameEl.innerHTML = highlightKeyword(originalName, searchTerm);
                descEl.innerHTML = highlightKeyword(originalDesc, searchTerm);
            } else {
                card.style.display = 'none';
                // 恢复原始文本
                nameEl.innerHTML = originalName;
                descEl.innerHTML = originalDesc;
            }
        });

        // 更新搜索结果信息
        if (searchTerm) {
            searchResultsEl.style.display = 'block';
            resultCountEl.textContent = matchCount;
            searchKeywordEl.textContent = searchTerm;
        } else {
            searchResultsEl.style.display = 'none';
        }
    }

    // 输入事件监听
    searchInput.addEventListener('input', function () {
        performSearch();
        updateButtonState();
    });

    // 搜索按钮点击事件
    searchBtn.addEventListener('click', function () {
        if (searchBtn.classList.contains('cancel-mode')) {
            clearSearch();
        } else {
            performSearch();
        }
    });

    // 回车键触发搜索
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
});

/* 返回顶部功能 */
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // 平滑滚动
    });
}


// 友链图标懒加载
document.addEventListener("DOMContentLoaded", function () {
    // 观察器回调
    const lazyLoadObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '100px', // 提前100px加载
        threshold: 0.01
    });

    // 观察所有懒加载图片
    document.querySelectorAll('.lazy-load').forEach(img => {
        lazyLoadObserver.observe(img);
    });
});

// 设置 cookie
function setCookie(name, value, hours) {
    const date = new Date();
    date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// 读取 cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
    }
    return null;
}

// 检测当前时间是否在暗色模式时间段内（18:00 - 6:00）
function isDarkModeTime() {
    const now = new Date();
    const hours = now.getHours();
    return hours >= 18 || hours < 6;
}


function autoToggleTheme() {
    const themeToggle = document.getElementById('theme-toggle');
    const darkModeCookie = getCookie('darkMode');
    const manualOverrideCookie = getCookie('manualOverride');

    // 如果用户手动切换了主题，并且未超过6小时，则保持手动设置
    if (manualOverrideCookie === 'true') {
        const overrideTime = new Date(parseInt(getCookie('overrideTime')));
        const now = new Date();
        if (now - overrideTime < 6 * 60 * 60 * 1000) {
            // 保持手动设置的主题
            const isDarkMode = getCookie('darkMode') === 'true';
            document.body.classList.toggle('dark-mode', isDarkMode);
            if (themeToggle) {
                themeToggle.innerHTML = isDarkMode ?
                    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>' :
                    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';
            }
            return;
        } else {
            // 超过6小时，清除手动切换的cookie
            setCookie('manualOverride', 'false', 0);
            setCookie('overrideTime', '0', 0);
        }
    }

    // 根据时间自动切换主题
    if (isDarkModeTime()) {
        document.body.classList.add('dark-mode');
        if (themeToggle) {
            themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
        }
        setCookie('darkMode', 'true', 24);
    } else {
        document.body.classList.remove('dark-mode');
        if (themeToggle) {
            themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';
        }
        setCookie('darkMode', 'false', 24);
    }
}


// DOM加载完成后执行
document.addEventListener('DOMContentLoaded', function () {
    // 获取元素
    const loader = document.querySelector('.loader');
    const themeToggle = document.getElementById('theme-toggle');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    const themeAnimation = document.querySelector('.theme-switch-animation');
    const moonIcon = document.querySelector('.moon-icon');
    const sunIcon = document.querySelector('.sun-icon');

    // 页面加载完成后隐藏加载动画
    window.addEventListener('load', function () {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 300);
    });

    // 初始化主题
    autoToggleTheme();

    // 每隔1分钟检查一次时间，自动切换主题
    setInterval(autoToggleTheme, 60 * 1000);

    // 暗色模式切换
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            // 显示动画
            if (document.body.classList.contains('dark-mode')) {
                // 切换到亮色模式
                if (sunIcon) sunIcon.classList.add('active');
                if (moonIcon) moonIcon.classList.remove('active');
            } else {
                // 切换到暗色模式
                if (moonIcon) moonIcon.classList.add('active');
                if (sunIcon) sunIcon.classList.remove('active');
            }

            if (themeAnimation) themeAnimation.classList.add('active');

            // 延迟切换主题，等待动画完成
            setTimeout(() => {
                document.body.classList.toggle('dark-mode');

                // 更新图标
                if (document.body.classList.contains('dark-mode')) {
                    themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
                    // 存储暗色模式
                    setCookie('darkMode', 'true', 24);
                } else {
                    themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';
                    // 存储亮色模式
                    setCookie('darkMode', 'false', 24);
                }

                // 记录用户手动切换的时间
                setCookie('manualOverride', 'true', 6);
                setCookie('overrideTime', new Date().getTime().toString(), 6);

                // 隐藏动画
                setTimeout(() => {
                    if (themeAnimation) themeAnimation.classList.remove('active');
                }, 800);
            }, 500);
        });
    }

    // 移动端菜单切换
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            if (navLinks) navLinks.classList.toggle('active');

            // 更新图标
            if (navLinks && navLinks.classList.contains('active')) {
                mobileMenuBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
            } else {
                mobileMenuBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
            }
        });
    }

    // 创建卡片点击波纹效果
    const toolCards = document.querySelectorAll('.tool-card');
    toolCards.forEach(card => {
        card.addEventListener('click', function (e) {
            // 创建波纹元素
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');

            // 设置波纹位置
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            // 添加并自动移除波纹
            this.appendChild(ripple);
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // 检测系统暗色模式首选项
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark-mode');
        if (themeToggle) {
            themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12</line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78</line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
        }
    }

    // 监听系统暗色模式变化
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (e.matches) {
            document.body.classList.add('dark-mode');
            if (themeToggle) {
                themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12</line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78</line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';
            }
        } else {
            document.body.classList.remove('dark-mode');
            if (themeToggle) {
                themeToggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg</svg>';
            }
        }
    });

    // 添加平滑滚动效果
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') {
                return; // 跳过无效的 href
            }

            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                window.scrollTo({
                    top: target.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // 显示欢迎提示
    setTimeout(() => {
        const toast = document.createElement('div');
        toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: var(--primary);
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 1000;
                font-size: 14px;
                font-weight: 500;
                opacity: 0;
                transition: opacity 0.3s, transform 0.3s;
            `;
        // 获取提示card_two
        var ApiTitle = document.getElementById('ApiTitle').getAttribute('ApiTitle');
        toast.textContent = ApiTitle;
        document.body.appendChild(toast);

        // 显示提示
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translate(-50%, -10px)';
        }, 100);

        // 自动隐藏提示
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, 10px)';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }, 1500);
});