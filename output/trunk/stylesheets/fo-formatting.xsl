<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format">
			 
<!-- Variable list to allow for vague css ishness -->
			<xsl:variable name="small-font"		>10pt</xsl:variable>
			<xsl:variable name="normal-font"	>12pt</xsl:variable>
			<xsl:variable name="large-font"		>16pt</xsl:variable>
			<xsl:variable name="larger-font"		>20pt</xsl:variable>

			<xsl:variable name="small-space"		>0.1in</xsl:variable>
			<xsl:variable name="normal-space"	>0.3in</xsl:variable>
			<xsl:variable name="large-space"		>0.6in</xsl:variable>
			<xsl:variable name="larger-space"		>0.8in</xsl:variable>
			
			<xsl:variable name="small-indent"		>0.5in</xsl:variable>
			<xsl:variable name="normal-indent"	>1in</xsl:variable>
			<xsl:variable name="large-indent"		>1.5in</xsl:variable>
			<xsl:variable name="larger-indent"		>2in</xsl:variable>
			
			<xsl:variable name="lg_block_col1"	>0.5in</xsl:variable>  <!--Line number column of line-groups-table-->
			<xsl:variable name="lg_block_col2"	>5in</xsl:variable>  <!--Latin-line column of line-groups-table-->
			
			<xsl:variable name="definitions_block_col">2.75in</xsl:variable>		<!-- Width of definition columns (left-margin/right margin are set = $normal-indent) -->
				<xsl:variable name="def_border_width"	>0.25pt</xsl:variable>	<!-- Definition of start-end border vertical-width, !NOTE! border is applied to each  -->
				<xsl:variable name="def_border_color"	>black</xsl:variable>		<!-- of the defintion cells, but NOT the left-right margin cells -->
				<xsl:variable name="def_border_style"	>solid</xsl:variable>
<!-- end Variable list to allow for vague css ishness -->
			
	<xsl:output method="xml"
              version="1.0"
              encoding="utf-8"
              indent="yes"/>

<xsl:template match="@*|node()">	<!--		This copies all the document and it's attributes, remember that -->
	<xsl:copy>									<!--  	Remember that attributes are NOT copied by default without an "@*" -->
		<xsl:apply-templates  select="@*|node()"/>
	</xsl:copy>
</xsl:template>

<xsl:template match="fo:flow[@flow-name='xsl-region-body']/fo:block">
<xsl:element name="{name()}">
	<!-- These attributes set the default font/size for the pdf and rtf -->
	<xsl:attribute name="font-family">Times</xsl:attribute>
	<xsl:attribute name="font-size"> <xsl:value-of select="$normal-font" /></xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<!--
<xsl:template match="*[@class/@id = 'XXXX']">	//Match the id or class from the xhtml tree
<xsl:element name="{name()}">						//Create a duplicate element matching the original element that
													//will have our fop-style attributes, 
													//NOTE!! In some cases, because the html2fo converts some types of html
													//to fo:inline, which CAN NOT have indents, etc, I have manually changed
													//the {name()} to fo:block, which can then be formatted properly.
													//always try {name()} first, then fo:block, and only then fo:inline for <xsl:element>!! -DREW
	<xsl:attribute name="YYYY">ZZZZ</xsl:attribute>		//See fo:block/fo:inline specifications for possible style attributes,
															//Be aware that fo:inline can not be moved relative to their block (!=css)
	<xsl:apply-templates select="@*|node()"/>		//Cycle through and copy all attributes from original element (so as not to lose
													//element tags for future processing, then copy subnodes etc.
</xsl:element>										//Close completed copy of original element, but with new style attributes.
</xsl:template>
-->

<!-- Name/Title section -->
<xsl:template match="*[@id='title']">
	<xsl:element name="{name()}">
		<xsl:attribute name="font-size">	<xsl:value-of select="$larger-font"/>	</xsl:attribute>
		<xsl:attribute name="text-align">center</xsl:attribute>
			<xsl:apply-templates select="@*|node()"/>
	</xsl:element>
</xsl:template>

<xsl:template match="*[@id='author']">
	<xsl:element name="{name()}">
		<xsl:attribute name="font-size">	<xsl:value-of select="$small-font"/>	</xsl:attribute>
		<xsl:attribute name="text-align">center</xsl:attribute>
		<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
			<xsl:apply-templates select="@*|node()"/>
	</xsl:element>
</xsl:template>
<!--	 end Name/Title section	-->


<!-- Text section			-->
<xsl:template match="*[@id='text']">
<xsl:element name="{name()}">
	<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

