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
		$this->tiroText = new TiroText($path);
		
			if(file_exists($path . '/def.xml'))
			{
				$this->localDictionary = new TiroText_addendum($path,'def.xml');
			}
			else
				{
				$this->localDictionary = new TiroText_addendum($path,'def.xml');
				$this->localDictionary->loadTemplate("glossary","entry","link");
				$this->localDictionary->saveText();
				}
	
			//$this->LatinText->Controls[] = $this->innerTextProcessing($myTiroText);
			//$this->LatinText->Controls->add("<br/><br/><br/>");
		if(!$this->IsPostBack)
		{
			$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
		else
		{
			$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
	echo "<a href='/prado/protected/Pages/TextManagement/Plugins/Definitions/def.xml'>def.xml</a>";
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
	
	function defJSONHandler()
	{
     //   $this->myName->Text = $this->defJSON->Value;
        $json = json_decode($this->defJSON->Value,true);
	   
	   //Handles saving 'defined' tag into xml text document
		$myTiroText = new DOMDocument();
			$myTiroText->formatOutput = true;
			$myTiroText->preserveWhiteSpace =true;
		$myTiroText->loadXML($this->tiroText->getText());
		$xpath = new DOMXPath($myTiroText);
			$idvalue = $json['id_text'];
			$entry = $xpath->query("//term[@id_text='$idvalue']");
			if($entry = $entry->item(0))
			{
				$entry->setAttribute('defined','true');
			}
			else
			{
				echo "failure to find //term[@id_text='$idvalue']";
			}
		
		$this->tiroText->setText($myTiroText->getElementsByTagName('text')->item(0));	//Needed instead of ->saveXML() in order to stop <> escaping
		$this->tiroText->saveText();
			$this->LatinText->Controls[0] = $this->innerTextProcessing($this->tiroText);
	   //End defined tag call.
	   
		//This is temporary until the page becomes properly object oriented.
        $xml = base64_decode($json['xml']);
        $xml = gzuncompress($xml);
		//	Test of xml transfer, to be removed.
		//	$this->DefinitionAnchor->Controls[]="<![CDATA[". $xml ."]]>";
			
	$entry = $this->createEntry($xml,$json['userdefinition']);
	$this->localDictionary->insertNode($entry);
	
	$link = $this->createLink($json["lemma"],$json["id_text"]);
	$this->localDictionary->insertNode($link);

	$this->localDictionary->sortNodes("link","@targets");
	$this->localDictionary->sortNodes("entry","@xml:id");
	$this->localDictionary->saveText();
	
	//$this->DefinitionAnchor->Controls[]="<!--<![CDATA[". $this->localDictionary->saveXML() ."]]>-->";
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

		private function createLink($lemma, $id_text)
		{
		//Lemma link creation
		$lemma_link = "#g." . $lemma;
		//
		
		//Position link
		$position_link = "";
			$xpath = new DOMXPath($this->tiroText->getDOMDoc());
				$term = $xpath->query("//term[@id_text = '$id_text']");

			if( $term->length == 1)
				$term = $term->item(0);
			else
				return null;
			
			if( $term->parentNode->nodeName == "l")
				$position_link = $term->parentNode->attributes->getNamedItem('id')->nodeValue;
			else
				return null;
		$position_link = "#" . $position_link . "." . $term->nodeValue;
		//
		
		
		$link_entry =  $this->localDictionary->createElement("link");
		$new_entry = true;
			//Determine if the lemma already has a glossary link in the local_dictionary text
			// if it does, remove that old node, since we are modifying the attributes.
			$dict_xpath = new DOMXPath($this->localDictionary->getDOMDoc());
				$links = $dict_xpath->query("//link");
				foreach($links as $link)
				{
				if($link->attributes->getNamedItem('targets'))
				{
					if( strpos($link->attributes->getNamedItem('targets')->nodeValue,$lemma_link) !== false)
					{
					$new_entry= false;
					$link_entry = $link->parentNode->removeChild($link);		//N.B.  This is NOT HOW THINGS SHOULD BE DONE!! Drew.
					}
				}
				}
			if($new_entry == true)
				$link_entry->setAttribute('targets',$lemma_link);
			//End lemma check
			
			//If lemma has been defined before, check targets attribute to see if our target has been defined before.
			if($new_entry == true)
				{
				$link_entry->attributes->getNamedItem('targets')->nodeValue .= " ". $position_link;
				}
			else
				{	//Check to see if our position is already defined
				$found = false;
					foreach(explode(" ",$link_entry->attributes->getNamedItem('targets')->nodeValue) as $position)
						{
							$position = trim($position);
							if($position == $position_link)
								$found = true;
						}
					if( !$found)
						{
						$link_entry->attributes->getNamedItem('targets')->nodeValue .= " ". $position_link;
						}
					else	{};
				}
			//End target check
			
		//End link_entry creation
		//Note that at this stage, if a <link> containing the same lemma as the given word was in the local dictionary, it no longer is.
		return $link_entry;
		}
		
	function myclick()
	{
	global $ABS_PATH,$USERS_PREFIX;
			$entry_node = $this->localDictionary->createElement('entry');
				$entry_node->setAttribute('xml:id','g.flamer');
				$entry_node->nodeValue = time();
			$entry_node2 = $this->localDictionary->createElement('entry');
				$entry_node2->setAttribute('xml:id','g.flamer-');
				$entry_node2->nodeValue = time();

	$this->localDictionary->insertNode($entry_node);	
	$this->localDictionary->insertNode($entry_node2);
				
	$this->localDictionary->sortNodes("link","@targets");
	$this->localDictionary->sortNodes("entry","@xml:id");
	//$this->localDictionary->saveText();
	$this->localDictionary->loadTemplate("<root/>","entry","link");
	}
		
}

?>