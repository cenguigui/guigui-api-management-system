-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2026-09-04 13:42:16
-- 服务器版本： 5.7.44-log
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cenguigui_api`
--

-- --------------------------------------------------------

--
-- 表的结构 `api_admin`
--

CREATE TABLE `api_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员列表';

--
-- 转存表中的数据 `api_admin`
--

INSERT INTO `api_admin` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- 表的结构 `api_apilist`
--

CREATE TABLE `api_apilist` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '接口名称',
  `desc` varchar(64) NOT NULL COMMENT '接口描述',
  `alias` varchar(32) DEFAULT NULL COMMENT '别名',
  `faimg` varchar(32) DEFAULT NULL COMMENT 'fa图标',
  `apiurl` varchar(255) DEFAULT NULL COMMENT '接口地址',
  `apiformat` varchar(32) DEFAULT '0' COMMENT '返回格式',
  `money` float(10,2) DEFAULT NULL COMMENT '价格',
  `request` varchar(32) DEFAULT '0' COMMENT '请求方式',
  `apirequest` varchar(255) DEFAULT NULL COMMENT '请求示例',
  `explain` text COMMENT '参数说明',
  `return` text COMMENT '返回数据',
  `example` text COMMENT '调用实例',
  `examples` text COMMENT '示例代码',
  `views` varchar(11) DEFAULT '1' COMMENT '调用次数',
  `remarks` text COMMENT '备注',
  `times` datetime DEFAULT NULL COMMENT '更新时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0隐藏/1正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='接口列表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `api_apilist`
--

INSERT INTO `api_apilist` (`id`, `name`, `desc`, `alias`, `faimg`, `apiurl`, `apiformat`, `money`, `request`, `apirequest`, `explain`, `return`, `example`, `examples`, `views`, `remarks`, `times`, `status`) VALUES
(124, '随机一言', '随机输出一言,一言用于随机评论等', 'yiyan', 'icon-wenben', 'https://api.cenguigui.cn/api/yiyan/', 'JSON', NULL, 'GET', 'https://api.cenguigui.cn/api/yiyan/?code=js', '<tr><td>无</td><td>无</td><td>是</td><td>无</td></tr>', 'function yiyan(){document.write(\"强大使人快乐。\");}', '<script type=\"text/javascript\" src=\"https://api.cenguigui.cn/api/yiyan/?code=js\"></script>\n<script>yiyan()</script>', '<script type=\"text/javascript\" src=\"https://api.cenguigui.cn/api/yiyan/?code=js\"></script>\n<script>yiyan()</script>', '23', NULL, '2026-09-04 13:40:44', 1),
(125, '二维码生成', '将网址或文字直接转换成二维码图片', 'qrcode', 'icon-erweima', 'https://api.cenguigui.cn/api/qrcode/', 'JSON', NULL, 'GET', 'https://api.cenguigui.cn/api/qrcode?img=1&dt=L&text=https://api.cenguigui.cn', '<tr><td>图片边距外框</td><td>img</td><td>是</td><td>默认1 可选1-10</td></tr>\n<tr><td>二维码复杂调整</td><td>dt</td><td>是</td><td>默认L 可选L,M,Q,H</td></tr>\n<tr><td>要生成的文字或网址</td><td>text</td><td>是</td><td>文字或网址</td></tr>', '直接返回二维码图片', '1. css调用\nbackground-image: url(\'https://api.cenguigui.cn/api/qrcode/?img=1&dt=L&text=填写需要调用的网址或文字\');height: 330px;\n2.img调用\n< img src=\"https://api.cenguigui.cn/api/qrcode/?img=1&dt=L&text=填写需要调用的网址或文字\"  style=\"height: 330px;\">\n注意：css 可自行调节\nheight: 330px;\n如改成 ：height: 250px;', '<img src=\"https://api.cenguigui.cn/api/qrcode/?img=1&dt=L&text=https://api.cenguigui.cn\" style=\"height: 270px;\" >', '26', NULL, '2026-09-04 13:40:50', 1),
(126, '每日早报快讯-正式新闻', '早间读早报60秒资讯,读懂全世界', 'zaobao', 'icon-svg', 'https://api.cenguigui.cn/api/zaobao/', 'JSON', NULL, 'GET', 'https://api.cenguigui.cn/api/zaobao/', NULL, '返回图片', NULL, NULL, '2', NULL, '2026-09-04 13:40:32', 1);

