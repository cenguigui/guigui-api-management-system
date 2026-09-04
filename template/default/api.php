<?php
include("./includes/common.php");
$alias = trim(strip_tags(daddslashes($_GET['alias'])));
$content = $DB->getRow("SELECT * FROM `api_apilist` WHERE `alias`='{$alias}' AND `status`='1' LIMIT 1");
if(empty($content)){exit('<script language="javascript">window.location.href="/404.html";</script>');}
ApiViews($alias);

// 统计
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
file_get_contents($protocol . "://" . $_SERVER['HTTP_HOST'] . '/api/tongji/?t=1');
// 统计end

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		<meta name="renderer" content="webkit">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title><?=$content['name']?> - <?=$system['sysname']?></title>
		<meta name="keywords" content="<?=$system['keywords']?>">
		<meta name="description" content="<?=$system['description']?>">
		<meta property="og:description" content="<?=$system['description']?>">
		<meta property="og:site_name" content="<?=$system['title']?>">
		<meta property="og:title" content="<?=$system['title']?>">
		<meta property="og:url" content="<?=url?>" />
		<link rel="shortcut icon" type="image/x-icon" href="https://q1.qlogo.cn/g?b=qq&nk=2963246343&s=640">
		<!--<link rel="stylesheet" href="<?=theme?>style/layui/css/layui.css">-->
		<link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.4/css/layui.min.css">
		<link rel="stylesheet" href="<?=theme?>style/css/style4.0.css">
		<!--<link href="<?= theme ?>style/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
		<link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
		<!-- 加载JQuery -->
		<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	</head>

	<!--定义背景图 --guigui_bg_img  -->
	<body style="--guigui_bg_img: url('<?=$system['bg_img']?>');">
		<div class="layui-fluid" style="padding: 0;margin: 0;">
			<div class="layui-row">
				<div class="layui-col-md8 layui-col-md-offset2" style="height: 100%;background:rgba(0, 0, 0, 0.3);padding: 38px 0px 0px 18px;">
					<h1 class="title"><a href="<?=$content['alias']?>.html" title="<?=$content['remarks']?>"><?=$content['name']?></a></h1>
					<div class="navigation layui-anim layui-anim-scaleSpring">
						<a class="home" href="/"><i class="layui-icon layui-icon-home"></i> 首页 </a> >> 
						<a class="this" href="<?=$content['alias']?>.html"><i class="layui-icon layui-icon-location"></i> <?=$content['name']?> </a>
						<h2 class="content"><?=$content['remarks']?></h2>
						<span class="hot"><i class="layui-icon layui-icon-fire"> </i><?=$content['views']?></span>
						<span class="auther"><i class="layui-icon layui-icon-username"> </i><?=$system['sysname']?></span>
					</div>
					<hr class="layui-bg-orange">
					<div class="apihead layui-anim layui-anim-scaleSpring">
						<h2 class="api">接口地址</h2>
						<h3 class="apicode"><span id="text"><?=$content['apiurl']?></span></h3>
						<h2 class="return">返回格式</h2>
						<h3 class="returncode"><span id="text"><?=$content['apiformat']?></span></h3>
						<h2 class="request">请求方式：</h2>
						<h3 class="requestcode"><span id="text"><?=$content['request']?></span></h3>
						<h2 class="example">请求示例：</h2>
						<h3 class="examplecode"><span id="text"><?=$content['apirequest']?></span></p>
					</div>
					<div class="apicon layui-anim layui-anim-up">
						<h2 class="canshu">参数说明</h2>
						<table class="layui-table" style="display: inline-block;background-color: rgba(0, 0, 0, 0);color: #ffffff;">
							<colgroup>
								<col width="150">
								<col width="200">
								<col>
							</colgroup>
							<thead>
								<tr>
									<th>名称</th>
									<th>必填</th>
									<th>类型</th>
									<th>说明</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?=$content['explain']?>
								</tr>
							</tbody>
						</table>
						<h2 class="result">返回数据</h2>
						<pre class="layui-code"><?=$content['return']?></pre>
						
						<h2 class="diaoyong">调用实例</h2>
						<pre class="layui-code"><?=htmlspecialchars($content['example'])?></pre>
						
						<h2 class="request">示例代码</h2>
						<pre class="layui-code"><?=$content['examples']?>
						</pre>
					</div>
					<div class="footer">
						<p style="font-weight: bold;"><?=$system['sysname']?> 共被调用 <span style="color:#fa6400;"><?=$views?></span> 次(调用统计不准)</p>
						<p><a href="https://beian.miit.gov.cn/" target="_blank"><?=$system['icp']?></a></p>
						<p><a href="/" target="_blank">Copyright © <?=date('Y')?> <?=$system['sysname']?></a></p>
					</div>
				</div>
			</div>
		</div>
		<!--侧栏-->
        <?php
            include("links/links.php");
        ?>
        <!--打赏-->
        <?php
            include("reward/reward.php");
        ?>
		<!--<script src="<?=theme?>style/layui/layui.js"></script>-->
		<!--<script src="<?=theme?>style/clipboard.min.js"></script>-->
		<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.4/layui.js"></script>
        <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
		<script>
			layui.use(['jquery', 'layer'], function() {
				var $ = layui.$,
					layer = layui.layer;
				$("h3 span").click(function() {
					var clipboard = new ClipboardJS('#text', {
						text: function(res) {
							var url = res.innerHTML;
							var zzre = url.replace(/amp;/g, "");
							return zzre
						}
					});
					clipboard.on('success', function(e) {
						layer.msg('复制成功，感谢您的支持，在茫茫人海中选择了我！!')
					});
					clipboard.on('error', function(e) {
						layer.msg('复制失败，好像出问题了，联系笒鬼鬼Q：2963246343!')
					})
				})
			});
			// 监听Ctrl+C事件
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.key === 'c') {
                    layer.msg('复制成功，感谢您的支持，在茫茫人海中选择了我！');
                }
            });
		</script>
	</body>
</html>
