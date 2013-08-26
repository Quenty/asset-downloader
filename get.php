<?php


function presentToUser($handle, $asset, $type) {

	if(preg_match("#text/plain#", $type)) {
		header('Content-Type: text/lua');
		header('Content-Disposition: attachment; filename="roblox-script-'.$asset.'.lua"');
		fpassthru($handle);
		return;
	}
	$header = fread($handle, strlen($pngHeader));
	if($header == $pngHeader) {
		header('Content-Type: image/png');
		rewind($handle);
		fpassthru($handle);
		return;
	}
	rewind($handle);
	if(fread($handle, strlen($meshHeader)) == $meshHeader) {
		rewind($handle);
		fpassthru($handle);
		return;
	}

	rewind($handle);
	if(fread($handle, strlen($mp3Header)) == $mp3Header) {
		header('Content-Type: audio/mp3');
		rewind($handle);
		fpassthru($handle);
		return;
	}
	rewind($handle);

	header('Content-Type: text/xml');
	//header('Content-Disposition: attachment; filename="roblox-model-'.$asset.'.rbxm"');
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
			'<?xml-stylesheet href="tree.xslt" type="text/xsl" ?>' . "\n";
	fpassthru($handle);
}

$firstData = true;
$download = @$_GET['download'] == "true";
function dataRecieved($ch, $str) {
	global $type, $firstData, $download, $asset, $size;
	$pngHeader  = "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A";
	$meshHeader = "version 1.00";
	$mp3Header  = "ID3";


	if($firstData) {
	$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		if(preg_match("#text/plain#", $type)) {
			header('Content-Type: text/lua');
			header('Content-Disposition: attachment; filename="roblox-script-'.$asset.'.lua"');
			#header('Content-Length: '.$size);
		} elseif(strpos($str, $pngHeader, 0) === 0) {
			header('Content-Type: image/png');
			if($download) header('Content-Disposition: attachment; filename="roblox-decal-'.$asset.'.png"');
			#header('Content-Length: '.$size);
		} elseif(strpos($str, $meshHeader, 0) === 0) {
			header('Content-Type: model/x-roblox-mesh');
			header('Content-Disposition: attachment; filename="roblox-mesh-'.$asset.'.mesh"');
			#header('Content-Length: '.$size);
		} elseif(strpos($str, $mp3Header, 0) === 0) {
			header('Content-Type: audio/mp3');
			if($download) header('Content-Disposition: attachment; filename="roblox-audio-'.$asset.'.mp3"');
			#header('Content-Length: '.$size);
		} else {
			header('Content-Type: text/xml');
			if($download) header('Content-Disposition: attachment; filename="roblox-model-'.$asset.'.rbxm"');
			$xsltHeader = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
			            .  '<?xml-stylesheet href="tree.xslt" type="text/xsl" ?>' . "\n";
			#header('Content-Length: '.(strlen($xsltHeader) + $size + 2000));
			echo $xsltHeader;
		}
	}

	echo $str;
	$firstData = false;
	return strlen($str);
}


if(isset($_GET['asset'])) {
	$asset = @$_GET['asset'];

	$url = "http://www.roblox.com/asset/?id=$asset";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Roblox/WinInet");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	$header = curl_exec($ch);

	# handle redirects
	if(preg_match('#Location: (.*\..com/.*)#', $header, $redirect)) {
		curl_setopt($ch, CURLOPT_URL, $redirect[1]);
		$header = curl_exec($ch);
	}
	# parse out content-type
	if(preg_match('#Content-Type: (.*)#', $header, $type))
		$type = trim($type[1]);
	else
		$type = false;

	# get main contents
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'dataRecieved');
	curl_exec($ch);
	curl_close($ch);
}
?>