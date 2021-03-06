<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="html" indent="yes" encoding="utf-8" />



<!-- Get Rid of "text" and "body" tags -->
	<xsl:template match="TEI">
		<xsl:apply-templates />
	</xsl:template>
	
	<xsl:template match="text">
		<xsl:apply-templates />
	</xsl:template>

	<xsl:template match="body">
		<xsl:apply-templates />
	</xsl:template>
	
<!-- Catch all the rest -->
	<xsl:template match="*">
		<xsl:choose>
			<xsl:when test="child::term">
				<xsl:element name="div">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="orig_tag"><xsl:value-of select="name()"/></xsl:attribute>
					<xsl:attribute name="class">lowest tocDiv <xsl:value-of select="@annotation"/></xsl:attribute>
					<a href="javascript:attachAnnotation('tiro_{@id_text}')"><xsl:value-of select="name()"/>: <xsl:value-of select="@type" /> <xsl:value-of select="@n" /></a><xsl:text> </xsl:text>
					<xsl:apply-templates />
				</xsl:element>
			</xsl:when>
			<xsl:when test="not(name() = 'term')">
				<xsl:element name="div">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="orig_tag"><xsl:value-of select="name()"/></xsl:attribute>
					<xsl:attribute name="class">branch tocDiv  <xsl:value-of select="@annotation"/></xsl:attribute>
					<a  href="javascript:toggleExpand('tiro_{@id_text}')"><img border="0" id="img_tiro_{@id_text}" src="http://localhost/frontend/images/east.gif"/></a><a href="javascript:attachAnnotation('tiro_{@id_text}')"><xsl:value-of select="name()"/>: <xsl:value-of select="@type" /> <xsl:value-of select="@n" /></a><xsl:text> </xsl:text>
					<xsl:apply-templates />
				</xsl:element>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="span">
					<xsl:attribute name="id">tiro_<xsl:value-of select="@id_text"/></xsl:attribute>
					<xsl:attribute name="onclick">javascript:attachAnnotation('tiro_<xsl:value-of select="@id_text"/>')</xsl:attribute>
					<xsl:attribute name="class">leaf  <xsl:value-of select="@annotation"/></xsl:attribute>
					<xsl:value-of select="."/><xsl:text> </xsl:text>
				</xsl:element>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	
	<xsl:template name="check_annotations">
		<xsl:param name="id_text"/>
		<xsl:param name="class"/>
		
		<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
		
				
	</xsl:template>

</xsl:stylesheet>
