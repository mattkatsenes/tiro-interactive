<?php

class Layout extends TTemplateControl
{
	public function __construct()
	{
		parent::__construct();
	}

	public function onLoad ($param)
	{
		$authManager=$this->Application->getModule('auth');
		
		$logged_in = !$authManager->User->IsGuest;
		
		if($logged_in)
		{
			$this->MenubarMultiView->activeView=$this->MenubarUser;
			$this->WelcomeMultiView->activeView=$this->WelcomeUser;
		}
		else
		{
			$this->MenubarMultiView->activeView=$this->MenubarGuest;
			$this->WelcomeMultiView->activeView=$this->WelcomeGuest;
		}
	}
	
	public function logoutButtonClicked()
	{
		$this->Application->getModule('auth')->logout();
		$url=$this->Service->DefaultPageUrl;
		
		$this->Response->redirect($url);
	}
}

?>
