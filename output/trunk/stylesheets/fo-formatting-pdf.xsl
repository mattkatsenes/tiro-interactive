<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format">
  
  <xsl:output method="xml"
              version="1.0"
              encoding="utf-8"
              indent="yes"/>
		    
<xsl:template match="@*|node()">	<!--		This copies all the document and it's attributes, remember that -->
  <xsl:copy>									<!--  	Remember that attributes are not copied by default without an "@*" -->
    <xsl:apply-templates  select="@*|node()"/>
  </xsl:copy>
</xsl:template>
		    
<!--
<xsl:template match="*[@class/@id = 'XXXX']">	//Match the id or class from the xhtml tree
<xsl:element name="{name()}">						//Create a duplicate element matching the original element that
													//will have our fop-style attributes
	<xsl:attribute name="YYYY">ZZZZ</xsl:attribute>		//See fo:block/fo:inline specifications for possible style attributes,
															//Be aware that fo:inline can not be moved relative to their block (!=css)
	<xsl:apply-templates select="@*|node()"/>		//Cycle through and copy all attributes from original element (so as not to lose
													//element tags for future processing, then copy subnodes etc.
</xsl:element>										//Close completed copy of original element, but with new style attributes.
</xsl:template>
-->

</xsl:stylesheet>