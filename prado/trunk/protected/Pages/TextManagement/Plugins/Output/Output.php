<?php

Prado::Using('Application.Engine.*');

/**
 * Gather together files, copy over to Cocoon.
 * 
 * Put together all the files created in this process and pass them to Apache Cocoon.
 * @author Matthew Katsenes
 * @version 0.1 - working, but crudely
 * @package tiro-xml
 * @subpackage connector
 */
class Output extends TPage
{
	/**
	 * array of possible xml files in the text directory (excluding text.xml)
	 *
	 * @var array $ADDENDUM_ARR
	 */
	private $ADDENDUM_ARR = Array('def.xml','notes.xml','images.xml');
	public $text;
	public $tiroText;
	/**
	 * Output DOMDocument
	 *
	 * @var DOMDocument $output
	 */
	public $output;

	/**
	 * Load the text and any addenda into objects
	 */
	function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		
		$this->text = TextRecord::finder()->findById($_GET['id']);
		$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name;
		$final_path = ".";
		$this->tiroText = new TiroText($path);
		
		$this->output = new DomDocument;
		
		$this->output->loadXML($this->tiroText->getXML());
		
		foreach($this->ADDENDUM_ARR as $file)
			if(file_exists($path . '/' . $file))
				$this->processAddendum($path . '/' . $file);
		
		$this->MsgHolder->Controls[] = "Saving to $path/output.xml<br />";
		$this->output->save($path .'/output.xml');
		
		//$success = copy("$path/output.xml","$final_path/output.xml");
		//$this->MsgHolder->Controls[] = "Moving output.xml to $final_path - $success<br />";
		//if($success)
		$this->MsgHolder->Controls[] = "<br/><a href='/output/matt/cicero_pro_milone/text(1)'>output file</a>";
		
//		$this->MsgHolder->Controls[] = $this->output->saveHTML();
	}
	
	/**
	 * Take any addendum xml file and process it into output.xml
	 *
	 * @param string $addendum filename of {@link $ADDENDUM_ARR}[*]
	 */
	function processAddendum($addendum)
	{
		$this->MsgHolder->Controls[] = "Processing addendum: $addendum. <br />";
		
		$addendumDom = new DOMDocument;
		$addendumDom->load($addendum);
		
	//	$this->MsgHolder->Controls[] = $addendumDom->saveHTML();
		
		$addendum_inContext = $this->output->importNode($addendumDom->documentElement,true);
		
		
		$XPath = new DomXPath($this->output);
		$results = $XPath->query('//body');
		$addendee = $results->item($results->length - 1);
		$addendee->appendChild($addendum_inContext);
	}
}
?>