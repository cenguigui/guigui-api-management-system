<?php

/**
 * 打赏
 * 悬浮卡片
 **/
// 引入数据库文件
include("./includes/common.php");
?>

<link rel="stylesheet" href="<?= theme ?>reward/css/card.css">
<!-- 阿里云图标 -->
<script src="https://at.alicdn.com/t/c/font_4458810_6f4ad2u55c8.js">
</script>
<!-- 右下角卡片 -->
<div class="guigui_xfkp" id="guigui_xfxkp" style="background-image: url(<?= $system['card_bg_img'] ?>);">
    <div class="guigui_biaoti">
    </div>
    <div id="guigui_jzsc">
        本站已安全运行449天7时7分39秒
    </div>
    <div class="guigui_text">
    </div>
    <div class="guigui_zanzhu" onclick="guigui_skmkq()">
        <p>
            赞助一下
        </p>
    </div>
    <div class="guigui_xfkpgb" onclick="guanbi()">
        <svg class="icon" aria-hidden="true">
            <use xlink:href="#icon-guanbi">
            </use>
        </svg>
    </div>
</div>
<!-- 右下角卡片 end-->
<!-- 赞赏码 -->
<div class="guigui_skm_box" id="guigui_skmqk" style="display: none;">
    <div class="guigui_skm">
        <div class="guigui_skm_img_p">
            <!-- QQ收款码 -->
            <img data-src="<?= $system['qqskm'] ?>" alt="" src="<?= $system['qqskm'] ?>">
            <p>
                QQ收款码
            </p>
        </div>
        <div class="guigui_skm_img_p">
            <!-- 微信收款码 -->
            <img data-src="<?= $system['wxskm'] ?>" alt="" src="<?= $system['wxskm'] ?>">
            <p>
                微信收款码
            </p>
        </div>
        <div class="guigui_skm_img_p">
            <!-- 支付宝收款码 -->
            <img data-src="<?= $system['zfbskm'] ?>" alt="" src="<?= $system['zfbskm'] ?>">
            <p>
                支付宝收款码
            </p>
        </div>
        <span onclick="guigui_guanbi_skm()">
            <svg class="guigui_icon" aria-hidden="true">
                <use xlink:href="#icon-guanbi">
                </use>
            </svg>
        </span>
    </div>
</div>
<!-- 手机端赞赏码 -->
<div class="guigui_reward">
    <button id="rewardButton" disable="enable" onclick="var qr = document.getElementById('QR'); if (qr.style.display === 'none') {qr.style.display='block';} else {qr.style.display='none'}">
        <span>
            打赏
        </span>
    </button>
    <div id="QR" style="display: none;">
        <div id="wechat" style="display: inline-block">
            <a class="fancybox" rel="group">
                <img id="wechat_qr" src="<?= $system['wxskm'] ?>" alt="微信打赏">
            </a>
            <p>
                微信
            </p>
        </div>
        <div id="alipay" style="display: inline-block">
            <a class="fancybox" rel="group">
                <img id="alipay_qr" src="<?= $system['zfbskm'] ?>" alt="还是支付宝打赏">
            </a>
            <p>
                支付宝
            </p>
        </div>
    </div>
</div>
<!-- 加载打字js -->
<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/typeit/7.0.0/typeit.min.js"></script>
<script src="<?= theme ?>reward/js/card.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    // 计算本站安全运行时长的函数
    // 获取id为guigui_jzsc的div元素
    var div = document.getElementById('guigui_jzsc');

    function getRunningTime() {
        var now = new Date();
        var startDate = new Date('<?= $system['run_time'] ?>'); // 假设站点开始运行的日期
        var diff = now - startDate; // 相差的毫秒数
        // 计算完整年份
        var years = now.getFullYear() - startDate.getFullYear();
        // 检查是否需要调整年份（如果今年的当前日期还没到开始日期，则减去一年）
        if (now.getMonth() < startDate.getMonth() || (now.getMonth() === startDate.getMonth() && now.getDate() < startDate.getDate())) {
            years--;
        }
        // 调整startDate到当前年份的相同月日，以计算剩余的天数
        startDate.setFullYear(now.getFullYear());
        // 如果经过调整后的startDate大于当前日期，则需要将startDate再往前调整一年
        if (startDate > now) {
            startDate.setFullYear(now.getFullYear() - 1);
        }
        diff = now - startDate; // 重新计算相差的毫秒数
        var days = Math.floor(diff / (1000 * 60 * 60 * 24)); // 计算天数
        var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // 计算小时数
        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)); // 计算分钟数
        var seconds = Math.floor((diff % (1000 * 60)) / 1000); // 计算秒数
        // 将结果赋值给div的innerText属性
        div.innerText = "本站已安全运行" + years + "年" + days + "天" + hours + "时" + minutes + "分" + seconds + "秒";
    }
    // 每秒更新一次运行时长
    setInterval(getRunningTime, 1000);
    // 初始显示一次
    getRunningTime();
    // 打字机
    // 打印标题
    new TypeIt(".guigui_biaoti", {
            speed: 100,
            waitUntilVisible: true
        }).type("<?= $system['card_title'] ?>")
        // .pause(500) // 在两段文本之间暂停500毫秒。
        // .type("欢迎来到我的api接口站！")
        .go();
    // 打印欢迎
    new TypeIt(".guigui_text", {
        loop: true,
        cursorSpeed: 1000,
        speed: 100
    }).type("<?= $system['card_one'] ?>").pause(2000).delete(null, {
        delay: 500
    }).type("<?= $system['card_two'] ?>！").pause(3000).go();
</script>