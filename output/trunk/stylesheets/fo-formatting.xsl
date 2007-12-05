<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format">

			<xsl:variable name="smallest-font">8pt</xsl:variable>
			<xsl:variable name="small-font">10pt</xsl:variable>
			<xsl:variable name="normal-font">12pt</xsl:variable>
			<xsl:variable name="large-font">20pt</xsl:variable>

			<xsl:variable name="small-space">0.1in</xsl:variable>
			<xsl:variable name="normal-space">0.3in</xsl:variable>
			<xsl:variable name="large-space">0.6in</xsl:variable>
			<xsl:variable name="larger-space">0.8in</xsl:variable>

	<xsl:output method="xml"
              version="1.0"
              encoding="utf-8"
              indent="yes"/>

<xsl:template match="@*|node()">
  <xsl:copy>
    <xsl:apply-templates  select="@*|node()"/>
  </xsl:copy>
</xsl:template>

<xsl:template match="fo:flow[@flow-name='xsl-region-body']/fo:block">
<xsl:element name="{name()}">
	
	<xsl:attribute name="font-family">Times</xsl:attribute>
	<xsl:attribute name="font-size"> <xsl:value-of select="$normal-font" /></xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
	
</xsl:element>
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

<!--		Remove the navigation-table from the base XHTML page. - Drew 12/01/07	 -->
<xsl:template match="*[@id='navigation']" />

<xsl:template match="*[@id='title']">
<xsl:element name="{name()}">
	<xsl:attribute name="font-size">	<xsl:value-of select="$large-font"/>	</xsl:attribute>
	<xsl:attribute name="text-align">center</xsl:attribute>
		<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@id='author']">
<xsl:element name="{name()}">
	<xsl:attribute name="font-size">	<xsl:value-of select="$smallest-font"/>	</xsl:attribute>
	<xsl:attribute name="text-align">center</xsl:attribute>
	<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
		<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@id='notes_heading']">
<xsl:element name="fo:block">

	<xsl:attribute name="space-before"><xsl:value-of select="$normal-space"/></xsl:attribute>
		<xsl:apply-templates select="@*|node()"/>
		
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='defined_term']">
<xsl:element name="fo:inline">

	<xsl:attribute name="font-style">italic</xsl:attribute>
	
	<xsl:apply-templates/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@id='marginalia']">
<xsl:element name="{name()}">

	<xsl:attribute name="font-size"><xsl:value-of select="$small-font"/></xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='headword']">
<xsl:element name="{name()}">

	<xsl:attribute name="font-weight">bold</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='part_of_speech']">
<xsl:element name="{name()}">

	<xsl:attribute name="font-style">italic</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='speaker']">
<xsl:element name="fo:block">

	<xsl:attribute name="start-indent">1.5in</xsl:attribute>
	<xsl:attribute name="font-weight">bold</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@id='text']">
<xsl:element name="{name()}">

	<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='lg']">
<xsl:element name="{name()}">
	<xsl:attribute name="space-after"><xsl:value-of select="$small-space"/></xsl:attribute>
	<xsl:attribute name="font-style">normal</xsl:attribute>

	<fo:table start-indent="1in">
			<fo:table-column column-width="0.5in"/>
			<fo:table-column column-width="6in"/>		
		<fo:table-body>
			<xsl:apply-templates select="*[@class='l']"/>
		</fo:table-body>
	</fo:table>
	
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='line_number']" />
<xsl:template match="*[@class='l']">

			<fo:table-row>
				<fo:table-cell>
					<xsl:choose>
						<xsl:when test="preceding-sibling::*[1][@class='line_number']">
							<fo:block class="line_number" font-style="normal"><xsl:value-of select="preceding-sibling::*[1][@class='line_number']"/></fo:block>
						</xsl:when>
						<xsl:otherwise>
							<fo:block class="no_line_number"></fo:block>
						</xsl:otherwise>
					</xsl:choose>
				</fo:table-cell>
				<fo:table-cell>
					<fo:block><xsl:apply-templates select="@*|node()"/></fo:block>
				</fo:table-cell>
			</fo:table-row>

</xsl:template>

<xsl:template match="*[@id='definitions_heading']">
<xsl:element name="fo:block">
	<xsl:attribute name="start-indent">1in</xsl:attribute>
	<xsl:attribute name="font-size"><xsl:value-of select="$normal-font"/></xsl:attribute>
	<xsl:attribute name="font-weight">bold</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@id='definitions']">
<xsl:element name="{name()}">
	<xsl:variable name="definition_entry_count"><xsl:value-of select="count(*[@class='entry'])"/></xsl:variable>
	<xsl:variable name="def_col1"><xsl:value-of select="round($definition_entry_count div 2)"/></xsl:variable>
	<xsl:variable name="def_col2"><xsl:value-of select="$definition_entry_count - $def_col1"/></xsl:variable>
			<xsl:attribute name="node_count"><xsl:value-of select="$def_col1"/>,<xsl:value-of select="$def_col2"/></xsl:attribute>
			<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
			
		<fo:table font-size="{$small-font}" table-layout="fixed" width="100%" >
			<fo:table-column column-width="1in"/>
			<fo:table-column class="def_col1_size" column-width="3in"
									border-after-width="0.25pt" border-after-color="black" border-after-style="solid"
									border-top-width="0.25pt" border-top-color="black" border-top-style="solid"
			/>
			<fo:table-column class="def_col2_size" column-width="3in"
									border-after-width="0.25pt" border-after-color="black" border-after-style="solid"
									border-top-width="0.25pt" border-top-color="black" border-top-style="solid"
			/>
			<fo:table-column column-width="1in"/>
			<fo:table-body >			
				<fo:table-row>
					<fo:table-cell column-number="2">
						<fo:block id="def_col1" class="def_col">
						<xsl:for-each select="(*[(@class='entry')])[position() &lt;= $def_col1]">
								<xsl:element name="{name()}">
									<xsl:attribute name="n"><xsl:value-of select="position()"/></xsl:attribute>
									<xsl:apply-templates select="@*|node()"/>
								</xsl:element>
						</xsl:for-each>
						</fo:block>
					</fo:table-cell>

					<fo:table-cell column-number="3">	
						<fo:block id="def_col2" class="def_col">
						<xsl:for-each select="(*[(@class='entry')])[position() &gt; $def_col1]">
								<xsl:element name="{name()}">
									<xsl:attribute name="n"><xsl:value-of select="position()"/></xsl:attribute>
									<xsl:apply-templates select="@*|node()"/>
								</xsl:element>
						</xsl:for-each>
						</fo:block>
					</fo:table-cell>	
				</fo:table-row>
			</fo:table-body>
		</fo:table>		
	</xsl:element>
</xsl:template>


<xsl:template match="*[@id='notes_heading']">
<xsl:element name="fo:block">


	<xsl:attribute name="font-size"><xsl:value-of select="$normal-font"/></xsl:attribute>
	<xsl:attribute name="start-indent">1in</xsl:attribute>
	<xsl:attribute name="font-weight">bold</xsl:attribute>
	
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='note']">
<xsl:element name="{name()}">
	<xsl:attribute name="start-indent">1in</xsl:attribute>
	<xsl:attribute name="font-size"><xsl:value-of select="$small-font"/></xsl:attribute>
	<xsl:apply-templates select="	@*[not(
														name()='font-family'
														or name()='font-size'
														)														
													]|node()"/>
</xsl:element>
</xsl:template>


</xsl:stylesheet>