<?php
/*
* 笒鬼鬼api
* cenguigui@qq.com
* 获取所有接口信息
*/

// 获取数据库信息
include("./includes/common.php");
$type = isset($_GET['type']) ? daddslashes($_GET['type']) : null;
/* 允许跨域请求，接口建议允许 */
header('Access-Control-Allow-Origin:*');
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
/* 允许请求方式，设置GET和POST */
// header('Access-Control-Allow-Methods:Get,Post');
/* 关闭PHP错误提示 */
ini_set('display_errors', 'off');

// if(!checkRefererHost())exit('{"code":403,"msg":"禁止访问"}');

switch ($type) {
        // 获取所有接口信息
    case 'Info':
        if (isset($_REQUEST['keywords']) && !empty($_REQUEST['keywords'])) {
            $sql = "SELECT * FROM api_apilist WHERE name  LIKE '%" . $_REQUEST['keywords'] . "%' ORDER BY views ASC";
            $row = $DB->getAll($sql);
            $count = $DB->getCount($sql);
            if (empty($row)) {
                $result = array("code" => -1, "msg" => "系统共查到 $count 条数据");
                exit(json_encode($result));
            } else {
                $result = array("code" => 0, "count" => $count, "data" => $row);

                // 构造包含每个接口信息的结果数组
                $num = 1;
                $results = array();
                // 获取此源码存放调用的域名
                // $mulu = __DIR__;
                // // 去掉开头的 /www/wwwroot/
                // $mulu = preg_replace('/^\/www\/wwwroot\//', '', $mulu);
                $mulu = getCallingDomain(false);
                foreach ($result["data"] as $item) {
                    $name = $item["name"];
                    $alias = $item["alias"];
                    $money = $item["money"];
                    $icon = $item["faimg"];
                    $url = $mulu . "api/" . urlencode($alias) . ".html";
                    // 构造结果数组
                    $result = array(
                        "name" => $name,
                        "action" => $alias,
                        "money" => $money,
                        "url" => $url,
                        "icon" => $icon,
                        "num" => $num++
                    );

                    // 将结果数组添加到 $results 数组中
                    array_push($results, $result);
                }

                $result["data"] = $results;
                exit(json_encode($result["data"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            }
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 9;
        $thispage = ($page - 1) * 9;

        // 降序排行 将 DESC 改为 ASC 则变成升序
        $row = $DB->getAll("select * from `api_apilist` ORDER BY views DESC limit {$thispage},{$limit}");
        $count = $DB->getCount('select * from `api_apilist`');
        if (empty($row)) {
            $result = array("code" => -1, "msg" => "数据错误");
            exit(json_encode($result));
        } else {
            // 初始化返回的结果数组，包含基础信息
            $result = array(
                "code" => 0,
                "msg" => "获取成功",
                "count" => $count,
                "data" => $row
            );

            // 构造包含每个接口信息的结果数组
            $num = 1;
            $results = array();

            // 获取此源码存放调用的域名
            // $mulu = __DIR__;
            // // 去掉开头的 /www/wwwroot/
            // $mulu = preg_replace('/^\/www\/wwwroot\//', '', $mulu);
            $mulu = getCallingDomain(false);

            // 遍历结果数据并处理每一项
            foreach ($result["data"] as $item) {
                // 提取必要的字段
                $name = $item["name"];
                $alias = $item["alias"];
                $money = $item["money"];
                $icon = $item["faimg"];
                $url = $mulu . "api/" . urlencode($alias) . ".html";  // 构造链接

                // 构造单个结果项数组
                $resultItem = array(
                    "name" => $name,
                    "action" => $alias,
                    "money" => $money,
                    "url" => $url,
                    "icon" => $icon,
                    "num" => $num++  // 递增 num
                );

                // 将单个结果项添加到 $results 数组中
                $results[] = $resultItem;
            }

            // 构造最终的返回结果，保持所有数据结构和格式
            $response = [
                "code" => 200,  // 状态码
                "msg" => "获取成功",  // 消息提示
                "count" => $count,  // 总数，确保 $count 已正确计算
                "data" => $results,  // 最终的数据项列表
                "iconfont" => $system['icon_iconfont'],  // 获取图标字体
            ];

            // 返回格式化的 JSON 数据
            exit(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        break;

    default:
        $result = array("code" => -1, "msg" => "服务器错误");
        exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        break;
}


/**
 * getCallingDomain
 * 获取此源码存放调用的域名
 * 获取当前页面的域名（包括协议）或域名/二级目录。
 *
 * @param bool $includeSecondLevel 是否包含二级目录，默认为 false，即只返回域名。
 * @return string 当前页面的域名（包括协议）或域名/二级目录。
 * 获取二级目录调用方法不获取二级目录吧true去掉即可:
 * 调用函数文件存放路径 返回域名/二级目录/
 * $myurl = \YyJx::getCallingDomain(true);
 */
function getCallingDomain($includeSecondLevel = false)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    // 获取不带查询字符串的URL路径
    $current_url = strtok($_SERVER["REQUEST_URI"], '?');
    $current_path = parse_url($current_url, PHP_URL_PATH);
    // 如果不需要包含二级目录，直接返回域名，并确保末尾有斜杠
    if (!$includeSecondLevel) {
        return rtrim($protocol . $host . '/', '/') . '/';
    }
    // 获取 URL 路径的第一个目录作为二级目录
    $directories = explode('/', trim($current_path, '/'));
    $second_level_directory = isset($directories[0]) ? '/' . $directories[0] : '';
    // 构建完整的 URL，并确保末尾有斜杠
    $myurl = $protocol . $host . rtrim($second_level_directory, '/') . '/';
    return $myurl;
}
