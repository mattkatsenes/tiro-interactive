<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="html" indent="yes" encoding="utf-8" />

<!-- Call this xsl file when changing the text
gotten from TiroText::getText() (the <text> tag and it's descendents)
to some simple display for html.  -->

<xsl:template match="/">
		<xsl:apply-templates />
</xsl:template>

<xsl:template match="div">
	<div>
		<xsl:apply-templates />
	</div>
</xsl:template>

<xsl:template match="sp">
	<p>
		<xsl:apply-templates />
	</p>
	<xsl:text>
</xsl:text>
</xsl:template>

<xsl:template match="l">
	<xsl:apply-templates />
	<br />
	<xsl:text>
</xsl:text>
</xsl:template>

<xsl:template match="term">
	<xsl:value-of select="." />
	<xsl:text> </xsl:text>
</xsl:template>

</xsl:stylesheet>