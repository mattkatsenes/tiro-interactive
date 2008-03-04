<?php
/**
 * Get the TiroText class (and the rest of that directory) involved.
 */
prado::Using('Application.Engine.*');

class Definitions extends TPage
{

	public $tiroText;
	private $localDictionary;

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
	$proc = new XSLTProcessor();
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

        $json = json_decode($this->defJSON->Value,true);

        $xml = base64_decode($json['xml']);
        $xml = gzuncompress($xml);
        
	//	Test of xml transfer, to be removed.
	//	$this->DefinitionAnchor->Controls[]="<![CDATA[". $xml ."]]>";
	$localDictionary = new DOMDocument();
	$localDictionary->loadXML('<div n="glossary" />');
	
	$sourceXML 		= new DOMDocument();
	$sourceXML->loadXML($xml);
		$xpath = new DOMXPath($sourceXML);
	
		$entry = $localDictionary->createElement('entry');
			//
			$lemma = $xpath->query('//Definition/@lemma')->item(0);
			$entry->setAttribute('xml:id','g.' . $lemma->value);
			//
			//
			$key = $xpath->query('//Definition/entry/@key')->item(0);
			$entry->setAttribute('els_key', $key->value);
			//
			//
			$form = $xpath->query('//Definition/entry/form')->item(0);
			$orth = $form->getElementsByTagName('orth')->item(0);
				$itype = $xpath->query('//Definition/entry/gramGrp/itype')->item(0);
			$orth->nodeValue = trim($orth->nodeValue) . ", " . trim($itype->nodeValue);
			$entry->appendChild($localDictionary->importNode($form,true));
			//
			//
			$gramGrp = $localDictionary->createElement('gramGrp');
			$gramSubs = $xpath->query('//Definition/entry/gramGrp/gen');	
				for($i=0; $i < $gramSubs->length; $i++)
					$gramGrp->appendChild($localDictionary->importNode($gramSubs->item($i),true));
			$gramPos = $xpath->query('//Definition/morphAnalysis')->item(0);
			$gramPos = explode(' ',$gramPos->nodeValue);
			$gramPos = $gramPos[0];
				$gramPosNode = $localDictionary->createElement('pos');
				$gramPosNode->nodeValue = trim($gramPos);
			$gramGrp->appendChild($gramPosNode);
			$entry->appendChild($gramGrp);			
			//
	
	$definitionNode = $localDictionary->createElement('def');
	$definitionNode->nodeValue = trim($json['userdefinition']);
	$entry->appendChild($definitionNode);
	$localDictionary->appendChild($entry);
	
	$this->DefinitionAnchor->Controls[]="<![CDATA[". $localDictionary->saveXML() ."]]>";
	}
}

?>