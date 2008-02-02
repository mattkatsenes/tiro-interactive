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
class TiroXMLBase
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
	 * Save text.xml file into memory.
	 */
	public function saveText()
	{
		$this->xml->save($this->xml_file);
	}
	
}
?>