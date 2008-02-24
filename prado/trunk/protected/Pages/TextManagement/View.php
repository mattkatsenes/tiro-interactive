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
			$cell->Text = $plugin->name;
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			$cell->Text = $plugin->desc;
			$row->Cells->add($cell);
			
			$cell = new TTableCell;
			$cell->Text = "not yet";
			$row->Cells->add($cell);
			
			$this->Plugins->Rows->add($row);
		}
	}
}
?>