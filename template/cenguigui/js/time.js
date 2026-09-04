// 获取公告字段
var time = document.getElementById('CenGuiGuiApi').getAttribute('time');
function updateRunningTime() {
    var div = document.getElementById('time-and-date');

    // 格式化时间（补零）
    function formatTime(unit) {
        return unit < 10 ? '0' + unit : unit;
    }

    // 获取当前时间和站点开始时间
    var now = new Date();
    var startDate = new Date(time); // 假设站点开始运行的日期
    var diff = now - startDate; // 相差的毫秒数

    // 计算完整年份
    var years = now.getFullYear() - startDate.getFullYear();
    if (now.getMonth() < startDate.getMonth() || (now.getMonth() === startDate.getMonth() && now.getDate() < startDate.getDate())) {
        years--;
    }

    // 调整startDate到当前年份的相同月日，以计算剩余的天数
    startDate.setFullYear(now.getFullYear());
    if (startDate > now) {
        startDate.setFullYear(now.getFullYear() - 1);
    }

    diff = now - startDate; // 重新计算相差的毫秒数

    // 计算天数、小时、分钟、秒
    const days = Math.floor(diff / (1000 * 60 * 60 * 24)); // 天数
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // 小时
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)); // 分钟
    const seconds = Math.floor((diff % (1000 * 60)) / 1000); // 秒

    // 获取当前星期几
    const weekdayIndex = now.getDay();
    const weekdays = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];

    // 格式化时间字符串
    const timeStr = `本站已安全运行 ${years}年 ${formatTime(days)}天 ${formatTime(hours)}时 ${formatTime(minutes)}分 ${formatTime(seconds)}秒 今天是(${weekdays[weekdayIndex]})嗷~`;

    // 如果时间发生变化，则更新 div 的内容
    if (div.innerText !== timeStr) {
        div.innerText = timeStr;
    }
}

// 每秒调用一次更新函数
setInterval(updateRunningTime, 1000);
