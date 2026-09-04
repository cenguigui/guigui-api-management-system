<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
header('Access-Control-Allow-Methods:Get,Post');
if(!checkRefererHost())exit('{"code":403,"msg":"禁止访问"}');
switch ($act) {
   case 'add_res':
	//资源添加
	   $isAdmin = isAdmin($_COOKIE["admin_token"]);
    if (empty($isAdmin)) {
		$json = ['code' => '-1', 'msg' => '未登录ERROR！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$title = daddslashes($_POST['title']);
	$title_site = daddslashes($_POST['title_site']);
	$content = daddslashes($_POST['content']);
	$Maintain = daddslashes($_POST['Maintain']);
	$img = daddslashes($_POST['img']);
	$down = daddslashes($_POST['down']);
	$status = intval($_POST['status']);
	$top = intval($_POST['top']);
	$Yes = intval($_POST['Yes']);
	if (!$title) {
		$json = ['code' => '-1', 'msg' => '稿件名称不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$titles = $DB->getRow("SELECT * FROM api_down WHERE title='{$title}' limit 1");
	if ($titles['title']) {
		$json = ['code' => '-1', 'msg' => '已存在该资源！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	} else if (!$title_site) {
		$json = ['code' => '-1', 'msg' => '稿件提示不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	} else if (!$img) {
		$json = ['code' => '-1', 'msg' => '稿件图片上传不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	} else if (!$down) {
		$json = ['code' => '-1', 'msg' => '下载链接不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$sql = "insert into `api_down` (`title`,`title_site`,`content`,`Maintain`,`img`,`down`,`status`,`top`,`Yes`,`date`) values ('" . $title . "','" . $title_site . "','" . $content . "','" . $Maintain . "','" . $img . "','" . $down . "','" . $status . "','" . $top . "','" . $Yes . "','" . $date . "')";
	if ($DB->exec($sql)) {
		$json = ['code' => '1', 'msg' => '添加资源成功'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	} else {
		$json = ['code' => '-1', 'msg' => '添加失败！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	break;
	case 'edit_res':
	//资源修改
	$id = intval($_POST['id']);
	$title = daddslashes($_POST['title']);
	$title_site = daddslashes($_POST['title_site']);
	$content = daddslashes($_POST['content']);
	$img = daddslashes($_POST['img']);
	$down = daddslashes($_POST['down']);
	$Maintain = daddslashes($_POST['Maintain']);
	$status = daddslashes($_POST['status']);
	$top = daddslashes($_POST['top']);
	$Yes = daddslashes($_POST['Yes']);
	$row = $DB->getRow("SELECT * FROM api_down WHERE id='{$id}' limit 1");
	if (!$row) {
		$json = ['code' => '-1', 'msg' => 'ID不存在,请检查'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	if (!$title) {
		$json = ['code' => '-1', 'msg' => '稿件名称不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	if (!$title_site) {
		$json = ['code' => '-1', 'msg' => '稿件提示不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	if (!$img) {
		$json = ['code' => '-1', 'msg' => '稿件图片上传不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	if (!$down) {
		$json = ['code' => '-1', 'msg' => '下载链接不能为空！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$sql = "update `api_down` set `title` ='{$title}',`title_site` ='{$title_site}',`content` ='{$content}',`img` ='{$img}',`down` ='{$down}',`Maintain` ='{$Maintain}',`status` ='{$status}',`top` ='{$top}',`Yes` ='{$Yes}' where `id`='{$id}'";
	if ($DB->query($sql)) {
		$json = ['code' => '1', 'msg' => '修改资源成功'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	} else {
		$json = ['code' => '-1', 'msg' => '修改失败！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	break;
	//文章列表
    case 'res_list':
	if (isset($_GET['kw'])) {
		$kw = daddslashes($_GET['kw']);
		if ($_GET['type'] == 1) {
			$sql = $_GET['method'] == 1 ? " `id` LIKE '%{$kw}%'" : " `id`='{$kw}'";
		} elseif ($_GET['type'] == 2) {
			$sql = $_GET['method'] == 1 ? " `title` LIKE '%{$kw}%'" : " `title`='{$kw}'";
		} else {
			if (is_numeric($kw)) {
				$column = 'id';
			} else {
				$column = 'title';
			}
			$sql = $_GET['method'] == 1 ? " `{$column}` LIKE '%{$kw}%'" : " `{$column}`='{$kw}'";
		}
	} else {
		$sql = " 1";
	}
	$rs = $DB->query("SELECT * FROM api_down WHERE {$sql}");
	$data = array();
	while ($res = $rs->fetch()) {
		$data[] = $res;
	}
	$count = count($data);
	$limit = isset($_GET['limit']) ? daddslashes($_GET['limit']) : 10;
	$page = isset($_GET['page']) ? daddslashes($_GET['page']) : 1;
	$Total = ($page - 1) * $limit;
	$rs = $DB->query("SELECT * FROM api_down WHERE {$sql} order by id desc limit {$Total}, {$limit}");
	while ($res = $rs->fetch()) {
		if ($res['status'] == 0) {
			$status = "<span style='color:#FF0000;'>文章下架</span>";
		} elseif ($res['status'] == 1) {
			$status = "<span style='color:#008000;'>文章正常</span>";
		}
		if ($res['top'] == 1) {
			$top = "<img src='$siteurl/down/assets/icon/hot.gif'>";
		} elseif ($res['top'] == 2) {
			$top = "<img src='$siteurl/down/assets/icon/zhiding.gif'>";
		}
		$table[] = ['id' => $res['id'], 'title' => $res['title'], 'img' => $res['img'], 'status' => $status, 'top' => $top, 'date' => $res['date']];
	}
	exit(json_encode(['code' => 0, 'msg' => '数据获取成功！', 'count' => $count, 'data' => $table], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	break;
	case 'del_res':
	//删除资源
	//	var_dump($_POST);
	$isAdmin = isAdmin($_COOKIE["admin_token"]);
    if (empty($isAdmin)) {
		$json = ['code' => '-1', 'msg' => '未登录ERROR！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$id = daddslashes(intval($_POST['id']));
	$chk_value = daddslashes($_POST['data']);
	
	if (empty($id) && empty($chk_value)) {
		exit('{"code":-1,"msg":"请选择要删除的数据！"}');
	}
	if (!empty($id) && empty($chk_value)) {
		$row = $DB->getRow("SELECT * FROM api_down WHERE id='{$id}' limit 1");
		if (!$row) {
			exit('{"code":-1,"msg":"不存在此数据！"}');
		} else {
			$sql = "delete from api_down WHERE id='{$id}'";
			if ($DB->exec($sql)) {
				exit('{"code":1,"msg":"删除成功"}');
			} else {
				exit('{"code":-1,"msg":"删除失败"}');
			}
		}
	} 
elseif (!empty($chk_value) && empty($id)) {
		$error = 0;
		$success = 0;
		$i = 0;
		foreach ($chk_value as $res) {
			$row = $DB->getRow("SELECT * FROM api_down WHERE id='{$res}' limit 1");
			$i++;
			if (!$row) {
				$error++;
			} else {
				if ($DB->exec("DELETE FROM api_down WHERE id='{$res}'")) {
					$success++;
				} else {
					$error++;
				}
			}
		}
		exit('{"code":1,"msg":"总共删除' . $i . '条<br>成功：' . $success . '条<br>失败：' . $error . '条"}');
	}

	break;
    
    //上传资源图片
    case 'upimg':
        $isAdmin = isAdmin($_COOKIE["admin_token"]);
    if (empty($isAdmin)) {
		$json = ['code' => '-1', 'msg' => '未登录ERROR！'];
		exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	if ($_POST['do'] == 'upload') {
		if (isset($_SESSION['upimg_upload']) && $_SESSION['upimg_upload'] > time() - $upimg_upload) {
			exit('{"code":-1,"msg":"请勿频繁操作<code>' . $upimg_upload / 60 . '分钟</code>后在进行操作！"}');
		}
		if ($_FILES["file"]["size"] / 2048 > 1000) {
			$json['code'] = '-1';
			$json['msg'] = '上传图片大小超过800kb限制、请使用外联将链接放入图片输入框！';
			exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		}
		$filename = md5_file($_FILES['file']['tmp_name']) . '.png';
		$fileurl = '' . $_SERVER['HTTP_ROOT'] . '/down/upload/' . $filename;
		if (copy($_FILES['file']['tmp_name'], ROOT . '' . $_SERVER['HTTP_ROOT'] . '/down/upload/' . $filename)) {
			$_SESSION['upimg_upload'] = time();
			exit('{"code":0,"msg":"succ","url":"' . $fileurl . '","location":"' . $fileurl . '"}');
		} else {
			exit('{"code":-1,"msg":"上传失败，请确保有本地写入权限"}');
		}
	    
	} 
	break;
  
    default:
        $result = array("code" => -1, "msg" => "服务器错误");
        exit(json_encode($result));
    break;
}