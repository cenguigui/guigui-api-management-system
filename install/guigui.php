<?php
/**
 * 笒鬼鬼API程序
 * 安装完成后建议删除此文件
 * @author Vance
 */
include('function.php');
//程序安装文件
error_reporting(0);
date_default_timezone_set("PRC");
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';
define('url',$siteurl);
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT',$_SERVER['DOCUMENT_ROOT'].'/includes/');
$databaseFile = '../includes/database.php';//数据库配额文件
@header('Content-Type: text/html; charset=UTF-8');
include $databaseFile;
   $do = isset($_GET['do']) ? $_GET['do'] : '0';
    if(file_exists('install.lock')) {
        $installed = true;
        $do = '0';
    }
    $support = true;

if($installed) { 
   installmsg();
}
$sitename = "笒鬼鬼API程序";
//错误信息
$errInfo = '';

//数据库配置文件
$dbConfigFile = $databaseFile;
// 锁定的文件
$lockFile = SYSTEM_ROOT . 'install.lock';
if (!is_really_writable($dbConfigFile))
{
    $errInfo = "";
    @file_put_contents(ROOT."database.php","<?php
/*数据库配置*/
\$dbconfig=array(
	'host' => '127.0.0.1', //数据库服务器
	'port' => 3306, //数据库端口
	'user' => '', //数据库用户名
	'pwd' => '', //数据库密码
	'dbname' => '', //数据库名
	'dbqz' => 'api' //数据表前缀 无须修改
);");
	msg("<h3>检测到(database.php)文件已删除或当前权限不足无法写入配置文件</h3>
	<h3>稍后系统会为你自动生成文件 <b style=\"color: red;\">请手动刷新</b></h3>", true);

}
// 当前是POST请求
if (!$errInfo && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $err = '';
    $host = isset($_POST['mysqlHost']) ? $_POST['mysqlHost'] : 'localhost';
    $port = 3306;
    $hostArr = explode(':', $host);
    if (count($hostArr) > 1)
    {
        $host = $hostArr[0];
        $port = $hostArr[1];
    }
    $user = isset($_POST['user']) ? $_POST['user'] : 'root';
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : 'root';
    $dbname = isset($_POST['dbname']) ? $_POST['dbname'] : 'root';
    $username = isset($_POST['username']) ? $_POST['username'] : 'admin';
    $password = isset($_POST['password']) ? $_POST['password'] : '123456';

    if ($password !== $password)
    {
        echo "两次输入的密码不一致";
        exit;
    }
    else if (!preg_match("/^\w+$/", $username))
    {
        echo "用户名只能输入字母、数字、下划线";
        exit;
    }
    else if (!preg_match("/^[\S]+$/", $password))
    {
        echo "密码不能包含空格";
        exit;
    }
    else if (strlen($username) < 3 || strlen($username) > 12)
    {
        echo "用户名请输入3~12位字符";
        exit;
    }
    else if (strlen($password) < 6 || strlen($password) > 16)
    {

        echo "密码请输入6~16位字符";
        exit;
    }
    try
    {
        //检测能否读取安装文件
        $sql = @file_get_contents(SYSTEM_ROOT . 'api.sql');
        if (!$sql)
        {
            throw new Exception("无法读取/install/api.sql文件，请检查是否有读权限");
        }
        $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pwd, array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));

        $pdo->query("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8 COLLATE utf8_general_ci;");

        $pdo->query("USE `{$dbname}`");

        $pdo->exec($sql);

        $conphp = "<?php
/*数据库配置*/
\$dbconfig=array(
	'host' => '".$host."', //数据库服务器
	'port' => '".$port."', //数据库端口
	'user' => '".$user."', //数据库用户名
	'pwd' => '".$pwd."', //数据库密码
	'dbname' => '".$dbname."', //数据库名
	'dbqz' => 'api' //数据表前缀 无须修改
);";
        //检测能否成功写入数据库配置
        $result = @file_put_contents($dbConfigFile, $conphp);
        if (!$result)
        {
            throw new Exception("无法写入数据库信息到database.php文件，请检查是否有写权限");
        }

        //检测能否成功写入lock文件
        $result = @file_put_contents($lockFile,'安装锁');
        if (!$result)
        {
            throw new Exception("无法写入安装锁定到/install/install.lock文件，请检查是否有写权限");
        }
        $newPassword = md5($password);
        $pdo->query("UPDATE api_admin SET username = '{$username}',password = '{$newPassword}'WHERE id = 1");
        echo "success";
    }
    catch (Exception $e)
    {
        $err = $e->getMessage();
    }
    catch (PDOException $e)
    {
        $err = $e->getMessage();
    }
    echo $err;
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<title><?=$sitename?> - 程序安装</title>
<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
<link href="<?=url?>install/install/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=url?>install/install/css/materialdesignicons.min.css" rel="stylesheet">
<link href="<?=url?>install/install/css/style.min.css" rel="stylesheet">
</head>
<style>
    .install-header > h3 {
        margin: 54px 0;
        width: 210px;
        height: 53px;
        display: inline-block;
    }
    .logo-header > img {
        margin: 100px 0;
        width: 210px;
        height: 36px;
    }
    
    .guide-box {
        padding: 32px 0;
        border-top: 5px solid #007bff;
    }

    .step-dots a, .step-dots a::before {
        background-color: #f4f4f4;
    }

    .site-content {
        margin: 0 20%;
        width: 60%;
    }

    .nav-step {
        margin-bottom: 0;
    }

    .nav-step-content > .nav-step-pane > .card > .card-body {
        padding-top: 24px;
    }

    .input-group.m-b-10.info-title {
        width: 100%;
        border-bottom: 1px solid #f1f1f3;
        padding-bottom: 5px;
    }

    .input-group-text {
        background-color: #fff0;
        border: 1px solid #fff0;
        padding-right: 0;
        padding-left: 0;
    }

    .input-group-text-right {
        white-space: nowrap;
        vertical-align: middle;
        display: table-cell;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        padding: 6px 0;
        float: right !important;
    }

    #server-info .col-md-4, #install-complete .col-md-6 {
        display: inline-block;
        padding-right: 0;
        padding-left: 0;
        width: 25%;
    }

    #install-complete .input-group-text {
        width: 35%;
    }

    #install-complete .input-group-text:first-child {
        text-align: right;
        padding-right: 12.5px;
    }

    #install-complete .input-group-text:last-child {
        text-align: left;
        padding-left: 12.5px;
    }

    #install-config-form .form-group {
        margin-bottom: 15px !important;
        display: grid;
    }

    @media (max-width: 769px) {
        .install-header > h3 {
            margin: 20px 0;
        }
        
        .logo-header > img {
            margin: 20px 0;
        }

        .site-content {
            margin: 0;
            width: 100%;
        }

        .input-group.m-b-10.info-title {
            padding-bottom: 0;
        }
    }
