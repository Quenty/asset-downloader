<?php
//
// The PHP curl module supports the received page to be returned in a variable
// if told.
//

function presentToUser($data, $asset, $type) {
	if(preg_match("#text/plain#", $type)) {
		header('Content-Type: text/lua');
		header('Content-Disposition: attachment; filename="roblox-script-'.$asset.'.lua"');
		echo $data;
	}
	elseif(preg_match("/^\x89\x50\x4E\x47\x0D\x0A\x1A\x0A/", $data)) {
		header('Content-Type: image/png');
		echo $data;
	}
	elseif(preg_match("/^version 1.00/", $data)) {
		header('Content-Type: model/x-roblox-mesh');
		header('Content-Disposition: attachment; filename="roblox-mesh-'.$asset.'.mesh"');
		echo $data;
	}
	elseif(preg_match("/^ID3/", $data)) {
		header('Content-Type: audio/mp3');
		echo $data;
	}
	else {
		header('Content-Type: text/xml');
		//header('Content-Disposition: attachment; filename="roblox-model-'.$asset.'.rbxm"');
		$data = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
		        '<?xml-stylesheet href="tree.xslt" type="text/xsl" ?>' . "\n" .
		        $data;
		echo $data;
	}
}

if(isset($_GET['asset'])) {

	$asset = @$_GET['asset'];

	$ch = curl_init("http://www.roblox.com/asset/?id=$asset");
	curl_setopt($ch, CURLOPT_USERAGENT, "Roblox/WinInet");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, true);

	$result = curl_exec($ch);
	list($header, $result) = explode("\r\n\r\n", $result, 2);

	if(preg_match('#Location: (.*\.roblox\.com/.*)#', $header, $redirect))
		$redirect = trim($redirect[1]);
	else
		unset($redirect);

	curl_close($ch);

	if($redirect) {
		$ch = curl_init($redirect);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, true);
		$result = curl_exec($ch);
		list($header, $result) = explode("\r\n\r\n", $result, 2);
		curl_close($ch);
	}

	if(preg_match('#Content-Type: (.*)#', $header, $type))
		$type = trim($type[1]);
	else
		$type = false;

	presentToUser($result, $asset, $type);
}
?>