-- --------------------------------------------------------

--
-- 表的结构 `api_down`
--

CREATE TABLE `api_down` (
  `id` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `content` text,
  `img` varchar(150) DEFAULT NULL,
  `down` varchar(150) DEFAULT NULL,
  `Maintain` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `title_site` varchar(100) NOT NULL,
  `top` varchar(20) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `Yes` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `api_stats_daily`
--

CREATE TABLE `api_stats_daily` (
  `id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL COMMENT 'API ID',
  `date` date NOT NULL COMMENT '统计日期',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '调用次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='API每日调用统计';

--
-- api_stats_daily 初始保持为空，部署后由系统自动写入调用统计。
--

-- --------------------------------------------------------

--
-- 表的结构 `api_system`
--

CREATE TABLE `api_system` (
  `name` varchar(32) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

--
-- 转存表中的数据 `api_system`
--

INSERT INTO `api_system` (`name`, `content`) VALUES
('bg_img', 'https://cdn-hw-static2.shanhutech.cn/bizhi/staticwp/202404/43de4a8f12893846f8e1b94061e564cf--1328428725.jpg'),
('card_bg_img', 'https://mms0.baidu.com/it/u=1094456095,3224255275&fm=253&app=138&f=JPEG?w=500&h=500'),
('card_one', '你好陌生人'),
('card_title', '笒鬼鬼api'),
('card_two', '欢迎来到笒鬼鬼api'),
('description', '笒鬼鬼api接口站(api.cenguigui.cn)是一个公益API数据接口调用平台,提供各种API接口站点。'),
('gonggao', '欢迎使用笒鬼鬼api<br>\n公益API数据接口调用服务平台<br><br>\n☛点我去往<a href=\"./apilist.html\">接口源码商城</a><br><br>\n点我去往<a href=\"./down/\">笒鬼鬼资源商城</a><br>'),
('gonggao_whole', '<div\n        style=\"padding: 30px; line-height: 24px; background-color: #393D49; color: #fff; font-weight: 300; font-size: 16px;\">\n        <p style=\"text-indent: 2em;\"></p>\n        <p style=\"font-size: 20px; text-align: center; color: #16baaa;\">笒鬼鬼API通知</p>\n        <span style=\"font-size: 20px; text-indent: 2em;\">\n            <p style=\"text-indent: 2em;\"></p>\n            <p style=\"text-indent: 2em;\">注意：请勿直接调用本站的接口，本站为演示站，仅供测试使用！！！</p>\n        </span>\n        <p style=\"text-indent: 2em;\"></p>\n        <p style=\"text-indent: 2em;\">1、笒鬼鬼API是笒鬼鬼博客自用API接口调用服务，为降低服务器资源消耗，接口请求QPS为 <span\n                style=\"color:#1e9fff;\">10</span> 秒 <span style=\"color:#1e9fff;\">5</span> 次。</p>\n        <p style=\"text-indent: 2em;\">2、使用者务必遵循法律法规，切勿滥用，使用爬虫等，否则封禁IP/key。</p>\n        <p style=\"text-indent: 2em;\">3、有任何问题联系管理员<span style=\"color:#1e9fff;\">笒鬼鬼</span>处理。</p>\n        <p style=\"text-indent: 2em;\">4、本站接口全部来源于网络公开数据,若是侵犯了您的权益请联系我关闭！</p>\n        <!-- 感谢服务器赞助商：糖果云 -->\n        <p style=\"text-indent: 2em;\">5、本站由：\n            <a href=\"https://tgidc.cc/aff/EGQVSOWZ\" target=\"_blank\" style=\"color:#ff1e1e;\">糖果云</a> 强强赞助\n        </p>\n        <!-- 感谢服务器赞助商：糖果云 -->\n    </div>'),
('ico', 'https://q1.qlogo.cn/g?b=qq&nk=2963246343&s=640'),
('icon_iconfont', 'https://at.alicdn.com/t/c/font_4912122_7eo9hafo252.js'),
('icp', '黔ICP备2022007984号-1'),
('keywords', '笒鬼鬼api,接口大全,免费接口,免费api,免费API'),
('logo', 'logo.png'),
('qqjump', '0'),
('qqlink', 'https://qm.qq.com/q/FuAqXM7gcK'),
('qqmail', 'cenguigui@qq.com'),
('qqskm', 'https://p6-fanqieaudiopic.byteimg.com/img/novel-pic/0891cec68ebcabc4aca93188cf14d914~tplv-tt-cs0:0:0.png'),
('qunurl', 'https://qm.qq.com/q/atfEiH0qRy'),
('run_time', '2022-08-15'),
('sysname', '笒鬼鬼api'),
('theme', 'cenguigui'),
('title', '笒鬼鬼api'),
('wxskm', '/assets/images/sponsor-wechat.png'),
('zfbskm', '/assets/images/sponsor-alipay.png'),
('zzqq', '2963246343');

-- --------------------------------------------------------

--
-- 表的结构 `api_youlian`
--

CREATE TABLE `api_youlian` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `content` text,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `api_youlian`
--

INSERT INTO `api_youlian` (`id`, `title`, `icon`, `domain`, `content`, `date`) VALUES
(11, '笒鬼鬼', 'https://q1.qlogo.cn/g?b=qq&nk=2963246343&s=640', 'https://blog.cenguigui.cn', '人间忽晚，山河已秋！', '2023-01-24 18:40:41'),
(2, '小枫公益API', 'https://q3.qlogo.cn/g?b=qq&nk=1809185784&s=640', 'https://api.xfabe.com/', '小枫公益API是一款为开发者提供免费、稳定、快速的Web Api服务的平台!', '2024-06-27 21:04:43'),
(22, '星之阁API', 'https://api.xingzhige.com/Template/index/Neumorphism/assets/images/logo.png', 'https://api.xingzhige.com/', '不要和你的努力说对不起，那样会多对不起你的努力啊！', '2024-07-01 15:32:06'),
(28, '燃雨API', 'https://ryapi.sbs/favicon.png', 'https://ryapi.sbs/', '快速、稳定、长期api。', '2025-08-07 20:43:01'),
(30, '云烟API', 'http://api.dovis.work/image/Image_1714501532232.jpg', 'http://api.dovis.work/', '快速、稳定、免费API平台', '2025-08-31 07:17:02'),
(31, '我爱API', 'https://q2.qlogo.cn/headimg_dl?dst_uin=1694750&spec=5', 'https://www.52api.cn/', '我爱api-免费、稳定、易用的webapi接口调用', '2025-09-10 18:52:56');

--
-- 转储表的索引
--

--
-- 表的索引 `api_admin`
--
ALTER TABLE `api_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `api_apilist`
--
ALTER TABLE `api_apilist`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `api_down`
--
ALTER TABLE `api_down`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `api_stats_daily`
--
ALTER TABLE `api_stats_daily`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_date` (`api_id`,`date`),
  ADD KEY `date` (`date`);

--
-- 表的索引 `api_system`
--
ALTER TABLE `api_system`
  ADD PRIMARY KEY (`name`);

--
-- 表的索引 `api_youlian`
--
ALTER TABLE `api_youlian`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `api_admin`
--
ALTER TABLE `api_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `api_apilist`
--
ALTER TABLE `api_apilist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- 使用表AUTO_INCREMENT `api_down`
--
ALTER TABLE `api_down`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `api_stats_daily`
--
ALTER TABLE `api_stats_daily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `api_youlian`
--
ALTER TABLE `api_youlian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
