<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="html" indent="yes" encoding="utf-8" />



<!-- Entry Point -->
	<xsl:template match="/">
<h1>Testing</h1>
<p>Click the arrows to expand sections.  Click the link to attach the image to the whole section.  Click a single word to attach an image to an individual word.</p>
		<xsl:apply-templates/>
	</xsl:template>

	
<!-- Catch all the rest -->
	<xsl:template match="*">
		<xsl:choose>
			<xsl:when test="child::term">
				<xsl:element name="div">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="orig_tag"><xsl:value-of select="name()"/></xsl:attribute>
					<xsl:attribute name="class">lowest tocDiv</xsl:attribute>
					<a href="javascript:attach('tiro_{@id_text}')"><xsl:value-of select="name()"/>: <xsl:value-of select="@type" /> <xsl:value-of select="@n" /></a><xsl:text> </xsl:text>
					<xsl:apply-templates />
				</xsl:element>
			</xsl:when>
			<xsl:when test="not(name() = 'term')">
				<xsl:element name="div">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="orig_tag"><xsl:value-of select="name()"/></xsl:attribute>
					<xsl:attribute name="class">branch tocDiv</xsl:attribute>
					<a  href="javascript:toggleExpand('tiro_{@id_text}')"><img border="0" id="img_tiro_{@id_text}" src="http://localhost/frontend/images/east.gif"/></a><a href="javascript:attach('tiro_{@id_text}')"><xsl:value-of select="name()"/>: <xsl:value-of select="@type" /> <xsl:value-of select="@n" /></a><xsl:text> </xsl:text>
					<xsl:apply-templates />
				</xsl:element>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="span">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="onclick">javascript:attach('tiro_<xsl:value-of select="@id_text"/>')</xsl:attribute>
					<xsl:attribute name="class">leaf</xsl:attribute>
					<xsl:value-of select="."/>
				</xsl:element>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
