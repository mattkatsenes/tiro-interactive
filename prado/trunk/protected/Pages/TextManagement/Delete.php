<?php
class Delete extends TPage
{
	public $text;
	
	public function onLoad()
	{
		$this->text = TextRecord::finder()->findBydir_name($_GET['id']);
		$this->text->delete();
		
		$this->Response->redirect('index.php?page=Home');
	}

}
?>