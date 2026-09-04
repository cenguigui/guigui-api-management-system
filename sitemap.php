<?php
include("./includes/common.php");
    header("Content-type: text/xml");
    header('HTTP/1.1 200 OK');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">
  <url>
    <loc><?php
    $url = ((int)$_SERVER['SERVER_PORT'] == 80 ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
    echo $url;?></loc>
    <lastmod><?php echo gmdate('Y-m-d', time()); ?></lastmod>
    <changefreq>always</changefreq>
    <priority>1.0</priority>
  </url>
    <?php
        //最新api
	    $rs=$DB->getAll("SELECT * FROM api_apilist  WHERE `status`='1' AND `status`='1' order by times desc ");
		foreach($rs as $rows){ ?>
          <url>
            <loc><?php echo $url;?><?php echo "/api/{$rows['alias']}.html"; ?></loc>
            <lastmod><?php echo substr($rows['times'],0,10);?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
          </url>
        <?php }
    ?>
    <?php
        //最新文章
	    $rs=$DB->getAll("SELECT * FROM api_down order by date desc");
		foreach($rs as $rows){ ?>
          <url>
            <loc><?php echo $url;?><?php echo "/down-{$rows['id']}.html"; ?></loc>
            <lastmod><?php echo substr($rows['date'],0,10);?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
          </url>
        <?php }
    ?>
</urlset>