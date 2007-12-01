<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format"
			 xmlns:jfor="http://www.jfor.org/xmlns/2001/stylesheet"
			 >
  
  <xsl:output method="xml"
              version="1.0"
              encoding="utf-8"
              indent="yes"/>
		    
<xsl:template match="@*|node()">
  <xsl:copy>
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


<xsl:template match="fo:flow[@flow-name='xsl-region-body']/fo:block">
<xsl:element name="{name()}">
	
	<xsl:attribute name="font-family">Times</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>


<xsl:template match="*[@class='l']">
<xsl:element name="{name()}">

	<xsl:attribute name="font-family">Times</xsl:attribute>
	<xsl:attribute name="color">blue</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='defined_term']">
<xsl:element name="{name()}">

	<xsl:attribute name="font-style">italic</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>


<xsl:template match="*[@class='speaker']">
<xsl:element name="{name()}">
	
	<xsl:attribute name="color">green</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>
	    
	    
<xsl:template match="*[@id='marginalia']">
<xsl:element name="{name()}">
	
	<xsl:attribute name="color">#CCBB00</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='entry']">
<xsl:element name="{name()}">
	
	<xsl:attribute name="color">#CCAA00</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='note']">
<xsl:element name="{name()}">

	<xsl:apply-templates select="node()"/>
	
</xsl:element>
</xsl:template>


<xsl:template match="@font-size">
<xsl:copy />
<xsl:attribute name="font-size">8pt</xsl:attribute>
<!--	<xsl:apply-templates select="node()"/> -->
</xsl:template>

<jfor:stylesheet default="Normal">
<jfor:style name="Normal" font-size="10pt" font-family="Helvetica"/> 
</jfor:stylesheet> 


</xsl:stylesheet>