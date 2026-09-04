// 输出控制台
//   console.clear();  //清空控制台
console.log(`%c欢迎来到:%c笒鬼鬼api`, "padding: 5px 10px; border-radius: 5px 0 0 5px; background-color: #fd4970; font-weight: bold; color: #ffffff", "padding: 5px 10px; border-radius: 0 5px 5px 0; background-color: #ffe2ec; font-weight: bold; color: #fd4970");
console.log(`%c博主QQ:%c2963246343`, "padding: 5px 10px; border-radius: 5px 0 0 5px; background-color: #fd4970; font-weight: bold; color: #ffffff", "padding: 5px 10px; border-radius: 0 5px 5px 0; background-color: #ffe2ec; font-weight: bold; color: #fd4970");
console.log(`%c交流QQ群:%c972690382`, "padding: 5px 10px; border-radius: 5px 0 0 5px; background-color: #fd4970; font-weight: bold; color: #ffffff", "padding: 5px 10px; border-radius: 0 5px 5px 0; background-color: #ffe2ec; font-weight: bold; color: #fd4970");
// 卡哇伊
console.log(`%c
            く__,.ヘヽ.        /  ,ー､ 〉
                ＼ ', !-─‐-i  /  /´
                ／｀ｰ'       L/／｀ヽ､
            /   ／,   /|   ,   ,       ',
            ｲ   / /-‐/  ｉ  L_ ﾊ ヽ!   i
            ﾚ ﾍ 7ｲ｀ﾄ   ﾚ'ｧ-ﾄ､!ハ|   |
            !,/7 '0'     ´0iソ|    |
            |.从"    _     ,,,, / |./    |
            ﾚ'| i＞.､,,__  _,.イ /   .i   |
                ﾚ'| | / k_７_/ﾚ'ヽ,  ﾊ.  |
                | |/i 〈|/   i  ,.ﾍ |  i  |
                .|/ /  ｉ：    ﾍ!    ＼  |
                kヽ>､ﾊ    _,.ﾍ､    /､!
                !'〈//｀Ｔ´', ＼ ｀'7'ｰr'
                ﾚ'ヽL__|___i,___,ンﾚ|ノ
                    ﾄ-,/  |___./
                    'ｰ'    !_,.:
            `, "color: #fd4970;");

// 禁止控制台菜单
function openPopup() {
    document.getElementById("popupOverlay").style.display = "block";
    document.getElementById("popupContent").style.display = "block";
}

function closePopup() {
    document.getElementById("popupOverlay").style.display = "none";
    document.getElementById("popupContent").style.display = "none";
}

function showNotification(message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #ff5d9e;
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
    toast.textContent = message;
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
}

function disableDevToolsShortcuts() {
    document.addEventListener("keydown", function (event) {
        // 禁用 F12
        if (event.key === "F12") {
            event.preventDefault();
            showNotification("嘿！Bingo~ 老弟，试试 Alt+Shift+Fn+F4");
        }
        // 禁用 Ctrl+Shift+I
        else if (event.ctrlKey && event.shiftKey && event.key === "I") {
            event.preventDefault();
            showNotification("Ctrl+Shift+I 已被禁用,调试方法也得换换哟~");
        }

        // 禁用 Ctrl+Shift+J
        else if (event.ctrlKey && event.shiftKey && event.key === "J") {
            event.preventDefault();
            showNotification("Ctrl+Shift+J 已被禁用,调试方法也得换换哟~");
        }
        // 禁用 Ctrl+Shift+C
        else if (event.ctrlKey && event.shiftKey && event.key === "C") {
            event.preventDefault();
            showNotification("Ctrl+Shift+C 已被禁用,调试方法也得换换哟~");
        }
        // 禁用 Ctrl+S (保存网页)
        else if (event.ctrlKey && event.key === "s") {
            event.preventDefault();
            showNotification("Ctrl+S 已被禁用,调试方法也得换换哟~");
        }
        // 禁用 Ctrl+U (查看源代码)
        else if (event.ctrlKey && event.key === "u") {  // 改为小写 "u" 以兼容不同浏览器
            event.preventDefault();
            showNotification("Ctrl+U 已被禁用,调试方法也得换换哟~");
        }
        // 禁用 Alt+Menu (某些浏览器的开发者工具快捷键)
        else if (event.altKey && event.key === "Menu") {
            event.preventDefault();
            showNotification("Alt+Menu 已被禁用,调试方法也得换换哟~");
        }
        // 禁用 Ctrl+Shift+Del (某些浏览器的开发者工具快捷键)
        else if (event.ctrlKey && event.shiftKey && event.key === "Delete") {
            event.preventDefault();
            showNotification("Ctrl+Shift+Del 已被禁用,调试方法也得换换哟~");
        }
    });

    document.addEventListener("contextmenu", function (event) {
        event.preventDefault();
        showNotification("嘿！没有右键菜单，复制请用键盘快捷键 Ctrl+C");
    });

    // 禁用通过地址栏输入 javascript: 打开控制台
    document.addEventListener("keyup", function (event) {
        if (event.target.tagName === "INPUT" || event.target.tagName === "TEXTAREA") {
            return;
        }
        if (event.key === ":" && (event.ctrlKey || event.altKey || event.metaKey)) {
            event.preventDefault();
            showNotification("禁止通过地址栏输入代码打开控制台！");
        }
    });
}

// 调用函数以禁用开发者工具快捷键和右键菜单
disableDevToolsShortcuts();

// 创建一个 script 元素
var script = document.createElement('script');
// 设置 script 的 src 属性为文件路径
// script.src = './js/console-ban.min.js';
script.src = '/template/cenguigui/js/console-ban.min.js';
// 设置 script 的加载完成后的回调
script.onload = function () {
    // 默认选项初始化
    ConsoleBan.init();

    // 自定义选项初始化
    ConsoleBan.init({
        // 禁用的控制台方法跳转搜索
        redirect: 'https://cn.bing.com/search?q=笒鬼鬼Api'
    });
};
// 将 script 添加到文档的 head 中
document.head.appendChild(script);
