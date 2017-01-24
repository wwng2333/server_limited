<?php
function curl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$r = curl_exec($ch);
	$curl_errno = curl_errno($ch);
	curl_close($ch);
	if($curl_errno > 0) {
		return false;
	} else {
		return $r;
	}
}

$url = 'https://console.online.net/en/order/server_limited';
$html = explode("\n", curl($url));
for($i=0;$i<count($html);$i++) {
	$linenow = $html[$i];
	if(strstr($linenow, '<span class="highlight">')) {
		$lineneed = $linenow;
		break;
	}
}
$offer = explode('<table class="server-availability col-striped"><colgroup><col class="coloffer" /><col class="colcpu" /><col class="colram" /><col class="colhdd" /><col class="colconnect" /><col class="colavailability" /><col class="colprice" /><col class="colaction" /></colgroup><thead>', $lineneed);
for($i=0;$i<count($offer);$i++) {
	$offer[$i] = explode('</td></tr><tr ><td>', $offer[$i]);
	for($x=0;$x<count($offer[$i]);$x++) {
		if(strstr($offer[$i][$x], '</thead><tbody>')) {
			$temp = explode('</thead><tbody><tr ><td>', $offer[$i][$x]);
			$offer[$i][$x] = $temp[1];
		} elseif(strstr($offer[$i][$x], '</td><td></td></tr></tbody></table>')) {
			$temp = explode('</td><td></td></tr></tbody></table>', $offer[$i][$x]);
			$offer[$i][$x] = $temp[0];
		}
	}
}

$result = array();
for($i=0;$i<count($offer);$i++) {
	for($x=0;$x<count($offer[$i]);$x++) {
		$offer[$i][$x] = explode('</td><td>', $offer[$i][$x]);
		for($t=0;$t<count($offer[$i][$x]);$t++) {
			$offer[$i][$x][$t] = trim($offer[$i][$x][$t]);
			if($offer[$i][$x][$t] == '') unset($offer[$i][$x][$t]);
		}
	}
	if($i>0) $result = array_merge($result, $offer[$i]);
}

#echo json_encode($result[0])."\n";

$array = $result[14];
$detail = implode("\n", $array);
#var_dump($array[$count]);
if(strstr(current($array),'server_limited')) {
	#echo true;
	$url = 'http://sc.ftqq.com/YOUR_API_KEY.send?text='.urlencode($array[0].'上货了').'&desp='.urlencode($detail);
	curl($url);
}