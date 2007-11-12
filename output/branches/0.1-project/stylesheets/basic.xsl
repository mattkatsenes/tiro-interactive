<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" indent="yes"/>

<xsl:template match="cocoon">
	<html>
		<head>
			<title><xsl:value-of select="title" /></title>
			<link type="text/css" rel="stylesheet" href="stylesheets/basic.css" />
		</head>
		<body>
			<xsl:apply-templates select="body" />
		</body>
	</html>
</xsl:template>

<xsl:template match="version">
	<h2>Version <xsl:value-of select="@number"/>:</h2>
	<xsl:apply-templates />
</xsl:template>

<xsl:template match="note">
	<span class="note"><xsl:apply-templates /></span>
</xsl:template>

<xsl:template match="ul">
	<br />
	<span class="title"><xsl:value-of select="@title" /></span>
	<ul><xsl:apply-templates /></ul>
</xsl:template>

<xsl:template match="li">
	<li>
	<xsl:choose>
		<xsl:when test="@done='yes'">
			<span class="done"><xsl:apply-templates /></span>
		</xsl:when>
		<xsl:when test="@done='wip'">
			<span class="wip"><xsl:apply-templates /></span>
		</xsl:when>
		<xsl:otherwise>
			<span class="not-done"><xsl:apply-templates /></span>
		</xsl:otherwise>
	</xsl:choose>
	</li>
</xsl:template>
</xsl:stylesheet>
