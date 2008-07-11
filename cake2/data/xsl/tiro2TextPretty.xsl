<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version = '1.0' xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
	<xsl:output method="html"/>
	<xsl:template match="/TEI/teiHeader">
	</xsl:template>
	<xsl:template match="/TEI/text/body/*">
		<xsl:element name="div">
			<xsl:attribute name="class">original_div</xsl:attribute>
			<xsl:for-each select="l">
				<xsl:element name="div">
					<xsl:attribute name="class">line</xsl:attribute>
					<xsl:for-each select="term">
						<xsl:element name="span">
							<xsl:attribute name="class">term</xsl:attribute>
							<xsl:value-of select="."/><xsl:text> </xsl:text>
						</xsl:element>
					</xsl:for-each>
				</xsl:element>
			</xsl:for-each>
		</xsl:element>
	</xsl:template>		 
</xsl:stylesheet>