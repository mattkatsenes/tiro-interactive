<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:page="http://apache.org/cocoon/paginate/1.0">
	
	<xsl:variable name="hash">
		<xsl:text>#</xsl:text>
	</xsl:variable>

<!-- Stick the CSS include in! -->
	<xsl:template name="includeCSS">
		<link type="text/css" rel="stylesheet" href="/output/stylesheets/output-pharr.css" />
	</xsl:template>

<!-- Stick the Java includes in! -->
	<xsl:template name="includeJava">
		<script src="/output/js/prototype.js" type="text/javascript"></script>
		<script src="/output/js/test.js" type="text/javascript"></script>
		<script src="/output/js/scriptaculous.js" type="text/javascript"></script>
	</xsl:template>

<!-- Title and Author Stuff -->
	<xsl:template name="title_author">
		<div id="title">
			<xsl:value-of select="$title" />
		</div>
		<div id="author">ed. <xsl:value-of select="$editor" />;
		<span style="display: none" id="page-lines"> Lines: <span class="line-index" id="start-line"><xsl:value-of select="$startLine"/></span>-<span class="line-index" id="end-line"><xsl:value-of select="$lastLine"/></span></span>
		</div>
	</xsl:template>

<!-- Misc. -->
	<xsl:template match="head">
	
	</xsl:template>
<!-- Lines -->
	<xsl:template match="l">
		<xsl:if test="@n mod 5 = 0">
			<span class="line_number">
				<xsl:value-of select="@n" />
			</span>
		</xsl:if>
		<span class="l">
			<xsl:apply-templates/>
		</span>
		<br />
	</xsl:template>

<!-- Line Groups -->
	<xsl:template match="lg">
		<div class="lg">
			<xsl:apply-templates />
		</div>
	</xsl:template>
	<xsl:template match="sp">
		<xsl:if test="child::*">
			<xsl:variable name="speaker_id">
				<xsl:value-of select="substring-after(@who,'#')"/>
			</xsl:variable>
			<xsl:variable name="speaker_name">
				<xsl:value-of select="//role[@id_text=$speaker_id]"/>
			</xsl:variable>
			<span class="speaker">
				<xsl:value-of select="$speaker_name"/>
			</span>
			<br />
			<div class="lg">
				<xsl:apply-templates />
			</div>
		</xsl:if>
	</xsl:template>


<!-- Glossed Terms -->
	<xsl:template match="term">
		<xsl:variable name="ident">
			<xsl:value-of select="@id_text" />
		</xsl:variable>
		
		<xsl:variable name="def_ident">
			<xsl:call-template name="match_def">
				<xsl:with-param name="term_ident">
					<xsl:value-of select="$ident"/>
				</xsl:with-param>
			</xsl:call-template>
		</xsl:variable>
		
		<xsl:choose>
			<xsl:when test="$def_ident != 'g.'">
				<span class="defined_term" id="{$ident}" def_id="{$def_ident}">
					<xsl:apply-templates />
				</span>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates />
			</xsl:otherwise>
		</xsl:choose>
		<xsl:text> </xsl:text>
	</xsl:template>
	
	<xsl:template name="match_def">
		<xsl:param name="term_ident" />
		<xsl:variable name="link_string">
			<xsl:value-of select="//attribute::targets[substring-after(.,' #') = $term_ident]" />
		</xsl:variable>
		
		<xsl:variable name="def_ident_num">
			<xsl:value-of select="substring-after(substring-before($link_string,concat(' #',$term_ident)),'#g.')" />
		</xsl:variable>
		
		<xsl:choose>			
			<!-- Has more than one term per entry NOT WORKING -->
			<xsl:when test="contains($def_ident_num,'#I.')">
				<xsl:text>g.</xsl:text><xsl:value-of select="substring-before($def_ident_num,' #I.')" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>g.</xsl:text><xsl:value-of select="$def_ident_num" />
			</xsl:otherwise>
		</xsl:choose>
		
		
	</xsl:template>
	
	<xsl:template name="entry" match="entry">
		<xsl:variable name="ident">
			<xsl:value-of select="@id_text" />
		</xsl:variable>
		<xsl:variable name="term_numbers">
			<xsl:call-template name="match_terms">
				<xsl:with-param name="g_ident">
					<xsl:value-of select="$ident" />
				</xsl:with-param>
			</xsl:call-template>
		</xsl:variable>
		
		<xsl:if test="//term[@id_text = $term_numbers]">
		
			<span class="entry" id="{$ident}" term_numbers="{$term_numbers}">
				<xsl:apply-templates />
			</span>
		
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="match_terms">
		<xsl:param name="g_ident" />
		<xsl:variable name="link_string">
			<xsl:value-of select="//attribute::targets[contains(.,$g_ident)]" />
		</xsl:variable>
		
		<xsl:value-of select="substring-after($link_string,' #' )" />
	
	</xsl:template>
	
	<xsl:template match="form/orth">
		<span class="headword">
			<xsl:apply-templates />
		</span>
	</xsl:template>
	<xsl:template match="gramGrp/pos">
		<span class="part_of_speech">
			<xsl:apply-templates />
		</span>
	</xsl:template>
	<xsl:template match="def">
		<span class="definition">
			<xsl:apply-templates />
		</span>
		<br />
	</xsl:template>

