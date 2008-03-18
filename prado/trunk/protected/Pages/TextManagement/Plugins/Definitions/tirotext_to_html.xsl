<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="html" indent="yes" encoding="utf-8" />

<xsl:template match="@*|node()">	<!--		This copies all the document and it's attributes, remember that -->
	<xsl:copy>									<!--  	Remember that attributes are NOT copied by default without an "@*" -->
		<xsl:apply-templates  select="@*|node()"/>
	</xsl:copy>
</xsl:template>

<xsl:template match="text">
	<div>
		<xsl:apply-templates  select="@*|node()"/>
	</div>
</xsl:template>

<xsl:template match="term">
	<span class="term">
		<xsl:apply-templates  select="@*|node()"/>
	</span>
</xsl:template>

<xsl:template match="sp">
	<div class="sp">
		<xsl:apply-templates  select="@*|node()"/>
	</div>
</xsl:template>

<xsl:template match="l">
        <span class="{name()}">
               <xsl:apply-templates select="@*|node()" />
        </span>
</xsl:template>

<xsl:template match="*">
	<element name="{name()}">
		<xsl:apply-templates  select="@*|node()"/>
	</element>
</xsl:template>

</xsl:stylesheet>