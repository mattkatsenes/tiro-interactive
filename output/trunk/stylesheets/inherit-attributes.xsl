<?xml version="1.0" encoding="iso-8859-1"?>

<!--
 * jfor - Open-Source XSL-FO to RTF converter - more info at www.jfor.org
 *
 * ====================================================================
 * jfor Apache-Style Software License.
 * Copyright (c) 2002 by the jfor project. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in
 * the documentation and/or other materials provided with the
 * distribution.
 *
 * 3. The end-user documentation included with the redistribution,
 * if any, must include the following acknowledgment:
 * "This product includes software developed
 * by the jfor project (http://www.jfor.org)."
 * Alternately, this acknowledgment may appear in the software itself,
 * if and wherever such third-party acknowledgments normally appear.
 *
 * 4. The name "jfor" must not be used to endorse
 * or promote products derived from this software without prior written
 * permission.  For written permission, please contact info@jfor.org.
 *
 * 5. Products derived from this software may not be called "jfor",
 * nor may "jfor" appear in their name, without prior written
 * permission of info@jfor.org.
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESSED OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED.  IN NO EVENT SHALL THE JFOR PROJECT OR ITS CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR
 * BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * ====================================================================
 * Contributor(s):
 *  @author Bertrand Delacretaz bdelacretaz@codeconsult.ch
-->

<!-- 
  Post-process XSL-FO documents before converting them with jfor,
  to implement simple inheritance of XSL-FO attributes (fonts, sizes, etc.),
  for example from enclosing fo:blocks to fo:inline.
  
  Does not implement the actual XSL-FO inheritance rules, only a very simplified
  version of them.
  
  Can be used to process standard XSL-FO documents to work around jfor's lack of
  attributes inheritance.
-->

<!--
$Id: inherit-attributes.xsl,v 1.3 2002/07/30 15:57:22 bdelacretaz Exp $
$Log: inherit-attributes.xsl,v $
Revision 1.3  2002/07/30 15:57:22  bdelacretaz
inherit-attributes debug block bug corrected

Revision 1.2  2002/07/12 15:18:44  rmarra
skip "keep-together" attribute

Revision 1.1  2002/07/12 14:32:29  bdelacretaz
inherit-attributes.xsl and related tests added
 
 -->

<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:fo="http://www.w3.org/1999/XSL/Format"
>

<xsl:output
    version="1.1"
    method="xml"
    omit-xml-declaration="no"
    encoding="iso-8859-1"
    indent="yes"
/>

<!-- set this to a non-empty value to activate debugging -->
<xsl:param name="debug"/>

<!-- tell them what we're doing -->
<xsl:template match="/">
    <xsl:comment>
        This document was processed by the jfor inherit-attributes.xsl transform,
        to work around the fact that jfor does not implement proper inheritance of
        XSL-FO properties.
        This processing copies all attributes from parent to children elements,
        which generates a lot of superfluous attributes on the XSL-FO elements.
        This is not a problem with jfor but this document might not be accepted by other
        XSL-FO processors - use this XSLT transform with jfor only.
    </xsl:comment>
    <xsl:apply-templates/>
</xsl:template>

<!-- Recursive copy, copying most attributes from all ancestors, overridden by our attributes -->  
<xsl:template match="*" name="copy">
    <xsl:param name="toAdd"/>
    <xsl:copy>
        <xsl:copy-of select="ancestor::*/@*[not(
            name()='break-before' 
            or name()='start-indent' 
            or name()='keep-together'
            or name()='flow-name'
            or name()='master-name'
		  	
			or name()='class' 
			or name()='id'
			or name()='writing-mode'
			or name()='hyphenate'
			or name()='text-align'
			or name()='master-reference'
			or name()='space-after'
			or name()='space-before'
			or name()='column-width'
			or name()='width'
			or name()='table-layout'
			or name()='column-number'			
        )]"/>
	   <!--Exclude additional attributes that should not get passed to children -Drew - 11/30/07
		or name()="class/id/ writing-mode/hyphenate/text-align/master-reference";
		-->
        <xsl:copy-of select="@*"/>
        
        <xsl:if test="$toAdd">
            <xsl:copy-of select="$toAdd"/>
        </xsl:if>
        <xsl:apply-templates/>
    </xsl:copy>
</xsl:template>

<!-- in debug mode, add mention that this was called -->
<xsl:template match="fo:flow[contains(@flow-name,'body')]">
    <xsl:variable name="toAdd">
        <xsl:if test="$debug">
            <fo:block font-size="8pt" color="red">
                NOTE: The XSL-FO of this document was processed by inherit-attributes.xsl (from the jfor
                samples directory) before converting to RTF. Direct conversion to RTF might give different
                results.
            </fo:block>
        </xsl:if>
    </xsl:variable>
    <xsl:call-template name="copy">
        <xsl:with-param name="toAdd" select="$toAdd"/>
    </xsl:call-template>
</xsl:template>

</xsl:stylesheet>