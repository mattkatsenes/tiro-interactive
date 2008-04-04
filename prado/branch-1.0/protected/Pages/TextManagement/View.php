<?php

Prado::Using('Application.Engine.*');

class View extends TPage
{
	public $text;
	public $tiroText;
	
	public function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$this->text = TextRecord::finder()->findByPk($_GET['id']);
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name);
		
		$plugins = new SimpleXMLElement($ABS_PATH . '/protected/Pages/TextManagement/Plugins/RegisteredPlugins.xml', NULL, TRUE);
		
		foreach($plugins->plugin as $plugin)
		{
			$row = new TTableRow;
			$cell = new TTableCell;
			$cell->Text = "<a href=\"" . $this->Application->Request->ApplicationUrl .'/'. $this->text->id .'/'. $plugin->folder . "\">". $plugin->name . "</a>";
			$cell->Style = "border-bottom: 1px solid black; padding: 5px; margin: 0px; border-collapse: collapse;";
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			$cell->Text = $plugin->desc;
			$cell->Style = "border-bottom: 1px solid black; padding: 5px; margin: 0px; border-collapse: collapse;";
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			if($plugin->implemented == 'yes')
			{
				$cell->Text = "Good to go :)";
				$cell->BackColor = "#99FF99";
			}
			else
			{
				$cell->Text = "Almost there!";
				$cell->BackColor = "#FF3333";
			}
			
			$cell->Style = "border-bottom: 1px solid black; padding: 5px; margin: 0px; border-collapse: collapse;";
			$row->Cells->add($cell);
			
			
			
			$this->Plugins->Rows->add($row);
		}
		
		// Display the text at the bottom.
		
		$textDOM = new DomDocument;
		$textDOM->loadXML($this->tiroText->getText());
		
		
		$styleSheet = new DOMDocument;
		$styleSheet->load('protected/Data/tiroText2html_basic.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($styleSheet);

		$this->LatinPreview->Controls->add($proc->transformToXML($textDOM));
	}
}
?>