<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format">
  
  <xsl:output method="xml"
              version="1.0"
              encoding="utf-8"
              indent="yes"/>

		    
	<xsl:template match="*">
		<xsl:copy>
		<xsl:copy-of select="@*"/>
			<xsl:apply-templates/>
		</xsl:copy>
	</xsl:template>

	<!-- Remove copies of notes and headings that come after the latin text -->
	<xsl:template match="*[@id='notes_heading']"/>
	<xsl:template match="*[@id='notes']"/>
	<!-- -->
	
	<!-- Find the PageStart fo:block (ref: fo-formatting-book.xsl) -->
	<xsl:template match="*[@id='PageStart']">
		<xsl:copy>
			<!-- Make copy of notes and move to front -->
			<xsl:copy-of select="@*|//*[@id='notes_heading']"/>
			<xsl:copy-of select="@*|//*[@id='notes']"/>
			<!-- Cause page break after notes ends -->
			<fo:block break-after="page"/>
				<!-- continue through xml files -->
				<xsl:apply-templates/>
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

<!--
<xsl:template match="*[@class = 'lg_block_table']">
<xsl:element name="{name()}">						
													
	<xsl:attribute name="break-after">page</xsl:attribute>
															
	<xsl:apply-templates select="@*|node()"/>		
													
</xsl:element>										
</xsl:template>
-->

</xsl:stylesheet>