<?php

class Home extends TPage {

	public $username;
	public $texts;
	// If user is logged in, redirect them to UserHome
	public function onLoad($param)
    {
	    $authManager=$this->Application->getModule('auth');
		
		$logged_in = !$authManager->User->IsGuest;
		
		if($logged_in)
		{
			$this->SidebarMultiView->ActiveView=$this->SidebarUser;
			$this->username = $authManager->User->Name;
			$userRecord = UserRecord::finder()->findByUsername($this->username);
		}
		else
		{
			$this->SidebarMultiView->ActiveView=$this->SidebarGuest;
		}
    }


}

?>