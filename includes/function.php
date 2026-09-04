<?php
//跳转安装
    function Install()
    {
        die('<script>alert("还未安装，请先安装笒鬼鬼程序！");location.href="'.url.'install/";</script>');
    }
//校验常量是否定义且不为空，如果传入的是数组，则有一个未定义或未空就返回false
    function checkConstants($constants)
    {
        if (!is_array($constants)) {
            return defined($constants) && !empty($constants);
        }
        foreach ($constants as $constant) {
            if (!defined($constant) || empty($constants)) {
                return false;
            }
        }
        return true;
    }
/**
 * @Description TODO 校验字符是否存在
 */
function strexists($string, $find){
    return !(strpos($string, $find) === FALSE);
}

/**
 * @Description TODO 过滤参数
 */
function daddslashes($string, $force = 0, $strip = FALSE){
    // PHP 7.4+ 已移除 get_magic_quotes_gpc()，兼容处理
    if (!defined('MAGIC_QUOTES_GPC')) {
        if (function_exists('get_magic_quotes_gpc')) {
            define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        } else {
            define('MAGIC_QUOTES_GPC', false);
        }
    }
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = daddslashes($val, $force, $strip);
            }
        } else {
            $string = addslashes($strip ? stripslashes($string) : $string);
        }
    }
    return $string;
}

/**
 * @Description TODO 获取访问者IP
 */
function realIp(){
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}

/**
 * @Description TODO 根据IP获取地址
 */
function getCityByIp($cip){
    $url = "http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=" . $cip;
    $url = mb_convert_encoding(file_get_contents($url), "UTF-8", "gb2312");
    if ($ipinfo = json_decode($url, true)) {
        if ($ipinfo['city'] != null) {
            $city['city'] = $ipinfo['city'];
        } else if ($ipinfo['pro'] != null) {
            $city['city'] = $ipinfo['pro'];
        } else if ($ipinfo['addr'] != null) {
            $city['city'] = $ipinfo['addr'];
        } else {
            $city['city'] = '未知地点';
        }
        return $city;
    } else {
        $city['city'] = '未知地点';
        return $city;
    }
}

/**
 * description:TODO 校验字符串
 */
function CheckChars($str){
    if(empty($str))return false;
    return (bool)preg_match("/^([a-z\s]*)$/isU",$str);
}


/**
 * description:TODO 邮件模板
 */
function emailWritting($content){
    global $system;
    return '
    <table style="width: 99.8%; ">
        <tbody>
            <tr>
                <td id="QQMAILSTATIONERY" style="background:url(https://rescdn.qqmail.com/zh_CN/htmledition/images/xinzhi/bg/a_07.jpg) repeat-x #e4ebf5; min-height:550px; padding: 100px 55px 200px;">
                    <font size="4">尊敬的用户，您好：<br><br>&nbsp;&nbsp;&nbsp;&nbsp;'.$content.'<br><br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp; 如不是您本人操作，请忽略此邮件。<br>&nbsp;&nbsp; <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$system['sysname'].'
                    </font><br>
                </td>
            </tr>
        </tbody>
    </table>
    ';
}

/**
 * description:TODO 发送邮件
 */
function sendEmail($to, $sub, $msg){
    global $system;
    $From = $system['mail_name'];
    $Host = $system['mail_smtp'];
    $Port = $system['mail_port'];
    $SMTPAuth = 1;
    $Username = $system['mail_name'];
    $Password = $system['mail_pwd'];
    $Nickname = $system['web_name'];
    $SSL = $system['mail_port'] == 465 ? 1 : 0;
    $mail = new SMTP($Host, $Port, $SMTPAuth, $Username, $Password, $SSL);
    $mail->att = array();
    if ($mail->send($to, $From, $sub, $msg, $Nickname)) {
        return true;
    } else {
        return $mail->log;
    }
}

/**
 * description:TODO 访问URL
 */
function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept: */*";
    $httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
    $httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
    $httpheader[] = "Connection: close";
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        if ($referer == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

/**
 * description:TODO 检测移动端
 */
function checkmobile(){
    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $ualist = array('android', 'midp', 'nokia', 'mobile', 'iphone', 'ipod', 'blackberry', 'windows phone');
    if ((dstrpos($useragent, $ualist) || strexists($_SERVER['HTTP_ACCEPT'], "VND.WAP") || strexists($_SERVER['HTTP_VIA'], "wap")))
        return true;
    else
        return false;
}
function dstrpos($string, $arr){
    if (empty($string)) return false;
    foreach ((array)$arr as $v) {
        if (strpos($string, $v) !== false) {
            return true;
        }
    }
    return false;
}

/**
 * description:TODO 授权检测
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0){
    $ckey_length = 4;
    // 兼容性处理：如果 ENCRYPT_KEY 未定义，使用 SYS_KEY
    $encrypt_key = defined('ENCRYPT_KEY') ? ENCRYPT_KEY : (defined('SYS_KEY') ? SYS_KEY : 'default_key');
    $key = md5($key ? $key : $encrypt_key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * description:TODO 获取随机字符串
 */
