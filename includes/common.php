<?php
//error_reporting(0);//错误提示
if (defined('IN_CRONLITE')) return;
define('SYS_KEY', "IPMkYXHBJSykLc5qb7jFbrRNb8P4rM61");
define('IN_CRONLITE', true);
if (!defined('SYSTEM_ROOT')) {
    define('SYSTEM_ROOT', dirname(__FILE__) . '/');
}
if (!defined('ROOT')) {
    define('ROOT', dirname(SYSTEM_ROOT) . '/');
}

date_default_timezone_set('Asia/Shanghai'); //上海时间
$time = time(); //时间缀
$date = date("Y-m-d H:i:s"); //日期
$firstDay = date('Y-m-01', strtotime($date)); //本月第一天
$lastDay = date('Y-m-d', strtotime("{$firstDay} +1 month -1 day")); //本月最后一天
$pagesize = 15; //列表分页
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';
if (!defined('url')) {
    define('url', $siteurl);
}
if (!defined('CSS')) {
    define('CSS', $siteurl . 'admin/style/');
}
if (!defined('IMG')) {
    define('IMG', $siteurl . 'admin/img/');
}
session_start();
include_once(SYSTEM_ROOT . 'lib/Pinyin.class.php');
include_once(SYSTEM_ROOT . 'function.php');
include_once(SYSTEM_ROOT . 'member.php');
include_once(SYSTEM_ROOT . 'lib/Smtp.class.php');
//引入数据库配置
if (is_file(SYSTEM_ROOT . 'database.php')) {
    include_once(SYSTEM_ROOT . 'database.php');
} else {
    Install();
}
if (!$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname']) //检测安装1
{
    header('Content-type:text/html;charset=utf-8');
    echo '你还没安装！<a href="/install/">点此安装</a>';
    exit();
}
include_once(SYSTEM_ROOT . 'lib/Pdo.class.php');
//连接数据库
$DB = new \lib\PdoHelper($dbconfig); //new的时候传入配置 自动进入初始化方法

// 从数据库读取并写入缓存
$system_list = $DB->getAll("SELECT * FROM `api_system` ");
foreach ($system_list as $system_row) {
    $system[$system_row['name']] = $system_row['content'];
}

$password_hash = '!@#%!s!0';
include_once(SYSTEM_ROOT . 'msg.php');
// PHP版本检查：支持 PHP 5.6 到 PHP 8.5+
if (version_compare(PHP_VERSION, '5.6.0', '<')) {
    die(msg($msg = '<h3>PHP版本要求 >= PHP 5.6，当前版本：' . PHP_VERSION . '</h3><p>支持的版本范围：PHP 5.6 - PHP 8.5+</p>'));
}
// PHP 8.0+ 兼容性检查
if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
    // PHP 8.0+ 已移除一些函数，确保兼容性
    if (!function_exists('get_magic_quotes_gpc')) {
        // get_magic_quotes_gpc 在 PHP 7.4+ 已移除，已在 daddslashes 函数中处理
    }
}
$ip = realIp();
if (is_file(SYSTEM_ROOT . '360safe/360webscan.php')) {
    //360网站卫士
    require_once(SYSTEM_ROOT . '360safe/360webscan.php');
}
if (!defined('THEME')) {
    define('THEME', !empty($_GET['theme']) ? $_GET['theme'] : (isset($system['theme']) ? $system['theme'] : 'index'));
}
if (!defined('API_CSS')) {
    define('API_CSS', $siteurl . 'template/' . THEME . '/style/');
}
if (!defined('API_IMG')) {
    define('API_IMG', $siteurl . 'template/' . THEME . '/img/');
}

if (!defined('theme')) {
    define('theme', $siteurl . 'template/' . THEME . '/');
}

if (!defined('TEMPLATE_ROOT')) {
    define("TEMPLATE_ROOT", ROOT . "template/");
}
