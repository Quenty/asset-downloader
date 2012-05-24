<?php
//
// The PHP curl module supports the received page to be returned in a variable
// if told.
//

function presentToUser($data, $asset) {
	if(preg_match("/^\x89\x50\x4E\x47\x0D\x0A\x1A\x0A/", $data)) {
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
	$result = curl_exec($ch);
	curl_close($ch);

	$matches = array();
	preg_match("@http://.{4}\.roblox\.com/[a-f0-9]{32}@i", $result, $matches);
	
	
	if(count($matches) > 0) {
		if(isset($_GET['showurl'])) {
			echo $matches[0];
		}
		else {
			$ch = curl_init($matches[0]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch);
			curl_close($ch);
			
			presentToUser($data, $asset);
		}
		/*
		echo file_get_contents($matches[0]);*/
	}
	else {
		echo "Got error: \"$result\" when getting $asset" ;
	}
}
?>