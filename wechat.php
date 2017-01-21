<?php
$api = 'http://localhost/online.php';
$array = json_decode(file_get_contents($api), true);
$count = count($array) - 1;
if(strstr($array[$count],'form method') {
	$url = 'http://sc.ftqq.com/YOUR_API_KEY.send?text='.urlencode($array[0].'ио╩Уак');
	file_get_contents($url);
}