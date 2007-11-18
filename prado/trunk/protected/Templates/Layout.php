<?php

class Layout extends TTemplateControl
{
	public function __construct()
	{
		parent::__construct();
	}

	public function onLoad ($param)
	{
		$this->MenubarMultiView->activeView=$this->MenubarGuest;
		$this->WelcomeMultiView->activeView=$this->WelcomeGuest;
	}
}

?>
