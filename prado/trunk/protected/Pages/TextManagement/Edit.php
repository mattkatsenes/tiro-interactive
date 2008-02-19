<?php
class Edit extends TPage
{
	public $text;
	
	public function onLoad()
	{
		$this->text = TextRecord::finder()->findBydir_name($_GET['id']);
	}

}
?>