<xsl:template match="*[@class='speaker']">
<xsl:element name="fo:block">
	<xsl:attribute name="start-indent"><xsl:value-of select="$large-indent"/></xsl:attribute>
	<xsl:attribute name="font-weight">bold</xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

	<!-- LineGroup section		-->
	<xsl:template match="*[@class='lg']">
		<xsl:element name="{name()}">
			<xsl:attribute name="space-after"><xsl:value-of select="$small-space"/></xsl:attribute>
			<xsl:attribute name="font-style">normal</xsl:attribute>

			<fo:table start-indent="{$normal-indent}" class="lg_block_table">
				<!--  This setup because it matches each class='lg' seperately will create 1 table of number-labels and
				latin-lines, per class='lg' object.  The Speaker names are not included in these created tables. -->
					<fo:table-column column-width="{$lg_block_col1}" class="lg_block_col1"/>
					<fo:table-column column-width="{$lg_block_col2}" class="lg_block_col2"/>		
				<fo:table-body class="lg_block_body">
					<xsl:apply-templates select="*[@class='l']"/>
					<!-- This triggers the formatting of the text lines into table-cells.  See the template "*[@class='l']" for more details, at end of file. -->
				</fo:table-body>
			</fo:table>
			
		</xsl:element>
	</xsl:template>

	<xsl:template match="*[@class='defined_term']">
	<xsl:element name="fo:inline">
		<xsl:attribute name="font-style">italic</xsl:attribute>
		<xsl:apply-templates/>
	</xsl:element>
	</xsl:template>
	<!--	end LineGroup section	-->
<!--	end Text section	-->


<!-- Marginalia section		-->
<xsl:template match="*[@id='marginalia']">
<xsl:element name="{name()}">
	<xsl:attribute name="font-size"><xsl:value-of select="$small-font"/></xsl:attribute>
	<xsl:apply-templates select="@*|node()"/>
</xsl:element>
</xsl:template>

	<!-- Defintions section		-->
	<xsl:template match="*[@id='definitions_heading']">
		<xsl:element name="fo:block">
			<xsl:attribute name="start-indent"><xsl:value-of select="$normal-indent"/></xsl:attribute>
			<xsl:attribute name="font-size"><xsl:value-of select="$normal-font"/></xsl:attribute>
			<xsl:attribute name="font-weight">bold</xsl:attribute>
			<xsl:apply-templates select="@*|node()"/>
		</xsl:element>
	</xsl:template>
	<!-- See template "*[@id='definitions']" at end-of-file for details of how the definition table is created.	-->
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
	<!--	end Defintions section	-->

	<!-- Notes section			-->
	<xsl:template match="*[@id='notes_heading']">
	<xsl:element name="fo:block">
		<xsl:attribute name="font-size"><xsl:value-of select="$normal-font"/></xsl:attribute>
		<xsl:attribute name="start-indent"><xsl:value-of select="$normal-indent"/></xsl:attribute>
		<xsl:attribute name="font-weight">bold</xsl:attribute>
		<xsl:apply-templates select="@*|node()"/>
	</xsl:element>
	</xsl:template>

	<xsl:template match="*[@class='note']">
	<xsl:element name="{name()}">
		<xsl:attribute name="start-indent"><xsl:value-of select="$normal-indent"/></xsl:attribute>
		<xsl:attribute name="font-size"><xsl:value-of select="$small-font"/></xsl:attribute>
		<xsl:apply-templates select="	@*[not(
															name()='font-family'
															or name()='font-size'
															or name()='color'
															)														
														]|node()"/>
	</xsl:element>
	</xsl:template>
	<!--	end Notes section	-->
<!--	end Marginalia section	-->


<!-- Navigation section		-->
	<!--		Remove the navigation-table from the base XHTML page. - Drew 12/01/07	 -->
	<xsl:template match="*[@id='navigation']" />
<!--	end Navigation section	-->


