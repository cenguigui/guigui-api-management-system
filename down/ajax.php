<?php
include ("../includes/common.php");
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
//header('Access-Control-Allow-Methods:Get,Post');
/* 关闭PHP错误提示 */
if(!checkRefererHost()) {
	$json = ['msg' => '403'];
	exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
function qqname($qq) {
	$urlPre ='http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?g_tk=1518561325&uins=';
	$data = file_get_contents($urlPre . $qq);
	$data = iconv("GB2312", "UTF-8", $data);
	$pattern = '/portraitCallBack\\((.*)\\)/is';
	preg_match($pattern, $data, $result);
	$result = $result[1];
	$result = json_decode($result, true);
	$qqname=$result["$qq"][6];
	if(!$qqname) {
		$name='未知昵称';
	} else {
		$name=$qqname;
	}
	return $name;
}
switch($act) {
	case 'list':
	//文章数据
	$rs = $DB->query("SELECT * FROM api_down WHERE 1");
	$data = array();
	while ($res = $rs->fetch()) {
		$data[] = $res;
	}
	$count = count($data);
	$limit = isset($_GET['limit'])? daddslashes($_GET['limit']):8;
	$page = isset($_GET['page'])? daddslashes($_GET['page']):1;
	$Total = ($page - 1) * $limit;
	$rs=$DB->query("SELECT * FROM api_down WHERE 1 ORDER BY top=2 DESC, id DESC limit $Total,$limit ");
	while($res = $rs->fetch()) {
		if($res['email']=='') {
			$email = ''.$system['zzqq'].'';
			$QQName = qqname($email);
		} else if($res['email']==''.$res['email'].'') {
			$email = ''.$res['email'].'';
			$QQName = qqname($email);
		}
		if($res['status']==0) {
			$status="<span style='color:#FF0000;'>文章下架</span>";
		} else if($res['status']==1) {
			$status="<img src='./assets/icon/ok.gif'> 正常";
		}
		if($res['top']==1) {
			//未置顶
			$icon = "<img src='./assets/icon/hot.gif'>";
			$table[] = ['id'=>$res['id'],'top'=>$icon,'title'=>$res['title'],'img'=>$res['img'],'email'=>$email,'date'=>$res['date'],'QQName'=>$QQName,'title_site'=>$res['title_site'],'active'=>$status];
		} else if($res['top']==2) {
			//置顶文章
			$icon = "<img src='./assets/icon/zhiding.gif'>";
			$table[] = ['id'=>$res['id'],'top'=>$icon,'title'=>$res['title'],'img'=>$res['img'],'email'=>$email,'date'=>$res['date'],'QQName'=>$QQName,'title_site'=>$res['title_site'],'active'=>$status];
		}
	}
	exit(json_encode(['code'=>0,'msg'=>'数据获取成功！','count'=>$count,'data'=>$table], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	break;
	//无请求参数
	default:
	$json = array('code'=>'-1','msg'=>'No Act');
	exit(json_encode($json,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	break;
}
?>