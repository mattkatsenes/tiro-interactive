<?php

/**
 * Get the TiroText class (and the rest of that directory) involved.
 */
prado::Using('Application.Engine.*');

class Notes extends TPage
{


public 		$tiroText;
private 	$localNotes;

	/**
	 * This runs as soon as the page loads.
	 * 
	 * The class constructor is gobbled up by the "TPage" class, but it
	 * calls this baby, so fo our purposes, this is equivalent.
	 */
function onLoad()
	{
	global $ABS_PATH,$USERS_PREFIX;

			if(file_exists($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Notes/notes.xml'))
			{
				$this->localNotes = new TiroText_addendum($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Notes','notes.xml');
			}
			else
			{
				$this->localNotes = new TiroText_addendum($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Notes','notes.xml');
				$this->localNotes->loadTemplate("notes","note","link");
				$this->localNotes->saveText();
			}
	
			$dbRecord = TextRecord::finder()->findByPk($_GET['id']);
			$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name;
			$myTiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name);
			$this->LatinText->Controls[] = $this->innerTextProcessing($myTiroText);
			
			$this->LatinText->Controls->add("<br/><br/><br/>");
		if(!$this->IsPostBack)
		{
			$this->tiroText = new TiroText($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Definitions/');
			$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
		else
		{
			$this->tiroText = new TiroText($ABS_PATH.'/'.'protected/Pages/TextManagement/Plugins/Definitions/');
			$this->LatinText->Controls->add($this->innerTextProcessing($this->tiroText));
		}
	echo "<a href='/prado/protected/Pages/TextManagement/Plugins/Notes/notes.xml'>notes.xml</a>";
}

function innerTextProcessing(TiroText $textObject)
{
	$textXML = new DOMDocument();
			$textXML->formatOutput = true;
			$textXML->preserveWhiteSpace =true;
	$textXML->loadXML($textObject->getText());
	
	$textToHtmlSheet = new DOMDocument();
		$textToHtmlSheet->load('protected/Pages/TextManagement/Plugins/Definitions/tirotext_to_html.xsl');
	$proc = new XSLTProcessor;
		$proc->importStyleSheet($textToHtmlSheet); // attach the xsl rules
	
	return $proc->transformToXML($textXML);
}

function noteHandler()
{
$note_value 		= $this->NotesAnchor->getText();
$note_word_id		= $this->notesJSON->Value;

	   //Handles saving 'noted' tag into xml text document
		$myTiroText = new DOMDocument();
			$myTiroText->formatOutput = true;
			$myTiroText->preserveWhiteSpace =true;
		$myTiroText->loadXML($this->tiroText->getText());
		$xpath = new DOMXPath($myTiroText);
			$idvalue = $note_word_id;
			$note = $xpath->query("//term[@id_text='$idvalue']");
			if($note = $note->item(0))
			{
				$note->setAttribute('noted','true');
			}
			else
			{
				echo "failure to find //term[@id_text='$idvalue']";
			}
		
		$this->tiroText->setText($myTiroText->getElementsByTagName('text')->item(0));	//Needed instead of ->saveXML() in order to stop <> escaping
		$this->tiroText->saveText();
			$this->LatinText->Controls[2] = $this->innerTextProcessing($this->tiroText);
	   //End noted tag call.

	$note = $this->createNote($note_word_id, $note_value);
	$this->localNotes->insertNode($note);
	echo "<pre>" .htmlentities($this->localNotes->errors) ."</pre>";
	$link = $this->createLink($note_word_id);
	$this->localNotes->insertNode($link);
echo "<pre>" .htmlentities($this->localNotes->errors) ."</pre>";
	$this->localNotes->sortNodes("link","@targets");
	$this->localNotes->sortNodes("note","@xml:id");
	echo "<pre>" .htmlentities($this->localNotes->getDOMDoc()->saveXML()) ."</pre>";
	$this->localNotes->saveText();   
}

private function createNote($id_text, $value)
{
	//Get Note-term parent line
	$parent_line = "";
			$xpath = new DOMXPath($this->tiroText->getDOMDoc());
				$term = $xpath->query("//term[@id_text = '$id_text']");

			if( $term->length == 1)
				$term = $term->item(0);
			else
				return null;
			
			if( $term->parentNode->nodeName == "l")
				$parent_line = $term->parentNode->attributes->getNamedItem('id')->nodeValue;
			else
				return null;
	//
	
	//Remove previous instance of note, but keep nodeValue
	$previous_node = null;
		$notexpath = new DOMXPath($this->localNotes->getDOMDoc());
		$previous_node = $notexpath->query("//note[@xml:id='$parent_line']");
			echo $previous_node->length;
			if ($previous_node->length == 1) 
				{
				$previous_node = $previous_node->item(0);
				$previous_node = $previous_node->parentNode->removeChild($previousNode);
				}
			else
				$previous_node = null;
	//
	
	//
	$note_node = $this->localNotes->createElement("note");
		$note_node->setAttribute("anchored", "false");
		$note_node->setAttribute("place", "foot");
		$note_node->setAttribute("type", "editorial");
	$note_node->setAttribute("xml:id", $parent_line.".n");
	$note_node->setAttribute("target","#".$parent_line);
		if($previous_node != null)
			$note_node->nodeValue = $previous_node->nodeValue;
	$note_node->nodeValue .= $value;
	
echo "-" . $parent_line . "-";
return $note_node;
}

private function createLink($id_text)
	{
	//Get Note-term parent line
	$parent_line = "";
			$xpath = new DOMXPath($this->tiroText->getDOMDoc());
				$term = $xpath->query("//term[@id_text = '$id_text']");

			if( $term->length == 1)
				$term = $term->item(0);
			else
				return null;
			
			if( $term->parentNode->nodeName == "l")
				$parent_line = $term->parentNode->attributes->getNamedItem('id')->nodeValue;
			else
				return null;
	//		
		
	$link_node = $this->localNotes->createElement("link");
		$link_node->setAttribute("targets","#$parent_line #$parent_line.n");
		
	return $link_node;
	}

}
?>