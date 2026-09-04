<?php
include("../includes/common.php");
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
//header('Access-Control-Allow-Methods:Get,Post');




switch ($act) {
    
    //接口搜索
    case 'Apiserch':
        if (isset($_REQUEST['keywords']) && !empty($_REQUEST['keywords'])) {
            $sql = "SELECT * FROM api_apilist WHERE name  LIKE '%" . $_REQUEST['keywords'] . "%' ORDER BY views DESC"; //降序排行 将DESC 改为 ASC 则变成升序
        } else {
            //$sql = "SELECT * FROM api_apilist ORDER BY views DESC"; //降序排行 将DESC 改为 ASC 则变成升序
        }
        $row = $DB->getAll($sql);
        $count = $DB->getCount($sql);
        if(empty($row)){
            $result = array("code" => -1, "msg" => "系统共查到 0 条数据");
            exit(json_encode($result));
        }else{
            $result = array("code" => 200, "msg" => "查询成功","count"=>$count, "data"=>$row);
            
            exit(json_encode($result));
        }

    break;
    
    default:
        $result = array("code" => -1, "msg" => "服务器错误");
        exit(json_encode($result));
    break;
}