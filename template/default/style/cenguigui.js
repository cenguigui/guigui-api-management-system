// 获取公告字段
var gonggao = document.getElementById('gonggaoScript').getAttribute('gonggao');
// 判断公告是否为空
if (gonggao !== '') {

    // function hanMsg() {
    //     layer.alert(
    //         `<div>${gonggao}</div>`, {
    //             title: '公告', // 设置弹窗标题
    //             btn: '朕知道了！', // 设置确认按钮文字
    //             yes: function(index, layero){
    //                 // 点击确认按钮后的回调函数
    //                 // 可以在这里添加自定义逻辑
    //                 layer.close(index); // 关闭弹窗
    //             }
    //         }
    //     );
    // }

    //   function hanMsg() {
    //         Swal.fire({
    //             title: '公告',
    //             text: gonggao,
    //             icon: 'info', // 设置图标
    //             confirmButtonText: '朕知道了！',
    //             background: '#f8f9fa', // 弹窗背景色
    //             confirmButtonColor: '#ff5e00', // 按钮颜色
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 // 点击确认按钮后的回调
    //                 console.log('确认按钮点击');
    //             }
    //         });
    //     }


    // 打开页面弹窗
    function hanMsg() {
        Swal.fire({
            title: '公告', // 设置弹窗标题
            html: gonggao, // 允许HTML内容
            background: 'rgb(229 210 210)', // 设置背景颜色
            // imageUrl: 'https://api.cenguigui.cn/api/ipqmd/?diy=%E9%AC%BC%E9%AC%BCapi', // 设置图片URL
            imageWidth: 428, // 设置图片宽度
            imageHeight: 250, // 设置图片高度
            imageAlt: 'IP卡片', // 设置图片替代文本
            animation: true, // 开启动画效果
            confirmButtonText: '朕知道了!', // 设置确认按钮文本
            footer: '<span class="my-footer">文案:人间忽晚，山河已秋！</span>', // 设置页脚内容
        })
    }

    hanMsg();
}
// 关键词搜索
// 获取搜索框和列表
var input = document.getElementById("search");
var ul = document.getElementById("api-list");
// 获取所有列表项
var li = ul.getElementsByTagName("li");

// 给搜索框添加输入事件监听
input.addEventListener('input', function () {
    searchFilter(input.value);
});

// 给搜索框添加回车键事件监听
input.addEventListener('keydown', function (event) {
    // 如果按下回车键 (keyCode 13)
    if (event.key === 'Enter') {
        searchFilter(input.value);
    }
});

// 搜索函数
function searchFilter(query) {
    var filter = query.toLowerCase();
    // 循环所有列表项，检查它们是否匹配搜索框的值
    for (var i = 0; i < li.length; i++) {
        if (li[i].textContent.toLowerCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}


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