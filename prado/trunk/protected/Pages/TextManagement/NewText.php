<?php

class NewText extends TPage
{
	public function onLoad($param)
    {
	    $authManager=$this->Application->getModule('auth');
		
		$logged_in = !$authManager->User->IsGuest;
		
		if($logged_in)
		{
			$this->SidebarMultiView->ActiveView=$this->SidebarUser;
		}
		else
		{
			$this->SidebarMultiView->ActiveView=$this->SidebarGuest;
		}
    }

    
	public function textCreate($sender, $param)
	{
		$newText = new TextRecord();
		$newText->text_id = rand();
		$newText->author_id = $this->Application->getModule('auth')->User->Name;
		$newText->create_time = time();
		$newText->title = $this->Title->Text;
		$newText->status = 0;		
		
		$newText->save();
		
		$this->Response->redirect($this->Service->DefaultPageUrl);
	}
}

?>