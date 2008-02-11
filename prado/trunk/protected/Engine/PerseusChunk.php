<?php
/**
 * For use only with the smallest possible perseus text calls.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-xml
 * @subpackage core
 * @version 0.0 - roughed out
 * 
 */
class PerseusChunk
{
	/**
	 * @var string The perseus identifying string (e.g. Perseus:text:1999.02.0002)
	 */
	public $perseus_id;
	public $chunk_string;
	/**
	 * @var SimpleXMLElement Contains the entire xml of the perseus text.
	 */
	public $xml;
	public $dom;
	public $new_dom;
	public $new_xml;

	/**
	 * This will set up everything based on id.
	 */
	public function __construct($id,$chunk)
	{
		/**
		 * @global string the persesus text directory.
		 */
		global $PERSEUS_SERVER;
		
		$this->perseus_id = $id;
		$this->chunk_string = $chunk;
		$this->xml = simplexml_load_file($PERSEUS_SERVER . 'xmlchunk.jsp?doc=' . $this->perseus_id . $chunk);
		$this->dom = dom_import_simplexml($this->xml);
		
		
		// TRY 2, make a whole new XML in a format I can handle.
		$this->new_dom = new DOMDocument();
		$root = $this->new_dom->createElement('tiro');
		$this->new_dom->appendChild($root);
		
		$perseusTag = $this->new_dom->createElement('perseus', $this->perseus_id);
		$root->appendChild($perseusTag);
		$perseusTag->setAttribute('chunk',$this->chunk_string);
		
		$body = $this->dom->getElementsByTagName('body')->item(0);
		
		$textTag = $this->new_dom->createElement('body');
		$root->appendChild($textTag);
		foreach($body->childNodes as $child)
			$this->tagify($child,$chunk . ':word=',$textTag);
	}
	
	public function getXML()
	{
		$this->new_xml = simplexml_import_dom($this->new_dom);
		return print_r($this->new_xml);
	}
	
	public function getDOMBody()
	{
		return $this->new_dom->getElementsByTagName('body')->item(0);
	}
		
	public function tagify($node,$prefix,$appendee)
	{
		if($node->nodeType == XML_TEXT_NODE)
		{
			$text = $node->nodeValue;
			$words = explode(' ',$text);
				
			foreach($words as $word)
				if($word !=' ' && $word != '')
				{
					$entry = $this->new_dom->createElement('entry',$word);
					$appendee->appendChild($entry);
					$entry->setAttribute('xml:id',$prefix . $word);
			 	}
		}
		elseif($node->nodeType == XML_ELEMENT_NODE)
		{
			//Copy the node to our new place to preserve XML structure.
			$imported = $this->new_dom->importNode($node);
			//Where to put it?  Aha! the $apendee
			//BUG the attributes don't come with the node...?
			$appendee = $appendee->appendChild($imported);
			
			//copy the attributes
			foreach($node->attributes as $attribute)
				$appendee->setAttribute($attribute->name, $attribute->value);
			
			foreach($node->childNodes as $child)
				$this->tagify($child,$prefix,$appendee);
		}
	}
}
?>