document.addEventListener("DOMContentLoaded", () => {
    // 检查 localStorage 中的数据，决定是否显示夜间模式
    if (localStorage.getItem("data-night")) {
        $(".Guigui_action_item.mode .icon-1").addClass("active");
        $(".Guigui_action_item.mode .icon-2").removeClass("active");
    } else {
        $("html").removeAttr("data-night");
        $(".Guigui_action_item.mode .icon-1").removeClass("active");
        $(".Guigui_action_item.mode .icon-2").addClass("active");
    }

    // 点击切换夜间模式
    $(".Guigui_action_item.mode").on("click", () => {
        if (localStorage.getItem("data-night")) {
            $(".Guigui_action_item.mode .icon-1").removeClass("active");
            $(".Guigui_action_item.mode .icon-2").addClass("active");
            $("html").removeAttr("data-night");
            localStorage.removeItem("data-night");
        } else {
            $(".Guigui_action_item.mode .icon-1").addClass("active");
            $(".Guigui_action_item.mode .icon-2").removeClass("active");
            $("html").attr("data-night", "night");
            localStorage.setItem("data-night", "night");
        }
    });

    // 点击左侧导航按钮显示/隐藏导航菜单
    $(".left_nav").on("click", function () {
        $(".Guigui_nav").toggleClass("active");
    });

    // 点击关闭按钮隐藏导航菜单
    $(".Guigui_nav_gaunbi").on("click", function () {
        $(".Guigui_nav").removeClass("active");
    });

    // 点击 body 隐藏导航菜单
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".Guigui_nav, .left_nav").length) {
            $(".Guigui_nav").removeClass("active");
        }
    });
});