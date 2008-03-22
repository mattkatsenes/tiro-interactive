<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:page="http://apache.org/cocoon/paginate/1.0">
<xsl:output method="html" indent="yes"/>
<xsl:include href="backend.xsl"/>

<xsl:variable name="lastLine">
	<xsl:value-of select="(//l)[count(//l)]/@n" />
</xsl:variable>
<xsl:variable name="startLine">
	<xsl:value-of select="(//l)[1]/@n" />
</xsl:variable>


<xsl:variable name="title">
	<xsl:value-of select="//title" />
</xsl:variable>

<xsl:variable name="author">
	<xsl:value-of select="//author" />
</xsl:variable>

<xsl:variable name="editor">
	<xsl:value-of select="//editor" />
</xsl:variable>


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
				<xsl:value-of select="$pagetitle"/> - lines: <xsl:value-of select="$startLine"/>-<xsl:value-of select="$lastLine"/>
			</title>
			<xsl:call-template name="includeCSS"/>
			<xsl:call-template name="includeJava"/>
		</head>
		<body>
			<xsl:call-template name="title_author" />
			
			<div id="text">
				<xsl:apply-templates select="text/body/*[@n!='glossary' and @n!='notes']" />
			</div>
			
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
		</body>
	</html>
</xsl:template>

</xsl:stylesheet>
