<?php

    
  $array=file('api.txt');
  $rand=rand(0,8881);
  $string=$array[$rand];
 
header('Content-Type: text/html; charset=UTF-8');
    if ($_GET['code']==='js' || $_GET['code']==='javascript' || $_GET['code']==='JavaScript') {
		 header('Content-type: application/x-javascript; charset=UTF-8');
          echo "function yiyan(){document.write(\"";
          echo trim($string);
          echo "\");}";
		 } elseif ($_GET['code']==='json' || $_GET['code']==='JSON') {
			header('Content-type: application/json; charset=UTF-8');
			$json = json_encode(array(
			'code' => 200 ,
			'msg' => trim($string)
			));
			echo $json;
		} elseif ($_GET['code']==='xml' || $_GET['code']==='XML') {
		$xml = arrayToXml(array(
			'msg' => trim($string)
			));	
			echo $xml;
		 } elseif ($_GET['code']==='array' || $_GET['code']==='Array' || $_GET['code']==='arr' || $_GET['code']==='Arr') {
			$arr = array(
			'code' => 200 ,
			'msg' => trim($string)
			);
		//var_dump($arr);
        }else{
          echo trim($string);
          }
	
?>
