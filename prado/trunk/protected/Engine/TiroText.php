<?php

/**
 * Class abstraction for text.xml
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-xml
 * @subpackage core
 * @version 0.0 - roughed out
 */
class TiroText
{
	/**
	 * DOMDocument holding the TEI-compliant xml
	 */
	private $xml;

	/**
	 * String for the path to text.xml
	 */	
	public $xml_file;
	
	function __construct($path)
	{
		$this->xml = new DomDocument;
		
		if(file_exists($path . '/text.xml'))
			$this->xml->load($path . '/text.xml');
		else
			$this->xml->save($path . '/text.xml');
		
		$this->xml_file = $path . '/text.xml';
	}
	
	
	/**
	 * Take a {@link PerseusChunk} object and add it to our current TiroText
	 */
	function addPerseusChunk($perseusChunk)
	{
		$newChunk = $this->xml->importNode($perseusChunk->getDOMBody(),true);
		$body = $this->xml->getElementsByTagName('body')->item(0);
		
		$arrayOfGoodies = $this->combineTrees($body,$newChunk,'/');
				
		$XPath = new DOMXPath($this->xml);
		$mountPointDOM = $XPath->query($arrayOfGoodies[0])->item(0);
		foreach($arrayOfGoodies[1]->childNodes as $insertMe)
		{
			$clone = $insertMe->cloneNode(true);
			$mountPointDOM->appendChild($clone);
		}
	}
	
	/**
	 * Combine two XML trees without duplicating bits.
	 * 
	 * body	
	 *  -div1(chapter=1)
	 *   -milestone(section=1)
	 * +
	 * body
	 *  -div1(chapter=1)
	 *   -milestone(section=2)
	 * =
	 * body
	 *  -div1(chapter=1)
	 *   -milestone(section=1)
	 *   -milestone(section=2)
	 * 
	 * @param $recipient is the existing DOMElement body tag.
	 * @param $gift is the DOMElement we're trying to import.  This changes during the recursion.
	 * @param $mountPoint will be an "XPath" query string.
	 * 
	 * @return Array(string $mountPoin",DOMElement $myChildNodesGoHere)
	 */
	function combineTrees($recipient, $gift, $mountPoint)
	{
		/**
		 * @var bool for usage to see $gift exists in the $recipient tree.
		 */
		$sameness = true;
		
		$XPath = new DOMXPath($recipient->ownerDocument);
		$testingXPath = $mountPoint . '/' . $gift->nodeName;
		$XPathMatches = $XPath->query($testingXPath);
		
		/**
		 * If we have no matches, set $sameness to false.
		 */
		if($XPathMatches->length == 0)
			$sameness = false;
		/**
		 * If we have nodes with the same hierarchy in $recipient
		 * ($XPathMatches), check their attributes.  The only 
		 * possibilities represented here are ones in which the 
		 * nodes are the different (thanks, Drew).  Otherwise
		 * $sameness holds as TRUE.
		 */
		foreach($XPathMatches as $possibleMatch)
		{
			/**
			 * Both nodes have attributes
			 */
			if($possibleMatch->hasAttributes() && $gift->hasAttributes() )
			{
				foreach($possibleMatch->attributes as $attribute)
					/**
					 * If they are legitamitely the same, add the Attributes to our XPath,
					 * so we don't get fooled next time down the tree.
					 */
					if($gift->getAttribute($attribute->name) == $attribute->value && $sameness)
						$testingXPath .= "[@$attribute->name = \"$attribute->value\"]";
					else
						$sameness = false;
			}
			/**
			 * One or the other has attributes.. clearly not the same.
			 */
			elseif($possibleMatch->hasAttributes() || $gift->hasAttributes())
				$sameness = false;
		}
		
		/**
		 * If they're the same, RECURSE!!!
		 */
		if($sameness &! $theyHaveDifferentAttributes)
			foreach($gift->childNodes as $giftedChild)
				return $this->combineTrees($recipient, $giftedChild, $testingXPath);
		else
			return Array($mountPoint, $gift->parentNode);
	}
	
	function getXML()
	{
		$temp = simplexml_import_dom($this->xml);
		return $temp->asXML();
	}
	/**
	 * Save text.xml file into memory.
	 */
	public function saveText()
	{
		$this->xml->save($this->xml_file);
	}
	
}
?>