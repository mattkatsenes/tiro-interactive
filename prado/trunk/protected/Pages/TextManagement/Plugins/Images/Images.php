<?php
Prado::Using('Application.Engine.*');

class Images extends TPage
{
	public $text;
	public $tiroText;
	
	function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		
		$this->text = TextRecord::finder()->findById($_GET['id']);
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name);
		
		if(!$this->IsPostBack)
			$this->addText();		
		elseif($_POST['id_text'])
			$this->imageSetup($_POST['id_text']);
		
	}

	function addText()
	{
		$tiroDom = new DomDocument;
		$tiroDom->loadXML($this->tiroText->getText());
		$stylesheet = new DomDocument;
		$stylesheet->load('protected/Pages/TextManagement/Plugins/Images/xsl/tiro2js_tree.xsl');
		
		$proc = new XSLTProcessor;
		$proc->importStylesheet($stylesheet);
		
		$this->TextTree->Controls[] = $proc->transformToXml($tiroDom);

		$this->ImageUploader->ActiveView = $this->SelectTextPortion;
	}
	
	function imageSetup($id_text)
	{
		$tiroDom = new DomDocument;
		$tiroDom->loadXML($this->tiroText->getText());
		
		$XPath = new DomXPath($tiroDom);	
		$noteNode = $XPath->query("//*[@id_text=".substr($id_text,5)."]");
		
		$this->NoteAnchor->Controls[] = $noteNode->item(0)->textContent;
		
		$this->ImageUploader->ActiveView = $this->InsertNote;
	}
	
	function saveImage($sender)
	{
		
		if($sender->HasFile && $sender->FileType == 'image/jpeg')
		{
			global $ABS_PATH,$USERS_PREFIX;

			$sender->saveAs($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name.'/'.$sender->FileName);
			$img = new TImage();
			$img->ImageUrl = "http://localhost/~mkatsenes/workspace/prado/protected/users/matt/arma_virumque/".$sender->FileName;
			
			$this->ImageInfo->Controls[] = $img;
		}
		else
		{
			$this->ImageInfo->Controls[] = "failure.  ".$sender->ErrorCode;
		}
		
		$this->ImageUploader->ActiveView = $this->ImageUploaded;
	}
	
}
?>