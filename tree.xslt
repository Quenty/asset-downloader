<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
	version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns="http://www.w3.org/1999/xhtml">
 
	<xsl:output
		omit-xml-declaration="yes"
		doctype-system="about:legacy-compat"
		method="html" indent="no" encoding="UTF-8"/>
 
	<xsl:template match="/roblox">
		<html>
			<head>
				<title>Roblox Asset - <xsl:value-of select="Item/Properties/*[@name='Name']" /></title>
				<link rel="stylesheet" href="monokai.css" />
				<link rel="shortcut icon" type="image/png" href="http://eric-wieser.tk/images/favicon.png" />
				<link href="http://fonts.googleapis.com/css?family=Muli:400,400italic" rel="stylesheet" type="text/css" />
				<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
				<style>
					body {
						background: #F0F0F0;
						margin: 0;
						padding: 0;
						font-family: Muli, sans-serif;
						line-height: 20px;
					}
					h1 {
						padding: 5px;
						margin: 0;
						line-height: 40px;
					}
					pre {
						margin: 0;
						white-space: pre-wrap;
					}
					ul {
						margin: 0;
						padding: 0;
						list-style: none;
						padding-left: 25px;
					}
					ul li {
						margin: 0;
						padding: 0;
					}
					.icon {
						float: left;
						margin-left: -25px;
						height: 18px;
						width: 18px;
						padding: 1px;
						vertical-align: middle;
						margin
					}
					.icon img {
						display: block;
						margin: 0;
						padding: 0;
					}
					.name {
						cursor: pointer;
					}

					li.collapsed .details {
						display: none;
					}
					li.collapsed .name:after {
						content: "...";
						color: #808080;
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
			
				</style>
			</head>
			<body>
				<header>
					<h1>Roblox Asset downloader</h1>
					<p>Push Ctrl+S or File -> Save to save this model to your computer</p>
				</header>
				<section class="content">
					<ul>
						<xsl:apply-templates select="Item" />
					</ul>
				</section>
				<script src="highlight.pack.js"></script>
				<script>
				hljs.tabReplace = '    ';
				hljs.initHighlighting();
				</script>
				<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
				<script>
					$(function() {
						$('body').on('click', 'li .name', function() {
							$(this).parent().toggleClass('collapsed');
							return false;
						});
					});
				</script>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="Item">
		<li>
			<span class="icon">
				<img src="http://wiki.roblox.com/index.php/Special:Filepath/File:{@class}_icon.png" />
			</span>
			<a class="name" title="{@class}"><xsl:value-of select="./Properties/*[@name='Name']"/></a>
			<div class="details">
				<xsl:if test="(@class='Script' or @class='LocalScript'or @class='CoreScript') and ./Properties/*[@name='Source']">
					<pre><code class="language-lua">
	<xsl:value-of select="./Properties/*[@name='Source']"/>
	</code></pre>
				</xsl:if>
				<xsl:if test="Item">
					<ul>
						<xsl:apply-templates select="Item" />
					</ul>
				</xsl:if>
			</div>
		</li>
	</xsl:template>
</xsl:stylesheet>