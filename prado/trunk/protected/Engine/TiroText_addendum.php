<?php
require_once("TiroText.php");
/**
 * Class abstraction for text.xml addendum files
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-xml
 * @subpackage core
 * @version 0.2 - more or less working
 */
class TiroText_addendum extends TiroText{
protected $xpath;
protected $errors;

function __construct($path,$filename = null)
{
	$this->errors = "";

	if($filename != null)
	{
		$this->xml = new DomDocument();
		$this->xml->formatOutput=true;
		$this->xml->preserveWhiteSpace=true;
		
		if(file_exists($path . '/' . $filename))
			{
			$this->xml->load($path . '/' . $filename);
			}
		else
			{
			global $ABS_PATH;
			$this->xml->load($ABS_PATH.'/protected/Data/tiro_default.xml');
			$this->xml->save($path . '/' . $filename);
			}
		$this->xml_file = $path . '/' . $filename;
	}
	else
	{
		parent::__construct($path);
	}
	
	$this->xpath = new DOMXPath($this->xml);
}

function insertNode(DOMNode $newNode, $xpath_query = null, $forceNodeAddition = false)
{
$newNode = $this->xml->importNode($newNode,true);

if($forceNodeAddition == false)
{
	if($xpath_query == null)
	{
		$matches = $this->xpath->query('//'.$newNode->nodeName);
		foreach($matches as $match)
		{
			if( $this->sameDOMAttributes($match, $newNode) )
			{
				$this->errors .= "Matching node found. <{$newNode->nodeName}>{$newNode->nodeValue}</{$newNode->nodeName}> not added. ";
				return false;
			}
			else
			{}
		}
	}
	else
	{
		$matches = $this->xpath->query($xpath_query . $newNode->nodeName);
		foreach($matches as $match)
		{
			if(($match->nodeValue == $newNode->nodeValue) && ($match->attributes === $newNode->attributes))
			{
				$this->errors .= "Matching node found. <{$newNode->nodeName}>{$newNode->nodeValue}</{$newNode->nodeName}> not added. ";
				return false;
			}
			else
			{}
		}	
	}
}
else{}

$parent_node = null;
	if($xpath_query == null)
	{
	$matches = $this->xpath->query('//'.$newNode->nodeName);
		if ($matches->length > 0)
			$parent_node = $matches->item(0)->parentNode;
		else
			return false;
	}
	else
	{
	$matches = $this->xpath->query($xpath_query . $newNode->nodeName);
		if($matches->length > 0)
			$parent_node = $matches->item(0)->parentNode;
		else
		{
			if($forceNodeAddition)
			{
				$xpath_query = implode('/',array_pop(explode('/',$xpath_query)));
				if($xpath_query != null)
					{
					$parent_node = $xpath->query($xpath_query);
					if($parent_node->length > 0)
						$parent_node = $parent_node->item(0);
					else
						return false;
					}
				else
					return false;
			}
			else
				return false;
		}
	}

	$matches = $parent_node->getElementsByTagName($newNode->nodeName);
	if( ($matches->length == 1) && ($matches->item(0)->nodeValue == "") )
		$parent_node->replaceChild($newNode, $matches->item(0));
	else
		$parent_node->appendChild($newNode);

	return true;
}

function sortNodes($element, $key)
{
if(	$element == null	)
		return false;

if(	$key != null	)
	$key = "select='{$key}' ";
		
$xslt_string ="<?xml version='1.0' encoding='utf-8'?>\n
<xsl:stylesheet xmlns:xsl='http://www.w3.org/1999/XSL/Transform' version='1.0' >\n
<xsl:output method='xml' indent='no' encoding='utf-8' />\n
<xsl:template match='@*|node()'>\n
	\n<xsl:copy>\n
		\n<xsl:apply-templates  select='@*|node()'/>\n
	\n</xsl:copy>\n
</xsl:template>\n
<xsl:template match='{$element}/@*|node()'>\n
        \n<xsl:copy>\n
                \n<xsl:apply-templates  select='@*|node()'>\n<xsl:sort {$key} />\n</xsl:apply-templates>\n
        \n</xsl:copy>\n
</xsl:template>\n
</xsl:stylesheet>\n";
//	The sorting XSLT string.
	$xslt_sheet = new DOMDocument();
		$xslt_sheet->formatOutput=true;
		$xslt_sheet->preserveWhiteSpace=true;
	$xslt_sheet->loadXML($xslt_string);
	$proc = new XSLTProcessor();
		$proc->importStyleSheet($xslt_sheet); // attach the xsl rules
		
	$result = $proc->transformToXML($this->xml);
	$result = preg_replace("/(\t)+(\n)/",'',$result);
	$this->xml->loadXML($result);
}

function showXML()
{
return $this->xml;
}


function getDOMDoc()
{
	return $this->xml;
}
function createElement($element, $value=null)
{
	return $this->xml->createElement($element, $value);
}
function importNode($element, $value=false)
{
	return $this->xml->importNode($element, $value);
}

private function sameDOMAttributes(DOMNode $element1, DOMNode $element2)
{
	if($element1->nodeName == $element2->nodeName)
	{
		if($element1->attributes->length == $element2->attributes->length)
		{
		for($i = 0; $i < $element1->attributes->length; $i++)
			{
			if($element1->attributes->item($i)->nodeValue != $element2->attributes->item($i)->nodeValue)
				{
				return false;
				}
			if($element1->attributes->item($i)->nodeName != $element2->attributes->item($i)->nodeName)
				{
				return false;
				}
			}
		}
		else
		{
		return false;
		}
	}
	else
	{
	return false;
	}

return true;	
}

function getErrors()
	{
	$temp = $this->errors;
	$this->errors ="";
	return $temp;
	}
}
?>