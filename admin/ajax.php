<?php
include("../includes/common.php");
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
//header('Access-Control-Allow-Methods:Get,Post');
/* 关闭PHP错误提示 */
//ini_set('display_errors','off');

if(!checkRefererHost())exit('{"code":403,"msg":"禁止访问"}');

switch ($act) {
    
    //更改系统设置
    case 'systemForm':
        foreach ($_POST as $k => $value) {
            $value = daddslashes($value);
            $DB->exec("insert into `api_system` set `name`='{$k}', `content`='{$value}' on duplicate key update `content`='{$value}'");
        }
        $result = array("code" => 200, "msg" => "修改成功");
        exit(json_encode($result));
    break;
    
    //logo图片上传
    case 'uploadImages':
        $file = $_FILES['upfile'];//得到传输的数据
		if(!$file){
			$result = array("code" => -1, "msg" => "上传失败，空文件！");
			exit(json_encode($result));
		}
		$name = $file['name'];//得到文件名称
		$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
		$allow_type = array('jpg','jpeg','gif','png','ico'); //定义允许上传的类型
		if(!in_array($type, $allow_type)){
			$result = array("code" => -1, "msg" => "上传失败，不允许上传此文件！");
			exit(json_encode($result));
		}
		//原文件名
        $file_name = $file['name'];
		//获得文件扩展名
        $temp_arr = explode(".", $file_name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);
		
		$savename = date('YmdHis',time()).mt_rand(0,9999).'.'.$file_ext;
		$imgdirs = "../images/";//文件路径
		mkdirs($imgdirs);
		$savepath = '/images/'.$savename;//文件路径全称
		$Uploaddata = '//'.$_SERVER['HTTP_HOST'].$savepath;
		
		$Uploadfile = '..'.$savepath;
		$Upload = move_uploaded_file($file["tmp_name"],$Uploadfile);//开始移动文件到相应的文件夹
		if($Upload){
		    $result = array("code"=>200, "msg"=>"上传成功！", "data"=>$Uploaddata, "path"=>$savepath);
		}else{
			$result = array("code" => -1, "msg" => "上传失败！");
		}
		exit(json_encode($result));
    break;
    
    //修改密码
    case 'passwordForm':
        $isAdmin = isAdmin($_COOKIE["admin_token"]);
        if (empty($isAdmin)) {
            exit('{"code":-1,"msg":"登录信息失效101"}');
        }
        $oldpassword = trim(strip_tags(daddslashes($_POST['oldpassword'])));
        $newpassword = trim(strip_tags(daddslashes($_POST['newpassword'])));
        $newpasswordr = trim(strip_tags(daddslashes($_POST['newpasswordr'])));
        if(empty($oldpassword) || empty($newpassword) || empty($newpasswordr)){
            $result = array("code" => -1, "msg" => "必填项不可为空");
            exit(json_encode($result));
        }
        
        if(md5($oldpassword) != $isAdmin['password']){
            $result = array("code" => -1, "msg" => "原密码不正确");
            exit(json_encode($result));
        }
        if($newpassword != $newpasswordr ){
            $result = array("code" => -1, "msg" => "两次密码不一致");
            exit(json_encode($result));
        }
        
        $return = $DB->update("admin", ["password"=>md5($newpassword)], ["id" => $isAdmin['id']]);
        if($return){
            $result = array("code" => 200, "msg" => "操作成功");
            exit(json_encode($result));
        }else{
            $result = array("code" => -1, "msg" => "操作失败");
            exit(json_encode($result));
        }
    break;
    
    //获取接口信息
    case 'ApiInfo':
        $id = trim(strip_tags(daddslashes($_POST['id'])));
        if(empty($id)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }
        
        $row = $DB->getRow("select * from `api_apilist` where `id`='{$id}' limit 1");
        if(empty($row)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }else{
            $result = array("code" => 200, "msg" => "【{$row['name']}】获取成功", "data"=>$row);
            exit(json_encode($result));
        }
        
    break;

    //获取所有接口信息
    case 'ApiallInfo':
        
        if (isset($_REQUEST['keywords']) && !empty($_REQUEST['keywords'])) {
            $sql = "SELECT * FROM api_apilist WHERE name  LIKE '%" . $_REQUEST['keywords'] . "%' ORDER BY views ASC"; //降序排行 将DESC 改为 ASC 则变成升序
            $row = $DB->getAll($sql);
            $count = $DB->getCount($sql);
        if(empty($row)){
            $result = array("code" => -1, "msg" => "系统共查到 $count 条数据");
            exit(json_encode($result));
        }else{
            $result = array("code" => 0,"count"=>$count, "data"=>$row);
            
            exit(json_encode($result));
        }
            
        } 
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 9;
        $thispage = ($page - 1)*9;
        $row = $DB->getAll("select * from `api_apilist` ORDER BY views ASC limit {$thispage},{$limit}");
        $count = $DB->getCount('select * from `api_apilist`');
        if(empty($row)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }else{
            $result = array("code" => 0, "msg" => "获取成功","count"=>$count, "data"=>$row);
            
            exit(json_encode($result));
        }
        
    break;    
    
    //添加/修改接口
    case 'ApiForm':
        //修改发布编辑去除无用
        $id = trim(strip_tags(daddslashes($_POST['id'])));
        $status = trim(strip_tags(daddslashes($_POST['status'])));
		$name = trim(strip_tags(daddslashes($_POST['name'])));
		$faimg = trim(strip_tags(daddslashes($_POST['faimg'])));
		$desc =  trim(strip_tags(daddslashes($_POST['desc'])));
        $alias = trim(strip_tags(daddslashes($_POST['alias'])));
		$apiurl = trim(strip_tags(daddslashes($_POST['apiurl'])));
		$apiformat = trim(strip_tags(daddslashes($_POST['apiformat'])));
		$request = trim(strip_tags(daddslashes($_POST['request'])));
		$money = trim(strip_tags(daddslashes($_POST['money'])));//价格
		$apirequest = trim(strip_tags(daddslashes($_POST['apirequest'])));
 	    $explain = trim(daddslashes($_POST['explain']));//参数说明
		$return = trim(strip_tags($_POST['return']));//返回数据
		$example = trim($_POST['example']);//调用实例
		$examples = trim($_POST['examples']);//调用演示
		
		
		$views = trim(strip_tags(daddslashes($_POST['views'])));
		$remarks = trim(strip_tags(daddslashes($_POST['remarks'])));
        if(empty($name) || empty($alias) || empty($apiurl) || empty($apiformat) || empty($request))
        {
            $result = array("code" => -1, "msg" => "必填项不可为空");
            exit(json_encode($result));
        }
        $parameter = [
            "id"=>$id,
            "status" =>$status,
            "name"   => $name,
            "desc"   =>$desc,
            "alias"   => $alias,
            "faimg"   => $faimg,
            "apiurl"   => $apiurl,
            "apiformat"   => $apiformat,
            "money"   => $money,
            "request"   => $request,
            "apirequest"   => $apirequest,
            "explain"   => $explain,
            "return"   => $return,
            "example"   => $example,
            "examples"   => $examples,
            "views"   => $views,
            "times"   => $date
        ];
        if(empty($id)){
            $return = $DB->insert("apilist", $parameter);
        }else{
            $row = $DB->getRow("select id,name from `api_apilist` where `id`='{$id}' limit 1");
            if(empty($row)){
                $result = array("code" => -1, "msg" => "数据错误");
                exit(json_encode($result));
            }
            $return = $DB->update("apilist", $parameter, ["id" => $id]);
        }
        if($return){
            $result = array("code" => 200, "msg" => "【{$name}】操作成功");
            exit(json_encode($result));
        }else{
            $result = array("code" => -1, "msg" => "操作失败");
            exit(json_encode($result));
        }
        
    break;
    
    //修改接口状态
    case 'ApiStatus':
        
        $id = trim(strip_tags(daddslashes($_POST['id'])));
        $status = trim(strip_tags(daddslashes($_POST['status'])));
        if(empty($id) || !is_numeric($status)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }
        $row = $DB->getRow("select id,name from `api_apilist` where `id`='{$id}' limit 1");
        
        if(empty($row)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }
        $return = $DB->update("apilist", ["status"=>$status], ["id" => $id]);
        if($return){
            $result = array("code" => 200, "msg" => "【{$row['name']}】修改成功");
            exit(json_encode($result));
        }else{
            $result = array("code" => -1, "msg" => "修改失败");
            exit(json_encode($result));
        }
        
    break;
    
    //删除接口
    case 'ApiDel':
        $id = $_POST['id'] ? trim(strip_tags(daddslashes($_POST['id']))) : "";
        if(!empty($_POST['data'])){
            foreach($_POST['data'] as $v){
                $id .= $v['id'].',';
            }
        }
        if(empty($id)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }
        $thisid = rtrim($id,',');
        $row = $DB->getAll("select id,name from `api_apilist` where `id` IN ({$thisid})");
        if(empty($row)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }
        
        $return = $DB->delete("apilist", "`id` IN ({$thisid})");
        if($return){
            $result = array("code" => 200, "msg" => "删除成功");
            exit(json_encode($result));
        }else{
            $result = array("code" => -1, "msg" => "删除失败");
            exit(json_encode($result));
        }
        
    break;
    
    default:
        $result = array("code" => -1, "msg" => "服务器错误");
        exit(json_encode($result));
    break;
}