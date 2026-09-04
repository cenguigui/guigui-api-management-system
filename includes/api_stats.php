<?php

/**
 * api_stats.php
 * 统计函数
 * 
 * 2025的剑网行动：
 * https://news.cctv.com/2025/05/16/ARTIhRapI5juz9IqVs4FVFEI250516.shtml
 * 
 * 调用：
 * 根据API别名更新API调用统计
 * updateApiStatsByAlias('lanzou');
 * 
 * 获取今日总调用次数
 * getTodayTotalCalls();
 * 
 * 获取所有API总调用次数
 * getAllTimeTotalCalls();
 * 
 * 获取API调用排行榜
 * getApiCallRanking();
 * 
 * 根据别名获取API调用统计
 * getApiStatsByAlias('lanzou');
 * 
 **/
 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

define('SYSTEM_ROOT', dirname(__FILE__) . '/');
// 引入数据库文件
// include("./includes/common.php");
include_once(SYSTEM_ROOT . 'common.php');

// $result = updateApiStatsByAlias('lanzou');
// if (!$result) {
//     die('统计更新失败，请检查: ' . $DB->error());
// }

/**
 * 更新API调用统计（基于别名）
 * @param string $alias API的别名
 * @return bool 是否更新成功
 */
function updateApiStatsByAlias($alias)
{
  global $DB;

  // 1. 获取API ID（直接拼接SQL，跳过预处理）
  $api_id = $DB->getColumn("SELECT `id` FROM `api_apilist` WHERE `alias` = '{$alias}'");

  // 2. 检查今天是否已经有记录
  $existingCount = $DB->getColumn("SELECT `count` FROM `api_stats_daily` WHERE `api_id` = {$api_id} AND `date` = CURDATE()");

  if ($existingCount !== false) {
    // 如果已有记录，更新计数
    $DB->exec("UPDATE `api_stats_daily` SET `count` = `count` + 1 WHERE `api_id` = {$api_id} AND `date` = CURDATE()");
  } else {
    // 如果没有记录，插入新记录
    $DB->exec("INSERT INTO `api_stats_daily` (`api_id`, `date`, `count`) VALUES ({$api_id}, CURDATE(), 1)");
  }
  // 3. 更新API的views（视图）
  $DB->exec("UPDATE `api_apilist` SET `views` = `views` + 1 WHERE `id` = {$api_id}");

  // 4. 检测接口是否开启要是没有开启就退出调用
  $api_open = $DB->getColumn("SELECT `status` FROM `api_apilist` WHERE `alias` = ?", [$alias]);
  //   exit($api_open);
  if ($api_open == 0) {
    header('Content-Type: application/json; charset=utf-8');
    exit(json_encode([
      'code' => 404,
      'msg' => '接口已经关闭',
      'data' => [],
      'title' => '关闭原因可能是：单纯关闭不想对外，接口调用过大，不可抗力因素等~',
      'tips' => '接口已经关闭对外使用，需要购买源码联系笒鬼鬼购买QQ/vx:2963246343',
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
  }

  return true;
}


/**
 * 获取今日总调用次数
 * @return int 今日总调用次数
 */
function getTodayTotalCalls()
{
  global $DB;
  $today = date('Y-m-d');
  return (int)$DB->getColumn("SELECT SUM(`count`) FROM `api_stats_daily` WHERE `date` = ?", [$today]);
}
/**
 * 获取所有API总调用次数
 * @return int 总调用次数
 */
function getAllTimeTotalCalls()
{
  global $DB;
  return (int)$DB->getColumn("SELECT SUM(`views`) FROM `api_apilist`");
}

/**
 * 获取API调用排行榜
 * @param int $limit 返回数量
 * @return array API调用排行榜（已按views数值降序排序）
 */
function getApiCallRanking($limit = 10)
{
  global $DB;

  // 获取所有API数据
  $all_apis = $DB->findAll('apilist', ['id', 'name', 'alias', 'views']);

  // 转换为数值并排序
  usort($all_apis, function ($a, $b) {
    $a_views = (int)str_replace(',', '', $a['views']);
    $b_views = (int)str_replace(',', '', $b['views']);
    return $b_views - $a_views; // 降序排序
  });

  // 返回限定数量的结果
  return array_slice($all_apis, 0, $limit);
}

/**
 * 根据别名获取API调用统计
 * @param string $alias API别名
 * @return array|null API统计信息
 */
function getApiStatsByAlias($alias)
{
  global $DB;

  if (empty($alias)) {
    return null;
  }

  // 获取API基本信息
  $api_info = $DB->find('apilist', ['id', 'name', 'alias', 'views'], ['alias' => $alias]);
  if (!$api_info) {
    return null;
  }

  // 获取今日调用次数
  $today = date('Y-m-d');
  $today_calls = $DB->getColumn(
    "SELECT `count` FROM `api_stats_daily` WHERE `api_id` = ? AND `date` = ?",
    [$api_info['id'], $today]  // 修改了参数绑定方式
  );

  // 如果查询结果为false或null，将today_calls设为0
  if ($today_calls === false || $today_calls === null) {
    $today_calls = 0;
  } else {
    $today_calls = (int)$today_calls;
  }

  return [
    'id' => $api_info['id'],
    'name' => $api_info['name'],
    'alias' => $api_info['alias'],
    'total_calls' => $api_info['views'],
    'today_calls' => $today_calls
  ];
}
