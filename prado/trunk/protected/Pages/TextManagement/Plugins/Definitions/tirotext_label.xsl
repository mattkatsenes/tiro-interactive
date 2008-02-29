<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="html" indent="yes" encoding="utf-8" />

<xsl:template match="@*|node()">        <!--            This copies all the document and it's attributes, remember that -->
        <xsl:copy>                                                                      <!--    Remember that attributes are NOT copied by default without an "@*" -->
                <xsl:apply-templates  select="@*|node()"/>
        </xsl:copy>
</xsl:template>

<xsl:template match="term">
        <xsl:element name="{name()}">
        <xsl:attribute name="id-text"><xsl:value-of select="generate-id()"/></xsl:attribute>
                <xsl:apply-templates />
        </xsl:element>
</xsl:template>

<xsl:template match="*">
        <xsl:element name="{name()}">
                <xsl:apply-templates />
        </xsl:element>
</xsl:template>

</xsl:stylesheet>