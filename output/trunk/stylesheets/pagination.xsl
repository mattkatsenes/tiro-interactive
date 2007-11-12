<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
		xmlns:exsl="http://exslt.org/common" version="1.0">

<xsl:variable name="outputSuffix">.html</xsl:variable>

<xsl:variable name="processor">
   <xsl:value-of select="system-property('xsl:vendor')"/>
</xsl:variable>

	<xsl:template match="/">
	
		<xsl:call-template name="outputChunk">
			<xsl:with-param name="ident">crazy_file_name_1</xsl:with-param>
			<xsl:with-param name="content"><xsl:value-of select="//item[1]" /></xsl:with-param>
		</xsl:call-template>
		

		<xsl:call-template name="outputChunk">
			<xsl:with-param name="ident">crazy_file_name_2</xsl:with-param>
			<xsl:with-param name="content"><xsl:value-of select="//item[2]" /> </xsl:with-param>
		</xsl:call-template>
		
	</xsl:template>

<!-- Output Chunking for multiple files.. I hope. -->
	<xsl:template name="outputChunk">
		<xsl:param name="ident"/>
		<xsl:param name="content"/>
		<xsl:param name="verbose">false</xsl:param>
		<xsl:variable name="outName">
			<xsl:value-of select="$ident" /><xsl:value-of select="$outputSuffix" />
		</xsl:variable>
		<xsl:if test="$verbose='true'">
			<xsl:message>Opening <xsl:value-of select="$outName"/>  with EXSLT.  Putting <xsl:value-of select="$content" /></xsl:message>
		</xsl:if>
		
		
	<!--	<xalan:write xmlns:xalan="org.apache.xalan.xslt.extensions.Redirect" xsl:extension-element-prefixes="xalan" file="{$outName}">
			<xsl:copy-of select="$content"/>
		</xalan:write> -->
		
		<exsl:document href="{$outName}">
			<xsl:copy-of select="$content" />
		</exsl:document>
		
		<xsl:if test="element-available('exsl:document')">
			<xsl:message>EXSLT!!</xsl:message>
		</xsl:if>
		
		<xsl:if test="$verbose='true'">
			<xsl:message>Closing file <xsl:value-of select="$outName"/>
			</xsl:message>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>

<!-- 
 <xsl:when test="element-available('exsl:document')">
        <xsl:if test="$verbose='true'">
          <xsl:message>Opening <xsl:value-of select="$outName"/> with exsl:document</xsl:message>
        </xsl:if>
        <exsl:document encoding="{$outputEncoding}" 
		       method="{$outputMethod}" 
		       doctype-public="{$doctypePublic}" 
		       doctype-system="{$doctypeSystem}" 
		       href="{$outName}">
          <xsl:copy-of select="$content"/>
        </exsl:document>
        <xsl:if test="$verbose='true'">
          <xsl:message>Closing file <xsl:value-of select="$outName"/></xsl:message>
        </xsl:if>
      </xsl:when>
      <xsl:when test="contains($processor,'SAXON 7')">
        <xsl:if test="$verbose='true'">
          <xsl:message>Opening <xsl:value-of select="$outName"/> with Saxon 8</xsl:message>
        </xsl:if>
        <saxon7:output encoding="{$outputEncoding}" 		       method="{$outputMethod}" 
		       doctype-public="{$doctypePublic}" 
		       doctype-system="{$doctypeSystem}" 
		       href="{$outName}">
          <xsl:copy-of select="$content"/>
	</saxon7:output>
        <xsl:if test="$verbose='true'">
          <xsl:message>Closing file <xsl:value-of select="$outName"/></xsl:message>
        </xsl:if>
      </xsl:when>
      <xsl:when test="contains($processor,'SAXON 6')">
        <xsl:if test="$verbose='true'">
          <xsl:message>Opening <xsl:value-of select="$outName"/> with Saxon 6</xsl:message>
        </xsl:if>
        <saxon6:output encoding="{$outputEncoding}" 
		       method="{$outputMethod}" 
		       doctype-public="{$doctypePublic}" 
		       doctype-system="{$doctypeSystem}" 
		       href="{$outName}">
          <xsl:copy-of select="$content"/>
        </saxon6:output>
        <xsl:if test="$verbose='true'">
          <xsl:message>Closing file <xsl:value-of select="$outName"/></xsl:message>
        </xsl:if>
      </xsl:when>
      <xsl:when test="contains($processor,'Apache')">
        <xsl:if test="$verbose='true'">
          <xsl:message>Opening <xsl:value-of select="$outName"/>  with Xalan</xsl:message>
        </xsl:if>
        <xalan:write xmlns:xalan="org.apache.xalan.xslt.extensions.Redirect" xsl:extension-element-prefixes="xalan" file="{$outName}">
          <xsl:copy-of select="$content"/>
        </xalan:write>
        <xsl:if test="$verbose='true'">
          <xsl:message>Closing file <xsl:value-of select="$outName"/></xsl:message>
        </xsl:if>
      </xsl:when>
      
      -->