function getRandStr($len = 5, $type = 0){
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str);
    $randstr = '';
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    if ($type == 1) {
        $randstr = strtoupper($randstr);//把所有字符转换为大写
    } elseif ($type == 2) {
        $randstr = strtolower($randstr);//把所有字符转换为小写
    }
    return $randstr;
}

/**
 * @Description TODO 生成随机字符
 */
function random($length, $numeric = 0){
    $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    // 修复：使用方括号替代花括号，兼容 PHP 7.4+
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * description:TODO 提示信息
 */
function sysmsg($msg = '未知的异常', $die = true){
    echo '
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>站点提示信息</title>
        <style type="text/css">
            html {
                background: #eee
            }

            body {
                background: #fff;
                color: #333;
                font-family: "微软雅黑", "Microsoft YaHei", sans-serif;
                margin: 2em auto;
                padding: 1em 2em;
                max-width: 700px;
                -webkit-box-shadow: 10px 10px 10px rgba(0, 0, 0, .13);
                box-shadow: 10px 10px 10px rgba(0, 0, 0, .13);
                opacity: .8
            }

            h1 {
                border-bottom: 1px solid #dadada;
                clear: both;
                color: #666;
                font: 24px "微软雅黑", "Microsoft YaHei",, sans-serif;
                margin: 30px 0 0 0;
                padding: 0;
                padding-bottom: 7px
            }

            #error-page {
                margin-top: 50px
            }

            h3 {
                text-align: center
            }

            #error-page p {
                font-size: 9px;
                line-height: 1.5;
                margin: 25px 0 20px
            }

            #error-page code {
                font-family: Consolas, Monaco, monospace
            }

            ul li {
                margin-bottom: 10px;
                font-size: 9px
            }

            a {
                color: #21759B;
                text-decoration: none;
                margin-top: -10px
            }

            a:hover {
                color: #D54E21
            }

            .button {
                background: #f7f7f7;
                border: 1px solid #ccc;
                color: #555;
                display: inline-block;
                text-decoration: none;
                font-size: 9px;
                line-height: 26px;
                height: 28px;
                margin: 0;
                padding: 0 10px 1px;
                cursor: pointer;
                -webkit-border-radius: 3px;
                -webkit-appearance: none;
                border-radius: 3px;
                white-space: nowrap;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0, 0, 0, .08);
                box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0, 0, 0, .08);
                vertical-align: top
            }

            .button.button-large {
                height: 29px;
                line-height: 28px;
                padding: 0 12px
            }

            .button:focus, .button:hover {
                background: #fafafa;
                border-color: #999;
                color: #222
            }

            .button:focus {
                -webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, .2);
                box-shadow: 1px 1px 1px rgba(0, 0, 0, .2)
            }

            .button:active {
                background: #eee;
                border-color: #999;
                color: #333;
                -webkit-box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, .5);
                box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, .5)
            }

            table {
                table-layout: auto;
                border: 1px solid #333;
                empty-cells: show;
                border-collapse: collapse
            }

            th {
                padding: 4px;
                border: 1px solid #333;
                overflow: hidden;
                color: #333;
                background: #eee
            }

            td {
                padding: 4px;
                border: 1px solid #333;
                overflow: hidden;
                color: #333
            }
        </style>
    </head>
    <body id="error-page"><h3>站点提示信息</h3>
    '. $msg .'
    </body>
    </html>';
    if ($die == true) {
        exit;
    }
}

/**
 * @Description TODO 获取菜单名称
 */
function checkIfActive($string) {
	$array=explode(',',$string);
	$php_self=substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],'/')+1,strrpos($_SERVER['REQUEST_URI'],'.')-strrpos($_SERVER['REQUEST_URI'],'/')-1);
	if (in_array($php_self,$array)){
		return 'active';
	}else
		return null;
}

/**
 * @Description TODO 获取文字拼音
 */
function PinyinChange($info, $type=''){
    $class = new \Think\Pinyin();
    if(empty($info)){
        exit;
    }
    if($type == 1){//首字母
        $return = $class->str2py($info);
    }else{//全拼
        $return = $class->str2pys($info);
    }
    return $return;
}

/**
 * @Description TODO 验证主机
 */
function checkRefererHost(){
	if(!$_SERVER['HTTP_REFERER'])return false;
	$url_arr = parse_url($_SERVER['HTTP_REFERER']);
	$http_host = $_SERVER['HTTP_HOST'];
	if(strpos($http_host,':'))$http_host = substr($http_host, 0, strpos($http_host, ':'));
	return $url_arr['host'] === $http_host;
}

/**
 * @Description TODO 获取N天时间缀
 */
