<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
	version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns="http://www.w3.org/1999/xhtml">
 
	<xsl:output method="xml" indent="no" encoding="UTF-8"/>
 
	<xsl:template match="/roblox">
		<html>
			<head>
				<title>Roblox Asset - <xsl:value-of select="Item/Properties/*[@name='Name']" /></title>
				<link rel="stylesheet" href="monokai.css" />
				<link rel="shortcut icon" type="image/png" href="http://eric-wieser.tk/images/favicon.png" />
				<style>
					body {
						background: #F0F0F0;
						margin: 0;
						padding: 0;
						font-family: Muli, sans-serif;
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
				</style>
			</head>
			<body>
				<xsl:for-each select="//Item[@class='Script' or @class='LocalScript']">
					<section>
						<h1><img src="http://wiki.roblox.com/index.php/Special:Filepath/File:Script_icon.png" /><xsl:value-of select="./Properties/*[@name='Name']"/></h1>
						<pre><code class="language-lua">
<xsl:value-of select="./Properties/*[@name='Source']"/>
</code></pre>
					</section>
				</xsl:for-each>
				<script src="highlight.pack.js"></script>
				<script>
				hljs.tabReplace = '    ';
				hljs.initHighlighting();
				</script>
			</body>
		</html>
	</xsl:template> 
</xsl:stylesheet>