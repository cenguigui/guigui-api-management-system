<?php
include "../includes/common.php";
$title="资源分享";
// if($conf['repair']==0){
// 	sysmsg("<h3>You have been forbidden to visit this site!</h3>");
// }
// if(in_array(real_ip(),explode(",",$conf['prohibit_ip']))) {
// 	sysmsg("<h3>You have been forbidden to visit this site!</h3>");
// }
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $system['sysname']?> -  <?php echo $title ?></title>
    <meta name="keywords" content="<?php echo $system['keywords']; ?>"/>
    <meta name="description" content="<?php echo $system['description']?>">
    <meta itemprop="name" content="<?php echo $system['title']?>">
    <meta itemprop="image" content="../favicon.ico" />
    <link rel="icon" href="../favicon.ico" type="image/ico">
        <link rel="stylesheet" type="text/css" href="../assets/iframe/libs/layui/css/layui.css">
        <link rel="stylesheet" href="../assets/iframe/css/nprogress.css" media="all">
        <link rel="stylesheet" href="../assets/iframe/module/admin.css?v=318"/>
        <link rel="stylesheet" type="text/css" href="./assets/css/index.css" />
    <style>
    .imgc{
            background-image:url('../api/pic');
	        background-size:100% 100%;
	        background-repeat:repeat;
	        position:fixed;
	        width:100%;
	        height:100%;
	     }
	</style>
</head>
<body>
<div class="imgc"></div>
<div class="transparent_class">
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-tab layui-tab-brief">
          <div class="layui-card-header" style="height: 3em; line-height: 3em;">
		    <h3>
			  <p align="left" style="float:left">
			  <i class="layui-icon layui-icon-app">
			    <a>资源商城</a>                 
			  </i>
		    </h3>
          </div>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show" style="padding-top: 20px;">
                    <div class="layui-row layui-col-space60" id="Res"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 文章页面 -->
<script type="text/html" id="Article">
    <div class="layui-col-md3">
        <div class="project-list-item" style="margin:10px">
            <a href="<?=url?>down-{{d.id}}.html"><img class="project-list-item-cover" src="{{d.img}}"/></a>
            <div class="project-list-item-body">
            <h2><a href="<?=url?>down-{{d.id}}.html">{{d.title}}</a></h2>
                <div class="project-list-item-text layui-text">{{d.title_site}}</div>
                <div class="project-list-item-desc">
                    <span lay-tips="文章访问状态！">{{d.active}}</span>
                    <div class="ew-head-list">
                        <img class="ew-head-list-item" lay-tips="{{d.QQName}}" lay-offset="0,-5px" src="//q4.qlogo.cn/headimg_dl?dst_uin={{d.email}}&amp;spec=100"/>
                    </div>
                    <span class="article-list-item-tool-item" lay-tips="文章Top状态！">
                        <i class="layui-icon layui-icon-top"></i>&nbsp;
                    <span>{{d.top}}</span>
                  </span>
                    <span class="article-list-item-tool-item" lay-tips="文章发布时间！">
                        <i class="layui-icon layui-icon-date"></i>&nbsp;
                    <span>{{d.date}}</span>
                  </span>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script type="text/javascript" src="../assets/iframe/libs/layui/layui.js"></script>
<script type="text/javascript" src="../assets/iframe/js/common.js?v=318"></script>
<script>
layui.use(['layer', 'form', 'laydate', 'element', 'dataGrid', 'fileChoose'],function() {
	var $ = layui.jquery;
	var layer = layui.layer;
	var form = layui.form;
	var laydate = layui.laydate;
	var element = layui.element;
	var dataGrid = layui.dataGrid;
	var fileChoose = layui.fileChoose;
	dataGrid.render({
		elem: '#Res',
		templet: '#Article',
		url: './ajax.php?act=list',
		loadMore: { limit: 8 }
	});
});
</script>
</body>
</html>