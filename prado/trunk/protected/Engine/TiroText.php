<?php

/**
 * Class abstraction for text.xml
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-xml
 * @subpackage core
 * @version 0.2 - more or less working
 */
class TiroText
{
	/**
	 * DOMDocument holding the TEI-compliant xml
	 */
	protected $xml;

	/**
	 * String for the path to the XML files.
	 */	
	public $xml_path;
	public $xml_file;
	
	/*
	 * Array holding TiroAnnotation objects.
	 */
	public $annotations;
	
	function __construct($path)
	{
		$this->xml = new DomDocument();
		$this->xml->formatOutput=true;
		$this->xml->preserveWhiteSpace=true;
		
		if(file_exists($path . '/text.xml'))
			$this->xml->load($path . '/text.xml');
		else
		{
			global $ABS_PATH;
			$this->xml->load($ABS_PATH.'/protected/Data/tiro_default.xml');
			$this->xml->save($path . '/text.xml');
		}
		
		$this->xml_path = $path;
		$this->xml_file = $path . '/text.xml';
		
		if(file_exists($path . '/def.xml'))
			$this->loadAnnotations('def.xml');
		if(file_exists($path . '/notes.xml'))
			$this->loadAnnotations('notes.xml');
		if(file_exists($path . '/images.xml'))
			$this->loadAnnotations('images.xml');
		if(file_exists($path . '/hyperlinks.xml'))
			$this->loadAnnotations('hyperlinks.xml');
				
		
//		$this->calculateIDs();
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
		
		$this->calculateIDs();
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
		if($sameness)
			foreach($gift->childNodes as $giftedChild)
				return $this->combineTrees($recipient, $giftedChild, $testingXPath);
		else
			return Array($mountPoint, $gift->parentNode);
	}
	
	/**
	 * Get the entire XML document.
	 */
	function getXML()
	{
		$temp = simplexml_import_dom($this->xml);
		return $temp->asXML();
	}
	
	/**
	 * Get the XML for the text portion only.
	 */	
	function getText()
	{
		$text = $this->xml->getElementsByTagName('text')->item(0);
		$temp = simplexml_import_dom($text);
		return $temp->asXML();
	}

	/*
	 * Get the XML Document with Annotations marked (somehow)
	 */
	function getTextWithAnnotations()
	{
		$text = $this->xml->getElementsByTagName('text')->item(0);
		$XPath = new DomXPath($this->xml);
		$id_elements = $XPath->query('//*[@id_text]');
		
		foreach($id_elements as $elem)
		{
			$annotations = $this->annotationGrab($elem->getAttribute('id_text'));
			foreach($annotations as $annotation)
				$elem->setAttribute('annotation',$elem->getAttribute('annotation').' '.$annotation->type);	
		}
		$temp = simplexml_import_dom($text);
		return $temp->asXML();
	}

	/**
	 * Set the XML for the text portion only.
	 */	
	public function setText($text_node)
	{
	$body_text_node = $this->xml->getElementsByTagName('text')->item(0);
	$body_text_node->parentNode->replaceChild($this->xml->importNode($text_node,true),$body_text_node);
	}
	
	/**
	 * Save text.xml file into memory.
	 */
	public function saveText()
	{
		$this->xml->formatOutput=true;
		$this->xml->preserveWhiteSpace=true;
		$this->xml->save($this->xml_file);
	}
	
	public function calculateIDs()
	{
		$id = 0;
		
		$XPath = new DomXPath($this->xml);
		$IDList = $XPath->query('//text//*/@id_text');
		$ListNoID = $XPath->query('//text//*[not(@id_text)]');
		
		foreach($IDList as $newID)
			if((int)$newID->nodeValue > $id)
				$id = (int)$newID->nodeValue;
		
		foreach($ListNoID as $item)
			if(!$item->hasAttribute('id_text'))
			{
				$item->setAttribute('id_text',$id);
				$id++;
			}
	}

	public function getDOMDoc()
	{
		return $this->xml;
	}

	/*
	 * Get an array of all the ID'd elements.
	 * 
	 * return array $elements =[1,2, ... ,n]
	 */
	public function IDs()
	{
		$elements = array();
			
		$XPath = new DomXPath($this->xml);
		$IDList = $XPath->query('//text//*/@id_text');
		
		foreach($IDList as $newID)
			$elements[] = (int)$newID->nodeValue;
		
		return $elements;
	}
	
	/*
	 * Check out the element with id_text = $id.  Return array of annotations!
	 */
	public function annotationGrab($id)
	{
		$annotation_array = array();
		
		foreach($this->annotations as $annotation)
			if($annotation->belongsTo($id))
				$annotation_array[] = $annotation;
		
		return $annotation_array;
	}

	/*
	 * Load annotations from a particular file.
	 * 
	 * @param string $filename the filename for the *.xml with annotations.
	 */
	public function loadAnnotations($filename)
	{
		$addendum = new DomDocument;
		$addendum->load($this->xml_path .'/'. $filename);
				
		$addendumXPath = new DomXPath($addendum);
		$links = $addendumXPath->query('//link');
		
		foreach($links as $link)
		{
			$targets = $link->getAttribute('targets');
			$target_arr = explode('#',$targets);
			$id = array_shift($target_arr);
			
			$proper_target = '';
			foreach($target_arr as $possible)
				$proper_target .= $possible;

			$this->annotations[] = new TiroAnnotation($id,substr($filename,0,-4),$addendumXPath->query("//*[@id_text = '$id']"),$proper_target);
		}
	}
}
?>