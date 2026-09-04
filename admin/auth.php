<?php
include("../includes/common.php");
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
if(!checkRefererHost())exit('{"code":403,"msg":"禁止访问"}');
@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    
    //登录
    case 'login':
        $username = trim(strip_tags(daddslashes($_POST['username'])));
        $password = strip_tags(daddslashes($_POST['password']));
        if (!$password || !$username) {
            $result = array("code" => -1, "msg" => "请填写账号密码后再登陆");
            exit(json_encode($result));
        }
        
        $adminrow = $DB->getRow("SELECT id,username,password,status FROM `api_admin` WHERE `username`='{$username}' limit 1");
        if(empty($adminrow)){
            $result = array("code" => -1, "msg" => "用户不存在");
            exit(json_encode($result));
        }
        
        if($adminrow['status'] != 1){
            $result = array("code" => -1, "msg" => "当前账号已被封禁！");
            exit(json_encode($result));
        }
        
        $password = md5($password);
        if($password == $adminrow['password']) {
            $DB->update("admin", ["ip"=>$ip, "lasttime"=>$date], ["uid" => $adminrow['uid']]);
            
            $expiretime = time() + 604800;
            $session = md5($adminrow['username'] . $password . $password_hash);
            $token = authcode("{$adminrow['username']}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
            setcookie("admin_token", $token, $expiretime);
            $result = array("code" => 1, "msg" => "尊敬的[{$adminrow['username']}] ,欢迎回来！");
            exit(json_encode($result));
        } else {
            $result = array("code" => -1, "msg" => "密码不正确");
            exit(json_encode($result));
        }

    break;
    
    //退出登录
    case 'logout':
        setcookie("admin_token", "1", time());
        $result = array("code" => 1, "msg" => "退出成功");
        exit(json_encode($result));
    break;
    
    default:
        $result = array("code" => -1, "msg" => "服务器异常");
        exit(json_encode($result));
    break;

}

?>