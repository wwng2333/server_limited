# server_limited
Online server_limited API &amp;&amp; 有货微信推送

https://console.online.net/en/order/server_limited

```php
$array = $result[0];
```

[0] = XC DEALS 1701.1

[1] = XC DEALS 1701.2

[4] = MD DEALS 1701.1

以此类推。

去 http://sc.ftqq.com/3.version 绑定微信

登入：用GitHub账号登入网站，就能获得一个SCKEY（在「发送消息」页面）
绑定：点击「微信推送」，扫码关注同时即可完成绑定

在 http://sc.ftqq.com/?c=code 获取SCKEY
```php
function sc_send($text, $desp = '', $key = '') {
```
在 `$key = ''` 中添加你的SCKEY

crontab -e添加
```bash
* * * * * php /path/to/online.php
```

API:
```diff
--- online.php  2017-01-22 05:21:19.050717400 +0800
+++ api.php     2017-01-22 05:28:17.700662800 +0800
@@ -34,11 +34,4 @@
        if($i>0) $result = array_merge($result, $offer[$i]);
 }

-#echo json_encode($result[0])."\n";
-
-$array = $result[0];
-$count = count($array) - 1;
-if(strstr($array[$count],'form method') {
-       $url = 'http://sc.ftqq.com/YOUR_API_KEY.send?text='.urlencode($array[0].'上货了');
-       file_get_contents($url);
-}
\ No newline at end of file
+echo json_encode($result)."\n";
\ No newline at end of file
```
