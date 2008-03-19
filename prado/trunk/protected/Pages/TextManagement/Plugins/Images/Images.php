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
		
		$tiroDom = new DomDocument;
		$tiroDom->loadXML($this->tiroText->getText());
		$stylesheet = new DomDocument;
		$stylesheet->load('protected/Pages/TextManagement/Plugins/Images/xsl/tiro2js_tree.xsl');
		
		$proc = new XSLTProcessor;
		$proc->importStylesheet($stylesheet);
		
		$this->TextTree->Controls[] = $proc->transformToXml($tiroDom);
	}
}
?>