<!-- Complex logic section		-->
<xsl:template match="*[@class='line_number']" /> <!-- This removes the line numbers from the xml feed so that they only appear if accessed in the *[@class='l'] template, manually -->
<xsl:template match="*[@class='l']">	<!--The table these rows match with has been created in the template "*[@class='lg']" -->
			<fo:table-row>
				<fo:table-cell class="lg_cell_linenumber">
					<xsl:choose>
					<!--	The XHTML is setup in the following fashion:
																			<class="l">"latin line"</>
																			<class="l">"latin line"</>
											<class="line_number">"3"</>	<class="l">"latin line"</>
																			<class="l">"latin line"</>
						So, since the line_number object is not inside the latin_line it relates to, we must check
						the previous sibling object to see if it is a "line_number" object. -->
						<xsl:when test="preceding-sibling::*[1][@class='line_number']"> <!--should return a line_number object!!-->
							<!--- IF object before current latin-line IS line number, put in left hand table cell -->
							<fo:block class="line_number" font-style="normal"><xsl:value-of select="preceding-sibling::*[1][@class='line_number']"/></fo:block>
						</xsl:when>
						<xsl:otherwise>
							<!--- IF NOT  put blank left hand table cell, with a new class tag so this cell can be further modified by other XSLT-->
							<fo:block class="no_line_number"></fo:block>
						</xsl:otherwise>
					</xsl:choose>
				</fo:table-cell>
				<fo:table-cell class="lg_cell_text"> <!--Always put content of class="l" latin line into right hand cell of lg table -->
					<fo:block class="l_text"><xsl:apply-templates select="@*|node()"/></fo:block>
				</fo:table-cell>
			</fo:table-row>
</xsl:template>


<xsl:template match="*[@id='definitions']">
<xsl:element name="{name()}">

	<!-- In order to calculate the number of entries in each of the two columns of the definitions table: -->
	<xsl:variable name="definition_entry_count"><xsl:value-of select="count(*[@class='entry'])"/></xsl:variable>		<!-- One first counts of the number of entries in the XHTML div-->
	<xsl:variable name="def_col1"><xsl:value-of select="round($definition_entry_count div 2)"/></xsl:variable>		<!-- then divde the number by two and round to the nearest whole number, and call that column 1	-->
	<xsl:variable name="def_col2"><xsl:value-of select="$definition_entry_count - $def_col1"/></xsl:variable>			<!-- Then take the total number of entries, subtract col1, and call that col 2.  Assert col1>=col2. 		-->
			<xsl:attribute name="space-after"><xsl:value-of select="$normal-space"/></xsl:attribute>
			
		<fo:table font-size="{$small-font}" id="definitions_block_table">
			<fo:table-column column-width="{$normal-indent}" id="definitions_left_margin"/>
			<!-- FOP fails to format tables to pdf properly.  The only way to indent a table in the proper fashion is to create	-->
			<!-- A left and right margin cell.  This should more properly be moved into the PDF specific section, since they		-->
			<!-- are removed anyway by the RTF section, but I dont want to deal with it right now. -DREW	-->
			<fo:table-column class="definitions_block_col" id="definitions_block_col1" 			
									column-width="{$definitions_block_col}"																
									border-after-width="{$def_border_width}" border-after-color="{$def_border_color}" border-after-style="{$def_border_style}"
									border-top-width="{$def_border_width}" border-top-color="{$def_border_color}" border-top-style="{$def_border_style}"
			/>
			<fo:table-column class="definitions_block_col" id="definitions_block_col2"
									column-width="{$definitions_block_col}"
									border-after-width="{$def_border_width}" border-after-color="{$def_border_color}" border-after-style="{$def_border_style}"
									border-top-width="{$def_border_width}" border-top-color="{$def_border_color}" border-top-style="{$def_border_style}"
			/>
			<fo:table-column column-width="{$normal-indent}" id="definitions_right_margin"/><!-- see above -->
			<fo:table-body >			
				<fo:table-row>
		
					<fo:table-cell column-number="2"> <!-- column-number 1 is definitions_left_margin -->
						<fo:block id="def_block1" class="def_block">
						<xsl:for-each select="(*[(@class='entry')])[position() &lt;= $def_col1]">		<!--For-each entry whose position in the list of all "*[(@class='entry')]" is <= value_def_col1, display! -->
								<xsl:element name="{name()}">
									<xsl:attribute name="n"><xsl:value-of select="position()"/></xsl:attribute>
									<xsl:apply-templates select="@*|node()"/>
								</xsl:element>
						</xsl:for-each>
						</fo:block>
					</fo:table-cell>
					
					<fo:table-cell column-number="3"> <!-- column-number 4 is definitions_right_margin -->	
						<fo:block id="def_block2" class="def_block">
						<xsl:for-each select="(*[(@class='entry')])[position() &gt; $def_col1]">		<!--For-each entry whose position in the list of all "*[(@class='entry')]" is > value_def_col1, display!; YES I KNOW def_col2 is  superflous, so sue me! -DREW -->
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
<!-- end Complex logic section		-->

</xsl:stylesheet>
