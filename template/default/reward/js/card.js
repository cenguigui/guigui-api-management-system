// 右侧悬浮box和赞赏码
// 赞助js
// 打开赞赏码
function guigui_skmkq() {
    const xfxkp = document.getElementById('guigui_skmqk');
    if (xfxkp) {
        // 设置动画的开始和结束位置为正向
        xfxkp.style.setProperty('--guigui_right', '-500px');
        xfxkp.style.setProperty('--guigui_right_go', '120px');

        // 确保元素是可见的
        xfxkp.style.display = 'block';

        // 重新触发动画
        xfxkp.style.animation = 'none'; // 首先移除动画以重置
        xfxkp.offsetHeight; // 触发重绘
        xfxkp.style.animation = 'jinru 3s forwards'; // 应用新的动画
    }
}
// 关闭赞赏码
function guigui_guanbi_skm() {
    const xfxkp = document.getElementById('guigui_skmqk');
    if (xfxkp) {
        // 设置动画的开始和结束位置为反向
        xfxkp.style.setProperty('--guigui_skm', '150px');
        xfxkp.style.setProperty('--guigui_skm_to', '-500px');
        // 重新触发动画
        xfxkp.style.animation = 'none'; // 首先移除动画以重置
        xfxkp.offsetHeight; // 触发重绘
        xfxkp.style.animation = 'guigui_skmdh 2s forwards'; // 应用新的动画
        xfxkp.addEventListener('animationend',
            function () {
                xfxkp.style.display = 'none'; // 动画完成后隐藏元素
            },
            {
                once: true
            });
    }
}

// 关闭右下方悬浮盒子
function guanbi() {
    const xfxkp = document.getElementById('guigui_xfxkp');
    if (xfxkp) {
        // 设置动画的开始和结束位置为反向
        xfxkp.style.setProperty('--guigui_right', '120px');
        xfxkp.style.setProperty('--guigui_right_go', '-500px');
        // 重新触发动画
        xfxkp.style.animation = 'none'; // 首先移除动画以重置
        xfxkp.offsetHeight; // 触发重绘
        xfxkp.style.animation = 'jinru 3s forwards'; // 应用新的动画
        xfxkp.addEventListener('animationend',
            function () {
                xfxkp.style.display = 'none'; // 动画完成后隐藏元素
            },
            {
                once: true
            });
    }
}