<?php
/**
 * A class to hold all the necessary information and routines for identifying 
 * manipulating and querying texts on the local perseus server.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-xml
 * @subpackage core
 * @version 0.0 - roughed out
 * 
 */
class PerseusTextBase
{
	/**
	 * @var string The perseus identifying string (e.g. Perseus:text:1999.02.0002)
	 */
	public $perseus_id;
	/**
	 * @var SimpleXMLElement Contains the entire xml of the perseus text.
	 */
	public $xml;
	/**
	 * @var RefsDecl
	 */
	public $refsDecl;

	/**
	 * This will set up everything based on id.
	 */
	public function __construct($id)
	{
		/**
		 * @global string the persesus text directory.
		 */
		global $PERSEUS_TEXTS_DIR;
	
		$this->perseus_id = $id;
		$this->xml = simplexml_load_file($PERSEUS_TEXTS_DIR . 'xmlchunk.jsp?doc=' . $this->perseus_id);
		$this->refsDecl = new RefsDecl($this->xml);
	}

	/**
	 * Build the XPath to find a particular portion of this text.
	 * 
	 * @return An XPath expression to select the requested node.
	 * @param $reference string containing the canonical reference (tricky).
	 */
	private function constructPath($reference)
	{

	}
}
/**
 * A class to hold all perseus queries.
 */
class PerseusQuery
{
	/**
	 *
	 */
	private function getRefsDecl()
	{
		
	}
}

/**
 * A generic RefsDeclaration class.
 */
class RefsDecl
{
	/**
	 * @var array Nested arrays listing all possible queries.   
	 */
	public $declaration;

	/**
 	 * @param $xml SimpleXMLElement containing the whole perseus text.
 	 */
	public function __construct($xml)
	{
		$querystringXPath = "/";
		$depth = 0;
		while($text->teiHeader->encodingDesc->refsDecl->state[$depth]['n'] != 'chunk')
		{
			$querystringXPath .= "/*[@type='" . $text->teiHeader->encodingDesc->refsDecl->state[$depth]['unit'] . "' and @n='1']" ;
			$depth++;
		}
		$querystringXPath .= "/*[@type='" . $text->teiHeader->encodingDesc->refsDecl->state[$depth]['unit'] . "' and @n='1']" ;
		
		$refsDecl = $xml->xpath($querystirngXPath);
	}
}
?>