<?php
include "../includes/common.php";
$id = intval($_GET["id"]);
$rs = $DB->query("SELECT*FROM api_down WHERE id='{$id}' limit 1 ");
while($res = $rs->fetch()) {
	if ($res["status"] == 0) {
		sysmsg("<h4>" . $res["Maintain"] . "</h4>");
	}
	if ($res["email"] == "") {
		$email = "<span class='label label-danger'>官方发布</span>";
	} elseif ($res["email"] == "" . $res["email"] . "") {
		$email = "<img src='./assets/icon/qqpay.ico'> <span class='label label-yellow'><a href='http://wpa.qq.com/msgrd?v=3&uin=" . $res["email"] . "&site=qq&menu=yes'> " . $res["email"] . "</a></span>";
	}
	if ($res["Yes"] == 1) {
		$down = "<blockquote class='layui-elem-quote'>下载地址：<a href='" . $res["down"] . "'>" . $res["down"] . "</a></blockquote>";
	} elseif ($res["Yes"] == 0) {
		$down = "<blockquote class='layui-elem-quote'>该文章没有下载资源~ </blockquote>";
	}
	?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title><?php echo $res["title"];?></title>
    <meta itemprop="name" content="<?php echo $res["title"];?>">
    <meta name="description" itemprop="description" content="<?php echo $res["title_site"];?>">
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <link rel="stylesheet" type="text/css" href="../assets/iframe/libs/layui/css/layui.css">
    <link rel="stylesheet" href="../assets/iframe/css/nprogress.css" media="all">
        <link rel="stylesheet" href="../assets/iframe/module/admin.css?v=318"/>
    <link rel="stylesheet" href="../down/assets/css/down.css" />
    <style>
    .imgc{
            background-image:url('../Api/bing.php');
	        background-size:100% 100%;
	        background-repeat:repeat;
	        position:fixed;
	        width:100%;
	        height:100%;
	     }
	</style>
</head>
<body layadmin-themealias="dark-blue" style="margin-top: 1em;">
    <div class="imgc"></div>
    <div id="divLoading">
        <div class="transparent_class">
            <div class="layui-fluid">
                <div class="a layui-anim layui-anim-fadein">
                    <div class="layui-row layui-col-space15">
                        <div class="layui-col-sm8 layui-col-sm-offset2 layui-col-md6  layui-col-md-offset3 layui-col-lg6 layui-col-xs12  layui-col-lg-offset3">
                            <div class="layui-card">
                                <div class="layui-card-header" style="height: 3em; line-height: 3em;">
		                            <h3>
			                        <p align="left" style="float:left">
			                            <i class="layui-icon layui-icon-app">
			                                <a>文章名称：<?php echo $res["title"];?></a>                 
			                            </i>
		                              </h3>
                                </div>
                                <div class="layui-card-body">
                                    <div class="layui-carousel" id="test">
                                        <div carousel-item>
                                            <img src='<?php echo $res["img"];?>' />
                                            <img src='./down/assets/icon/ggw.png'>
                                        </div>
                                    </div></br>
                                    <!--
                                    <blockquote class="layui-elem-quote layui-quote-nm">陌屿授权中心：<a href="http://auth.phpth.cn/">点击进入</a></p>免费API分享站：<a href="http://api.phpth.cn/">点击进入</a></p>PHP代码混淆加密：<a href="http://jiami.phpth.cn/">点击进入</a></blockquote>-->
                                    <fieldset class="layui-elem-field">
                                        <legend>文章介绍</legend>
                                        <div class="layui-field-box">
<?php  
       if ($res["content"]) {
		$content = $res["content"];
	}else if(!$res["content"]) {
		$content = "该文章没有介绍哟～";
	}
?>                                      	<?php echo $content;?>
                                        </div>
							        </fieldset>
         							<?php echo $down;?>         							
          							<fieldset class="layui-elem-field layui-field-title">
            							<legend>如有侵权联系管理删除！</legend>
          							</fieldset>
          						</div>
          					</div>
          				</div>
          			</div>
				</div> 
        	</div>
   		</div>
	</div>
</div>
<script type="text/javascript" src="../assets/iframe/libs/layui/layui.js"></script>
<script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
<script src="../assets/iframe/js/nprogress.js"></script>
<script>
layui.use('carousel',function() {
	var carousel = layui.carousel;
	carousel.render({
		elem: '#test',
		width: '100%',
		arrow: 'always'
	});
});
NProgress.start();
   function neeprog() {
   	NProgress.done();
   }
   window.onload=neeprog;
</script>
</boby>
</html>
<?php 
}
if (empty($id)) {
	exit(json_format(["code" => 0, "msg" => "无参数"]));
}