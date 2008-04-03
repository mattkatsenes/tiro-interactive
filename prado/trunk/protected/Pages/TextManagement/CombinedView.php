<?php

Prado::Using('Application.Engine.*');

class CombinedView extends TPage
{
	public $text;
	public $tiroText;

	public function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$this->text = TextRecord::finder()->findByPk($_GET['id']);
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name);

		// Display the text at the bottom.

		$textDOM = new DomDocument;
		$textDOM->loadXML($this->tiroText->getText());


		$styleSheet = new DOMDocument;
		$styleSheet->load('protected/Data/xsl/tiro2js_tree.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($styleSheet);

		$this->LatinPreview->Controls->add($proc->transformToXML($textDOM));
	}
}
?>