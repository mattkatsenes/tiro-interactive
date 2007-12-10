<?php

class NewText extends TPage
{
    
	public function textCreate($sender, $param)
	{
		$newText = new TextRecord();
		$newText->text_id = rand();
		$newText->author_id = $this->Application->getModule('auth')->User->Name;
		$newText->title = $this->Title->Text;
		$newText->status = 0;		
		
		$newText->save();
		
		$this->Response->redirect($this->Service->DefaultPageUrl);
	}
}

?>