<!-- Notes -->
	<xsl:template match="note">
		<xsl:variable name="target">
			<xsl:value-of select="@target" />
		</xsl:variable>
		<xsl:variable name="target_number">
			<xsl:value-of select="number(substring-after($target,'#'))" />
		</xsl:variable>
		
		<xsl:if test="//*[contains(@id_text,$target_number)]">
		
			<div class="note" id="{$target_number}">
				<span class="note_number">
					<xsl:text>*</xsl:text>
				</span>
				<xsl:apply-templates />
			</div>
		
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="foreign">
		<xsl:choose>
			<xsl:when test="@rend">
				<xsl:call-template name="rend">
					<xsl:with-param name="style">
						<xsl:value-of select="@rand" />
					</xsl:with-param>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="rend">
					<xsl:with-param name="style">
						<xsl:text>italics</xsl:text>
					</xsl:with-param>
				</xsl:call-template>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="hi">
		<xsl:choose>
			<xsl:when test="@rend">
				<xsl:call-template name="rend">
					<xsl:with-param name="style">
						<xsl:value-of select="@rand" />
					</xsl:with-param>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="rend">
					<xsl:with-param name="style">
						<xsl:text>italics</xsl:text>
					</xsl:with-param>
				</xsl:call-template>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template name="rend">
		<xsl:param name="style">italics</xsl:param>
		
		<xsl:choose>
			<xsl:when test="$style='italics'">
				<i>
					<xsl:apply-templates />
				</i>
			</xsl:when>
			
			<xsl:when test="$style='bold'">
				<b>
					<xsl:apply-templates />
				</b>
			</xsl:when>
			
			<xsl:otherwise>
				<i>
					<xsl:apply-templates />
				</i>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template name="paginate" match="page:page">
		<xsl:if test="@total &gt; 1">
			<!-- page navigation table -->
			<table border="0">
				<tr>
					<!-- td prev -->
					<td align="right">
						<xsl:if test="page:link[@type='prev']">
							<xsl:variable name="previous" select="@current - 1"/>
							<a href="{page:link[@page = $previous]/@uri}"> prev</a>
						</xsl:if>
					</td>

					<!-- td current -->
					<td align="center">
						[page <span class="pagination" id="current-page"><xsl:value-of select="@current"/></span> of <span class="pagination" id="total-pages"><xsl:value-of select="@total"/></span>]
					</td>

					<!-- td next -->
					<td align="left">
						<xsl:if test="page:link[@type='next']">
							<xsl:variable name="next" select="@current + 1"/>
							<a href="{page:link[@page = $next]/@uri}">next</a>
						</xsl:if>
					</td>
				</tr>
			</table>
		</xsl:if>
	</xsl:template>


</xsl:stylesheet>
