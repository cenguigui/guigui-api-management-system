<?php
include 'common.php';
class Template {
    
	static public function getList(){//遍历模板目录
		$dir = TEMPLATE_ROOT;
		$dirArray[] = NULL;
        if (false != ($handle = opendir($dir))) {
            $i = 0;
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && !strpos($file, ".")) {
                    $dirArray[$i] = $file;
                    $i++;
                }
            }
            closedir($handle);
        }
        return $dirArray;
	}
	static public function load($name = 'index'){//根据传入文件名 访问当前使用模板下文件
		$template = THEME;
		if(!preg_match('/^[a-zA-Z0-9]+$/',$name))exit('error');
		$filename = TEMPLATE_ROOT.$template.'/'.$name.'.php';
		$filename_default = TEMPLATE_ROOT.$template.'/'.$name.'.php';//你这里写死了模板了 你没发现？
		if(file_exists($filename)){
			return $filename;
		}elseif(file_exists($filename_default)){
			return $filename_default;
		}else{
			exit('<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>输入内容存在危险字符，安全起见，已被本站拦截</title>
<style>
body, h1, h2, p,dl,dd,dt{margin: 0;padding: 0;font: 12px/1.5 微软雅黑,tahoma,arial;}
body{background:#efefef;}
h1, h2, h3, h4, h5, h6 {font-size:14px;cursor:default; line-height:240%;}
ul, ol {list-style: none outside none;}
a {text-decoration: none;color:#447BC4}
a:hover {text-decoration: underline;}
.ip-attack{width:600px; margin:200px auto 0;}
.ip-attack dl{ background:#fff; padding:30px; border-radius:10px;border: 1px solid #CDCDCD;-webkit-box-shadow: 0 0 8px #CDCDCD;-moz-box-shadow: 0 0 8px #cdcdcd;box-shadow: 0 0 8px #CDCDCD;}
.ip-attack dt{text-align:center;}
.ip-attack dd{font-size:16px; color:#333; text-align:center;}
.tips{text-align:center; font-size:14px; line-height:50px; color:#999;}
</style>
</head>
<body>
<div class="ip-attack">
<dl>
<dt><h1>小子你想干嘛，想在我站sql注入/xss/一句话木马等常见渗透攻击吗！ </h1></dt>
<dt><a href="javascript:history.go(-1)">返回上一页</a></dt>
</dl>
</div>
<script>
var audio=document.createElement("audio");  
var play = function (s) {
    var URL = "https://fanyi.baidu.com/gettts?lan=zh&text=" + encodeURIComponent(s) + "&spd=5&source=web"
    if(!audio){
        audio.controls = false  
        audio.src = URL  
        document.body.appendChild(audio) 
    }
    audio.src = URL  
    audio.play();
}
play("小子你想干嘛，想在我站sql注入/xss/一句话木马等常见渗透攻击吗！");
</script>
</body>
</html>');
		}
	}
	static public function exists($template){//判断某模板下index.php文件是否存在
		$filename = TEMPLATE_ROOT.$template.'/index.php';
		if(file_exists($filename)){
			return true;
		}else{
			return false;
		}
	}
}
