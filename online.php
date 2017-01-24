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

function sc_send($text, $desp = '', $key = '') {
	$postdata = http_build_query(
    array('text' => $text, 'desp' => $desp));
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
	$context = stream_context_create($opts);
	return $result = file_get_contents('http://sc.ftqq.com/'.$key.'.send', false, $context);
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

$array = $result[0];
$detail = implode("\n\n", $array);
$count = count($array) - 1;
if(strstr($array[$count],'server_limited')) sc_send($array[0], $detail);