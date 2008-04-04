<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="xml" indent="yes" encoding="utf-8" />

<!-- Entry Point -->
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>

	
<!-- Catch all the rest -->
	<xsl:template match="*">
		<xsl:choose>
			<xsl:when test="not(name() = 'term')">
				<xsl:element name="branch">
					<xsl:attribute name="id_text"><xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="tag"><xsl:value-of select="name()"/></xsl:attribute>
					<xsl:apply-templates />
				</xsl:element>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="leaf">
					<xsl:attribute name="id_text"><xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:value-of select="."/>
				</xsl:element>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
