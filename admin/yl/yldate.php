<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
//header('Access-Control-Allow-Methods:Get,Post');


if(!checkRefererHost())exit('{"code":403,"msg":"禁止访问"}');

switch ($act) {
    
    case "youlianlist":
		$pagesize = empty($_GET["limit"]) ? 10 : intval($_GET["limit"]);
		$page = empty($_GET["page"]) ? 1 : intval($_GET["page"]);
		$offset = $pagesize * ($page - 1);
		$where = empty($_GET["where"]) ? 1 : "`title` LIKE '%" . daddslashes($_GET["where"]) . "%'";
		$count = $DB->getCount("SELECT count(id) FROM api_youlian WHERE {$where}");
		$row = $DB->getAll("SELECT * FROM api_youlian WHERE {$where} order by id desc limit {$offset},{$pagesize}");
        if(empty($row)){
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        }else{
            $result = array("code" => 0, "msg" => "获取成功","count"=>$count, "data"=>$row);
            
            exit(json_encode($result));
        }
        
		break;
	
	case "addyoulian":
		if (isset($_POST["title"]) && isset($_POST["icon"])  && isset($_POST["domain"]) && isset($_POST["content"])) {
			$title = daddslashes($_POST["title"]);
			$icon = daddslashes($_POST["icon"]);
			$domain = daddslashes($_POST["domain"]);
			$content = daddslashes($_POST["content"]);
			if (!$title || !$icon || !$domain || !$content) {
				exit("{\"code\":-1,\"msg\":\"信息不能为空哟！\"}");
			}
			if (!isValidDomain($domain)) {
				exit("{\"code\":-1,\"msg\":\"请输入的域名格式有误！\"}");
			} else {
			if (!preg_match("/^(https?|ftp):\/\/([A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9]\.)+[A-Za-z]{2,}[\/?=\?%\-&_~`@[\]\':+!]*([^<>\"\s])*$/i", $domain)) {
					exit("{\"code\":-1,\"msg\":\"域名没有输入http://或https://\"}");
				}
			}
			$sql = "insert into `api_youlian` (`title`,`icon`,`domain`,`content`,`date`) values ('{$title}','{$icon}','{$domain}','{$content}','{$date}')";
			$DB->query($sql);
			exit("{\"code\":0,\"msg\":\"恭喜你添加友链成功！\"}");
		}
		break;
		
	case "yleditSubmit":
		$id = intval($_POST["id"]);
		$rows = $DB->getRow("select * from api_youlian where id='{$id}' limit 1");
		if (!$rows) {
			exit("{\"code\":-1,\"msg\":\"ID不存在！\"}");
		}
		$title = daddslashes($_POST["title"]);
		$icon = daddslashes($_POST["icon"]);
		$domain = daddslashes($_POST["domain"]);
		$content = daddslashes($_POST["content"]);
		if (!$title || !$icon || !$domain || !$content) {
			exit("{\"code\":-1,\"msg\":\"信息不能为空哟！\"}");
		}
		if (!isValidDomain($domain)) {
			exit("{\"code\":-1,\"msg\":\"请输入的域名格式有误！\"}");
		} else {
			if (!preg_match("/^(http|https|ftp):\\/\\/[A-Za-z0-9]+\\.[A-Za-z0-9]+[\\/=\\?%\\-&_~`@[\\]\\’:+!]*([^<>\\”])*\$/", $domain)) {
				exit("{\"code\":-1,\"msg\":\"域名没有输入http://或https://\"}");
			}
		}
		if ($DB->query("update api_youlian set title='{$title}',icon='{$icon}', domain='{$domain}', content='{$content}' where id='{$id}'")) {
			exit("{\"code\":0,\"msg\":\"恭喜你修改友链成功！\"}");
		} else {
			exit("{\"code\":-1,\"msg\":\"修改友链失败\"}");
		}
		break;
	
	case "delyoulian":
		$id = intval($_POST["id"]);
		$data = daddslashes($_POST["data"]);
		if (!empty($data)) {
			foreach (explode(",", $data) as $res) {
				$rows = $DB->getRow("select * from api_youlian where id='{$res}' limit 1");
				if (!$rows) {
					continue;
				}
				$DB->query("DELETE FROM api_youlian WHERE id='{$res}'");
			}
			exit("{\"code\":0,\"msg\":\"批量删除成功！\"}");
		} else {
			$rows = $DB->getRow("select * from api_youlian where id='{$id}' limit 1");
			if (!$rows) {
				exit("{\"code\":-1,\"msg\":\"不存在此条数据！\"}");
			}
			if ($DB->query("DELETE FROM api_youlian WHERE id='{$id}'")) {
				exit("{\"code\":0,\"msg\":\"删除成功！\"}");
			} else {
				exit("{\"code\":-1,\"msg\":\"删除失败！\"}");
			}
		}
		break;
	

    
    default:
        $result = array("code" => -1, "msg" => "服务器错误");
        exit(json_encode($result));
    break;
}