</style>

<body>
<div class="lyear-layout-web">
    <div class="lyear-layout-container">
        <div class="logo-header text-center">
            <img src="/logo.png">
        </div>
        <div class="container-fluid site-content">
            <?php if($do == '0') { ?>
            <div class="card">
                <div class="card-body text-center auth-nav guide-box">
                    <ul class="nav-step step-dots">
                        <li class="nav-step-item active">
                            <span>检测</span>
                            <a class="active"></a>
                        </li>

                        <li class="nav-step-item">
                            <span>配置</span>
                            <a></a>
                        </li>
                        <li class="nav-step-item">
                            <span>安装</span>
                            <a></a>
                        </li>
                        <li class="nav-step-item">
                            <span>完成</span>
                            <a></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="nav-step-content">
                <div class="nav-step-pane hidden active">
                    <div class="card">
                        <div class="card-header">
                            <h4>环境检测</h4>
                        </div>
                        <div class="card-body" id="server-info">
               <div class="input-group m-b-10 info-title"> 
                  <div class="col-md-4"><span class="input-group-addon input-group-text">检测项目</span></div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">需求</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">当前</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">状态</span> </div> 
              </div>  
              
               <div class="input-group m-b-10" style="width: 100%;">
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">PHP版本</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">PHP 5.6~8.2</span> </div>
                  <div class="col-md-4"> <span class="input-group-addon input-group-text"><?php echo phpversion(); ?></span> </div>
                    <div class="col-md-4"> 
                    <span class="input-group-addon input-group-text text-primary"><i class="mdi mdi-checkbox-marked-circle-outline"></i> <?php echo checkPHPVersion(); ?></span>
                    </div> 
               </div> 
              
              <div class="input-group m-b-10" style="width: 100%;">
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">mysqli扩展</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">数据库操作</span> </div>
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">--</span> </div>
                    <div class="col-md-4"> 
                    <span class="input-group-addon input-group-text text-primary"><i class="mdi mdi-checkbox-marked-circle-outline"></i> <?php echo checkExtension('mysqli'); ?></span>
                    </div> 
               </div> 
              
              <div class="input-group m-b-10" style="width: 100%;">
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">ZipArchive类</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">Zip压缩/解压</span> </div>
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">--</span> </div>
                    <div class="col-md-4"> 
                    <span class="input-group-addon input-group-text text-primary"><i class="mdi mdi-checkbox-marked-circle-outline"></i> <?php echo checkClass('ZipArchive'); ?></span>
                    </div> 
               </div> 
              
              <div class="input-group m-b-10" style="width: 100%;">
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">curl_exec()</span> </div> 
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">抓取网页</span> </div>
                  <div class="col-md-4"> <span class="input-group-addon input-group-text">--</span> </div>
                    <div class="col-md-4"> 
                    <span class="input-group-addon input-group-text text-primary"><i class="mdi mdi-checkbox-marked-circle-outline"></i> <?php echo checkFunction('curl_exec'); ?></span>
                    </div> 
               </div> 
            
             
                        </div>
                    </div>
                </div>
                
                <div class="nav-step-button">
                <div class="card" style="width: 100%;">
                    <div class="card-body text-center">
                        <a href="<?php if(!$support) {
              echo 'javascript:if(confirm("您的服务器环境不支持安装此程序，是否强制安装？将会出现不可避免的问题！")){location.href="index.php?do=1"}';
          } else {
              echo 'index.php?do=1';
          } ?>" class="btn btn-label btn-info" data-event="next" type="button">
                            <label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label> 下一步
                        </a>
                    </div>
                </div>
            </div>
                
                
                <div class="nav-step-pane hidden">
                    <?php } elseif($do == '1') { ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>网站配置</h4>
                        </div>
                        <div class="card-body">
                            <form id="install-config-form" method="post">
                                
                                <?php if ($errInfo): ?>
                                <div class="text-uppercase"
                                     style=" display: -webkit-box; align-items: center;-webkit-box-flex: 0;color: #f50037;font-size: 13px;font-weight: bold;padding-right: 15px;padding-left: 15px;padding-top: 15px;">
                                    <?php echo $errInfo; ?>
                                </div>

                            <?php endif; ?>
                            <div class="text-uppercase"
                                     style=" display: -webkit-box; align-items: center;-webkit-box-flex: 0;color: #f50037;font-size: 13px;font-weight: bold;padding-right: 15px;padding-left: 15px;padding-top: 15px;">
                                   <div id="error"style="display:none"></div>
                            </div>
                            <div  class="text-uppercase"
                                     style=" display: -webkit-box; align-items: center;-webkit-box-flex: 0;color: #f50037;font-size: 13px;font-weight: bold;padding-right: 15px;padding-left: 15px;padding-top: 15px;">
                                    <div id="success"  style="display:none"></div>
                            </div>
                            
                                <div class="form-group">
                                    <label class="col-xs-12">数据库地址</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="host" value="<?=$dbconfig['host'] ? $dbconfig['host'] : 'localhost'?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">数据库端口</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="port" value="<?=$dbconfig['port'] ? $dbconfig['port'] : 3306?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">数据库用户名</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="user" value="<?=$dbconfig['user']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">数据库密码</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="pwd" value="<?=$dbconfig['pwd']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">数据库名称</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="dbname" value="<?=$dbconfig['dbname']?>">
                                    </div>
                                </div>
                                <div class="divider text-uppercase"
                                     style="padding-right: 15px;padding-left: 15px;padding-top: 15px;">
                                    管理员配置
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">用户名</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="username" value="admin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">密码</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" name="password" value="123456">
                                    </div>
                                </div>
                                
                                <div class="card-body text-center">
                        <button class="btn btn-label btn-info" data-event="next" type="submit" <?php echo $errInfo ? 'disabled' : '' ?>>
                            <label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label> 安装
                        </button>
                        
                    </div>
                    
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="nav-step-pane hidden">
                    <?php } elseif($do == '2') { ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>安装完成</h4>
                        </div>
                        <div class="card-body" id="install-complete">
                                <div class="input-group" style="text-align: center;display: block;margin-bottom: 15px;">
                                    <span style="font-size: 25px;color: #33cabb;">
                                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                        安装完成
                                    </span>
                                </div>
                                <div class="input-group m-b-10" style="width: 100%;">
                                    <span class="input-group-addon input-group-text">后台地址：<?=url?>admin</span>
                                    <span class="input-group-addon input-group-text">
                                        <a class="btn btn-danger btn-xs" href="<?=url?>admin" target="_blank">
                                            点击进入
                                        </a>
                                    </span>
                                </div>
                                <div class="input-group m-b-10" style="width: 100%;">
                                    <span class="input-group-addon input-group-text">默认用户名：</span>
                                    <span class="input-group-addon input-group-text">admin</span>
                                </div>
                                <div class="input-group m-b-10" style="width: 100%;">
                                    <span class="input-group-addon input-group-text">默认密码：</span>
                                    <span class="input-group-addon input-group-text">123456</span>
                                </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
          
        </div>
    </div>
</div>
</body>


<script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
       <script>
            $(function () {
                $('form :input:first').select();

                $('form').on('submit', function (e) {
                    e.preventDefault();

                    var $button = $(this).find('button')
                        .text('安装中...')
                        .prop('disabled', true);

                    $.post('', $(this).serialize())
                        .done(function (ret) {
                            if (ret === 'success') {
                                $('#error').hide();
                                $("#success").text("安装成功！").show();
                                $('<a class="btn btn-info" href="/">访问首页</a> <a class="btn" style="    background-color: #000000d1;border-color: #000000;color: #fff!important;" href="/admin">访问后台</a>').insertAfter($button);
                                $button.remove();
                            } else {
                                $('#error').show().text(ret);
                                $button.prop('disabled', false).text('点击安装');
                                $("html,body").animate({
                                    scrollTop: 0
                                }, 500);
                            }
                        })
                        .fail(function (data) {
                            $('#error').show().text('发生错误:\n\n' + data.responseText);
                            $button.prop('disabled', false).text('点击安装');
                            $("html,body").animate({
                                scrollTop: 0
                            }, 500);
                        });

                    return false;
                });
            });
        </script>
</html>