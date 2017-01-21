# server_limited
Online server_limited API &amp;&amp; 有货微信推送

去 http://sc.ftqq.com/3.version 绑定微信

在 http://sc.ftqq.com/?c=code 获取SCKEY
```php
$count = count($array) - 1;
if(strstr($array[$count],'form method') {
	$url = 'http://sc.ftqq.com/YOUR_API_KEY.send?text='.urlencode($array[0].'上货了');
	file_get_contents($url);
}
```
将 `YOUR_API_KEY` 替换成你的SCKEY

crontab -e添加
```bash
* * * * * php /path/to/online.php
```
