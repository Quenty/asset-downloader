<!doctype html>
<html>
	<head>
		<title>Roblox Asset Downloader</title>
		<link href="http://fonts.googleapis.com/css?family=Muli:400,400italic" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/png" href="http://eric-wieser.tk/images/favicon.png" />
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<style>
			body {
				line-height: 20px;
				background: #F0F0F0;
				margin: 0;
				padding: 0;
				font-family: Muli, sans-serif;
			}
			.button {
				border: 1px solid #c0c0c0;
				color: #808080;
				background: #e0e0e0;
				padding: 4px;
				display: inline-block;
				border-radius: 5px;
				text-decoration: none;
				margin:5px;
			}
			p { margin: 0; padding: 5px; }
			
			.button:hover {
				border: 1px solid #808080;
				color: #404040;
			}
			
			footer {
				position: absolute;
				padding: 5px;
				background:  #e0e0e0;
				bottom: 0;
				left: 0;
				right: 0;
				display: block;
			}
			
			header {
				background: #606060 url(http://eric-wieser.tk/images/logo.png) no-repeat 5px 50%;
				color: white;
				overflow: hidden;
				padding: 5px;
				padding-left: 50px;
				display: block;
			}
			
			header h1 {
				font-size: 40px;
				line-height: 40px;
				margin: 0;
				padding: 0;
				float: left;
			}
			header p {
				margin: 0;
				font-style: italic;
				line-height: 40px;
				float: right;
				padding: 0;
			}
			
			.content {
				padding: 5px;
				display: block;
			}
			
			.centered {
				position: absolute;
				left:50%;
				top:50%;
			}
			.centered .center {
				position: relative;
				left: -50%;
				top: -50%;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>Roblox Asset downloader</h1>
			<p>Download Roblox assets straight from your browser</p>
		</header>
		<section class="content centered">
			<div class="center">
				<p>Drag these to your bookmarks or favourites bar:</p>
				<a draggable="true" class="button" href="javascript:(function(){location.href='http://roblox-asset.comoj.com/'+location.href.match(/-(?:item|place)\?id=(\d+)/i)[1]})()" onclick="return false">Download Roblox Asset</a>
				<p>Then click it when viewing an asset detail page</p>
			</div>
		</section>
		<footer>
			<a href="http://eric-wieser.tk">More projects...</a>
		</footer>
	</body>
</html>
