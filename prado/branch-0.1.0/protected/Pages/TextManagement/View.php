<?php
class View extends TPage
{
	public $text;
	
	public function onLoad()
	{
		global $ABS_PATH;
		$this->text = TextRecord::finder()->findByPk($_GET['id']);
		$plugins = new SimpleXMLElement($ABS_PATH . '/protected/Pages/TextManagement/Plugins/RegisteredPlugins.xml', NULL, TRUE);
		
		foreach($plugins->plugin as $plugin)
		{
			$row = new TTableRow;
			$cell = new TTableCell;
			$cell->Text = "<a href=\"" . $this->Application->Request->ApplicationUrl .'/'. $this->text->id .'/'. $plugin->folder . "\">". $plugin->name . "</a>";
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			$cell->Text = $plugin->desc;
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			$cell->Text = "not implemented yet";
			$row->Cells->add($cell);
			
			$this->Plugins->Rows->add($row);
		}
	}
}
?>