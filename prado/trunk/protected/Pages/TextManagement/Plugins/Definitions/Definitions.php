<?php
/**
 * Get the TiroText class (and the rest of that directory) involved.
 */
prado::Using('Application.Engine.*');

class Definitions extends TPage
{

	public $tiroText;

	/**
	 * This runs as soon as the page loads.
	 * 
	 * The class constructor is gobbled up by the "TPage" class, but it
	 * calls this baby, so fo our purposes, this is equivalent.
	 */
	function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$dbRecord = TextRecord::finder()->findByPk($_GET['id']);
		$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name;
		$myTiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name);
		$this->LatinText->Controls[] = $this->innerTextProcessing($myTiroText);
	}

	/**
	 * 
	 * 
	 * 
	 * 
	 */
	function innerTextProcessing(TiroText $textObject)
	{
	$textXML = new DOMDocument();
			$textXML->formatOutput = true;
			$textXML->preserveWhiteSpace =true;
	$textXML->loadXML($textObject->getText());
	
	$textToHtmlSheet = new DOMDocument();
		$textToHtmlSheet->load('protected/Pages/TextManagement/Plugins/Definitions/tirotext_label.xsl');
	$proc = new XSLTProcessor;
		$proc->importStyleSheet($textToHtmlSheet); // attach the xsl rules
	$textXML->loadXML($proc->transformToXML($textXML));	
	
	$textToHtmlSheet = new DOMDocument();
		$textToHtmlSheet->load('protected/Pages/TextManagement/Plugins/Definitions/tirotext_to_html.xsl');
	$proc = new XSLTProcessor;
		$proc->importStyleSheet($textToHtmlSheet); // attach the xsl rules
	
	return $proc->transformToXML($textXML);
	}
	
	function Load()
	{
	
	$this->myName->Text = $this->User->Name;
	
	}

	function defJSONHandler()
	{
	$this->myName->Text = $this->defJSON->Value;	
	}
	
}
?>