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

			$this->localDictionary = new DOMDocument();
				$this->localDictionary->formatOutput = true;
			$this->localDictionary->loadXML('<div n="glossary" />');
	
			$dbRecord = TextRecord::finder()->findByPk($_GET['id']);
			$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name;
			$myTiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name);
			$this->LatinText->Controls[] = $this->innerTextProcessing($myTiroText);
			
			$this->LatinText->Controls->add("<br/><br/><br/>");
		if(!$this->IsPostBack)
		{
			$this->tiroText = new TiroText($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Definitions');
			$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
		else
		{
			$this->tiroText = new TiroText($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Definitions');
			//$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
		
	}
	
	/**
	 * 
	 * 
	 /'.'protected/Pages/TextManagement/Plugins/Definitions');
			$this->LatinText->Controls->add($this->innerTe* 
	 * 
	 */
	function innerTextProcessing(TiroText $textObject)
	{
	$textXML = new DOMDocument();
			$textXML->formatOutput = true;
			$textXML->preserveWhiteSpace =true;
	$textXML->loadXML($textObject->getText());

/*	
	$textToHtmlSheet = new DOMDocument();
		$textToHtmlSheet->load('protected/Pages/TextManagement/Plugins/Definitions/tirotext_label.xsl');
	$proc = new XSLTProcessor();
		$proc->importStyleSheet($textToHtmlSheet); // attach the xsl rules
	$textXML->loadXML($proc->transformToXML($textXML));	
*/
	
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
	   
	   //Handles saving 'defined' tag into xml text document
		$myTiroText = new DOMDocument();
			$myTiroText->formatOutput = true;
			$myTiroText->preserveWhiteSpace =true;
		$myTiroText->loadXML($this->tiroText->getText());
		$xpath = new DOMXPath($myTiroText);
			$idvalue = $json['id_text'];
			$entry = $xpath->query("//term[@id-text='$idvalue']");
			$entry = $entry->item(0);
		$entry->setAttribute('defined','true');
		
		$this->tiroText->setText($myTiroText->getElementsByTagName('text')->item(0));	//Needed instead of ->saveXML() in order to stop <> escaping
		$this->tiroText->saveText();
			$this->LatinText->Controls[2] = $this->innerTextProcessing($this->tiroText);
	   //End defined tag call.
	   
		//This is temporary until the page becomes properly object oriented.
        $xml = base64_decode($json['xml']);
        $xml = gzuncompress($xml);
		//	Test of xml transfer, to be removed.
		//	$this->DefinitionAnchor->Controls[]="<![CDATA[". $xml ."]]>";
			
	$entry = $this->createEntry($xml,$json['userdefinition']);
	$this->localDictionary->firstChild->appendChild($entry);
		
	$this->DefinitionAnchor->Controls[]="<![CDATA[". $this->localDictionary->saveXML() ."]]>";
	}

		private function createEntry($entryXML, $userdefinition)
		{
			$sourceXML 		= new DOMDocument();
			$sourceXML->loadXML($entryXML);
				$xpath = new DOMXPath($sourceXML);
			
			$entry = $this->localDictionary->createElement('entry');
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
						if(!isset($itype))
							{
							$itype = $sourceXML->createElement('itype');
							$itype->nodeValue = "-";
							}
					$orth->nodeValue = trim($orth->nodeValue) . ", " . trim($itype->nodeValue);
					$entry->appendChild($this->localDictionary->importNode($form,true));
					//
					
					//
					$gramGrp = $this->localDictionary->createElement('gramGrp');
					$gramSubs = $xpath->query('//Definition/entry/gramGrp/gen');	
						for($i=0; $i < $gramSubs->length; $i++)
							$gramGrp->appendChild($this->localDictionary->importNode($gramSubs->item($i),true));
					$gramPos = $xpath->query('//Definition/morphAnalysis')->item(0);
					$gramPos = explode(' ',$gramPos->nodeValue);
					$gramPos = $gramPos[0];
						$gramPosNode = $this->localDictionary->createElement('pos');
						$gramPosNode->nodeValue = trim($gramPos);
					$gramGrp->appendChild($gramPosNode);
					$entry->appendChild($gramGrp);			
					//
					
					$definitionNode = $this->localDictionary->createElement('def');
					$definitionNode->nodeValue = trim($userdefinition);
						$entry->appendChild($definitionNode);
				
			return $entry;
		}

	function myclick()
	{
	$this->setViewState('tiro','gg');
	}
		
}

?>