<?php
class Delete extends TPage
{
	public $text;
	
	public function onLoad()
	{
		$this->text = TextRecord::finder()->findById($_GET['id']);
	}
	
	public function deleteClicked()
	{
		global $ABS_PATH,$USERS_PREFIX;
		
		exec("rm -Rf " . $ABS_PATH .'/'. $USERS_PREFIX .'/'. $this->text->author_id .'/'. $this->text->dir_name);
		
		$this->text->delete();
		$this->Response->redirect('index.php?page=Home');
	}
	
	public function goHome()
	{
		$this->Response->redirect('index.php?page=Home');
	}
}
?>