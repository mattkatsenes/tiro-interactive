<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:page="http://apache.org/cocoon/paginate/1.0">
<xsl:output method="html" indent="yes"/>
<xsl:include href="backend-ajax.xsl"/>

<xsl:variable name="title">
	<xsl:value-of select="//title" />
</xsl:variable>

<xsl:variable name="author">
	<xsl:value-of select="//author" />
</xsl:variable>

<xsl:variable name="editor">
	<xsl:value-of select="//editor" />
</xsl:variable>
<xsl:variable name="startLine" />

<xsl:template match="*">
	<xsl:apply-templates />
</xsl:template>

<xsl:template match="TEI">
	<html>
		<head>
 			<xsl:variable name="pagetitle">
				<xsl:value-of select="$title" /><xsl:text> by </xsl:text><xsl:value-of select="$author" />
			</xsl:variable>
			<title>
				<xsl:value-of select="$pagetitle"/>
			</title>
			<xsl:call-template name="includeCSS"/>
			<link href="stylesheets/text-area-formating.css" rel="stylesheet" type="text/css" />
			
			<xsl:call-template name="includeJava" />
			<script type="text/javascript" src="js/temp.js" ></script>			
		</head>
	<body>
	<div id="header">
		<span>Click to add text area :</span>
		<xsl:call-template name="title_author" />
		<div id="addTextAreaButton">[+]</div>
		<div>Status Code:  <span id="status-code">&#160;</span></div>
	</div>
		
	<div id="container">
		<div id="left-col" class="column"><textarea name="pagenotes" id="pagenotes">&#160;</textarea></div>
		
		<div id="center-col" class="column">
			<div id="text">
				<xsl:apply-templates select="text/body/div[@n!='glossary' and @n!='notes']" />
			</div>
		</div>	
		
		<div id="right-col" class="column"><span>&#160;</span></div>
	</div>	
	<div id="footer">
		<div id="marginalia">
				<span id="definitions_heading">Definitions:</span>
				<div id="definitions">
					<xsl:apply-templates select="text/body/div[@n='glossary']">
						<xsl:sort select="orth" />
					</xsl:apply-templates>
				</div>
				
				<span id="notes_heading">Notes:</span>
				<div id="notes">
					<xsl:apply-templates select="text/body/div[@n='notes']" />
				</div>
			</div>
			
		<div id="navigation">
			<xsl:apply-templates select="page:page" />
		</div>
	</div>
	</body>
	</html>
</xsl:template>

</xsl:stylesheet>