function getDayTimes($type,$day,$info=''){
	if($type=="+"){
	    if($info==1){
	        $date = date("Y-m-d 00:00:00",strtotime("+$day day"));
	    }elseif($info==2){
	        $date = date("Y-m-d 23:59:59",strtotime("+$day day"));
	    }else{
	        $date = date("Y-m-d",strtotime("+$day day"));
	    }
	}else{
	    if($info==1){
	        $date = date("Y-m-d 00:00:00",strtotime("-$day day"));
	    }elseif($info==2){
	        $date = date("Y-m-d 23:59:59",strtotime("-$day day"));
	    }else{
	        $date = date("Y-m-d",strtotime("-$day day"));
	    }
	}
	return strtotime($date);
}

/**
 * @Description TODO 获取N天日期
 */
function getDayDate($type,$day,$info=''){
	if($type=="+"){
	    if($info==1){
	        $date = date("Y-m-d 00:00:00",strtotime("+$day day"));
	    }elseif($info==2){
	        $date = date("Y-m-d 23:59:59",strtotime("+$day day"));
	    }else{
	        $date = date("Y-m-d",strtotime("+$day day"));
	    }
	}else{
	    if($info==1){
	        $date = date("Y-m-d 00:00:00",strtotime("-$day day"));
	    }elseif($info==2){
	        $date = date("Y-m-d 23:59:59",strtotime("-$day day"));
	    }else{
	        $date = date("Y-m-d",strtotime("-$day day"));
	    }
	}
	return $date;
}

/**
 * @Description TODO 时间缀转日期或日期转时间缀
 */
function getTimesDate($info,$type=null){
	if($type==1){
	    if($info){
	        return date('Y-m-d H:i:s',$info);
	    }else{
	        return '';
	    }
	}elseif($type==2){
	    if($info){
	        return strtotime($info);
	    }else{
	        return '';
	    }
	}else{
	    return '';
	}
}

/**
 * @Description TODO 获取分页
 */
function getMemberPaging($numrows,$page=null){
	global $pagesize;
	
	$pages=ceil($numrows/$pagesize);
	$page=isset($page)?intval($page):1;
	$offset=$pagesize*($page - 1);
	
	echo'<nav class="mt-4" aria-label="Page navigation example"><ul class="pagination justify-content-center">';
	$first=1;
	$prev=$page-1;
	$next=$page+1;
	$last=$pages;
	if ($page>1){
		echo '<li class="page-item"><a class="page-link" href="?p='.$first.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
	} else {
		echo '<li class="page-item"><a class="page-link">首页</a></li>';
	}
	
	$start=$page-10>1?$page-10:1;
	$end=$page+10<$pages?$page+10:$pages;
	
	for ($i=$start;$i<$page;$i++)
        echo '<li class="page-item"><a class="page-link" href="?p='.$i.'">'.$i.'</a></li>';
		echo '<li class="page-item active"><a class="page-link" href="?p='.$page.'">'.$page.'</a></li>';

	for ($i=$page+1;$i<=$end;$i++) 
	    echo '<li class="page-item"><a class="page-link" href="?p='.$i.'">'.$i.'</a></li>';
	
	if ($page<$pages){
	    echo '<li class="page-item"><a class="page-link" href="?p='.$last.'" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
	} else {
		echo '<li class="page-item"><a class="page-link">尾页</a></li>';
	}
	echo'</ul></nav>';
}

/**
 * @Description TODO 创建文件夹
 */
function mkdirs($dir, $mode = 0777){
	if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
	if (!mkdirs(dirname($dir), $mode)) return FALSE;
	return @mkdir($dir, $mode);
}

/**
 * @Description TODO 转换微秒时间缀
 */
function getMicrosecond($info){
	$date_time_array = getdate($info/1000);
	
	$hours = $date_time_array["hours"]; //小时
    $minutes = $date_time_array["minutes"];//分
    $seconds = $date_time_array["seconds"];//秒
    $day = $date_time_array["mday"];//日
    $month = $date_time_array["mon"];//月
    $year = $date_time_array["year"];//年
    
    return "{$year}-{$month}-{$day} {$hours}:{$minutes}:{$seconds}"; //拼接输出年月日
}

/**
 * @Description TODO 增加API浏览量
 */
function ApiViews($alias=''){
    global $DB;
	if($alias){
		$DB->exec("UPDATE `api_apilist` set `views`=views+1 WHERE `alias`='{$alias}'");
	}
}

function isValidDomain($domain)
{
	if (strpos($domain, ".") === false) {
		return false;
	}
	$explode = explode(".", $domain);
	$strlenAll = 0;
	foreach ($explode as $k => $v) {
		if (empty($v)) {
			return false;
		}
		$strlen = strlen($v);
		if (intval(0) < $k) {
			$strlenAll = $strlen + $strlenAll;
		}
		if ($strlen < intval(1) || intval(63) < $strlen) {
			return false;
		}
		if (intval(255) < $strlenAll) {
			return false;
		}
	}
	return true;
}

/**
 * @Description TODO 清理系统配置缓存
 */
function clearSystemCache() {
	$cache_file = defined('SYSTEM_ROOT') ? SYSTEM_ROOT . 'cache/system_config.php' : dirname(__FILE__) . '/cache/system_config.php';
	if (file_exists($cache_file)) {
		@unlink($cache_file);
		return true;
	}
	return false;
}
?>