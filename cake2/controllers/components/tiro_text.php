<?php
class TiroTextComponent extends Object {
	/**
	 * @var DomDocument holds the xml tree of the main text.
	 */
	private $xml;
	
	var $controller;
	
	/**
	 * ID of the Project containing this TiroText
	 *
	 * @var int
	 */
	var $id;
	
	//called before Controller::beforeFilter()
	function initialize() {

	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
		$this->controller =& $controller;		
	}

	function loadText($id) {
		$this->id = $id;
		$xml_text = $this->controller->Project->read('xml_text',$id);
		
		$this->xml = new DomDocument;
		
		$this->xml->preserveWhiteSpace = false;
		$this->xml->formatOutput = true;
		
		if($xml_text['Project']['xml_text'] == "UNINITIALIZED" || $xml_text['Project']['xml_text'] == "" )
			$this->xml->load(ROOT.DS."tiro_cake".DS."data".DS."tiro_default.xml");
		else
			$this->xml->loadXML($xml_text['Project']['xml_text']);
		
		$XPath = new DomXPath($this->xml);
		$IDElements = $XPath->query('//body//*/[@id]');
		
		// Sets the ID elements so they can be accessed by DomDocument->getElementById()
		foreach($IDElements as $element)
			$element->setIdAttribute('id',true);
	}
	
	/**
	 * Returns the text with HTML markup
	 *
	 * @return string HTML markedup text.
	 */
	function getTextPretty() {
		$stylesheet = new DomDocument;
		$stylesheet->load(ROOT.DS."tiro_cake".DS."data".DS."xsl".DS."tiro2TextPretty.xsl");
		
		$proc = new XSLTProcessor();
		$proc->importStylesheet($stylesheet);
		
		return $proc->transformToXml($this->xml);
	}
	
	/**
	 * Returns the text without HTML markup
	 *
	 * @return string plain text.
	 */
	function getTextPlain() {
		$stylesheet = new DomDocument;
		$stylesheet->load(ROOT.DS."tiro_cake".DS."data".DS."xsl".DS."tiro2TextPlain.xsl");
		
		$proc = new XSLTProcessor();
		$proc->importStylesheet($stylesheet);
		
		return $proc->transformToXml($this->xml);
	}
	
	/**
	 * Get an array of plain-text sections
	 *
	 * @return array Sections
	 */
	function getSectionsPlain() {
		$div_list = array();
		$body = $this->xml->getElementsByTagName('body')->item(0);
		
		$stylesheet = new DomDocument;
		$stylesheet->load(ROOT.DS."tiro_cake".DS."data".DS."xsl".DS."tiro2TextPlain.xsl");

		$proc = new XSLTProcessor();
		$proc->importStylesheet($stylesheet);
			
		foreach($body->childNodes as $div) {
			$div_list[$div->getAttribute('id')] = $proc->transformToDoc($div)->saveHTML();
		}
		
		return $div_list;
	}
	
	function getXML() {
		$this->xml->preserveWhiteSpace = false;
		$this->xml->formatOutput = true;
		$xml_text = $this->xml->saveXML();
		return $xml_text;
	}
	
	/**
	 * Set the title and editor in the teiHeader portion of the text
	 *
	 * @param string $title
	 * @param string $editor the User's name
	 */
	function titleEditorSet($title,$editor)
	{
		$titleStmt = $this->xml->getElementsByTagName('titleStmt')->item(0);

		$titleNodeOld = $this->xml->getElementsByTagName('title')->item(0);
		$titleNodeNew = $this->xml->createElement('title',$title);

		$titleStmt->replaceChild($titleNodeNew,$titleNodeOld);
		
		$respStmtNode = $this->xml->createElement('respStmt');
		$respStmtNode->appendChild($this->xml->createElement('resp','Creation and digitization of the notes and vocabulary.'));
		$respStmtNode->appendChild($this->xml->createElement('name',$editor));
		
		$respStmtNodeOld = $titleStmt->getElementsByTagName('respStmt')->item(0);
		
		$titleStmt->replaceChild($respStmtNode,$respStmtNodeOld);		
	}

	/**
	 * Remove a section of text.
	 *
	 * @param string $id
	 */
	function deleteSection ($id) {
		// Add a new <div> to the <body>
		$body = $this->xml->getElementsByTagName('body')->item(0);

		// For later!
//		$section = $this->xml->getElementById($id);
		
		$XPath = new DomXPath($this->xml);
		$section = $XPath->query("//body//div[@id = $id]")->item(0);
		
//		$section = $this->xml->getElementsByTagName('div')->item(0);

		$section->parentNode->removeChild($section);
	}
	
	function getSection ($id) {
		$section = $this->xml->getElementById($id);
//		$section  = $this->xml->getElementsByTagName('div')->item(0);
		
		$stylesheet = new DomDocument;
		$stylesheet->load(ROOT.DS."tiro_cake".DS."data".DS."xsl".DS."tiro2TextPlain.xsl");

		$proc = new XSLTProcessor();
		$proc->importStylesheet($stylesheet);
		
		return trim($proc->transformToDoc($section)->saveHTML());
	}
	
	/**
	 * Take raw text, parse it into XML, save it in the DB.
	 *
	 * @todo Make this thing work!!
	 * @param string $text
	 * 
	 * @return string id of the new <div>
	 */
	function addRawText($text) {
		// Add a new <div> to the <body>
		$body = $this->xml->getElementsByTagName('body')->item(0);
		
		$newDiv = $this->xml->createElement('div');

		// bust the input up by carriage returns.
		$lineBreaks = explode("\n",$text);
		
		foreach($lineBreaks as $line) {
//			if($line != '') {
				$line_tag = $this->xml->createElement('l');
			
				// bust each line into words (words may include punctuation at the end.
				$words = explode(' ',$line);
			
				foreach($words as $word) {
					$word = trim($word);
					if($word != '') {
						$term = $this->xml->createElement('term',$word);
						$line_tag->appendChild($term);	
					}
				}
			$newDiv->appendChild($line_tag);				
//			}
		}
		$body->appendChild($newDiv);
		$this->save();
		
		return $newDiv->getAttribute('id');
	}
		
	/**
	 * Saves changes made to the TiroText.
	 * 
	 * Fails if $this->id is not set.
	 */
	function save() {
		if(empty($this->id))
			$this->cakeError('',array('oops you haven\'t initialized the thingy yet.'));
		
		$this->assignIds();
		
		$project = $this->controller->Project->read(null,$this->id);
		$project['Project']['xml_text'] = $this->getXML();
		
		return $this->controller->Project->save($project);
	}
	
	/**
	 * Assigns xml:id attributes to every element in the document.
	 */
	function assignIds () {
		$id = 0;
		
		$XPath = new DomXPath($this->xml);
		$IDList = $XPath->query('//body//*/@id');
		$ListNoID = $XPath->query('//body//*[not(@id)]');
		
		foreach($IDList as $newID)
			if((int)$newID->nodeValue > $id)
				$id = (int)$newID->nodeValue;
		
		foreach($ListNoID as $item)
			if(!$item->hasAttribute('id')) {
				$item->setAttribute('id',$id);
				$item->setIdAttribute('id',true);
				$id++;
			}		
	}
}
?>
