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
//			$this->MenubarMultiView->activeView=$this->MenubarUser;
			$this->WelcomeMultiView->activeView=$this->WelcomeUser;
		}
		else
		{
//			$this->MenubarMultiView->activeView=$this->MenubarGuest;
			$this->WelcomeMultiView->activeView=$this->WelcomeGuest;
		}
	}
	
	/*
	 * @author Matthew Katsenes <psalakanthos@gmail.com>
	 * @return string The <li>'s for the MenuBar
	 */
	public function menuBar()
	{
		$authManager=$this->Application->getModule('auth');
		$logged_in = !$authManager->User->IsGuest;

		$menuList = "";
		
		if(!$logged_in)
		{
			$menuList = <<<EOT
	<li><a href="index.php?page=Home">Home</a></li>
	<li><a href="index.php?page=About">About Tiro</a></li>
	<li><a href="index.php?page=UserManagement.Login">Login</a></li>
	<li><a href="index.php?page=UserManagement.Create">Create User</a></li>
EOT;
		}
		else
		{
			$menuList = <<<EOT
	<li><a href="index.php?page=Home">Home</a></li>
	<li><a href="index.php?page=About">About Tiro</a></li>
	<li><a href="index.php?page=UserManagement.Preferences">Edit Preferences</a></li>
EOT;
		}
		return $menuList; 
	}

	/*
	 * @author Matthew Katsenes <psalakanthos@gmail.com>
	 * @return string The complete HTML for the SideBar
	 */
	public function sideBar()
	{
		$authManager=$this->Application->getModule('auth');
		$logged_in = !$authManager->User->IsGuest;

		$sideBar = "";

		$sideBar .= <<<EOT
<span class="SideBarLabel">News</span>
<ul>
EOT;
		$newsItems = NewsItemRecord::finder()->findAll();
		
		foreach($newsItems as $item)
		{
			$sideBar .= <<<EOT
	<li>$item->slug <a href="index.php?page=News&id=$item->item_id ">...</a></li>
EOT;
		}
		
		$sideBar .= "</ul>";
		
		if(!$logged_in)
		{
			$sideBar .= "Please login to see your saved projects.";
		}
		else
		{
			$username = $authManager->User->Name;
			$my_texts = TextRecord::finder()->findAllByAuthor_id($username);
			
			$sideBar .= <<<EOT
<span class="SideBarLabel">My Texts</span>
<ul>
EOT;
			foreach($my_texts as $text)
			{
				$sideBar .= "<li>$text->title | <a href=\"index.php?page=TextManagement.View&id=$text->text_id \">view</a> |  <a href=\"index.php?page=TextManagement.Edit&id=$text->text_id\">edit</a> |  <a href=\"index.php?page=TextManagement.Publish&id=$text_id\">publish</a></li>";
			}
			
			$sideBar .= "<li><a href=\"index.php?page=TextManagement.NewText\">New Text</a></li></ul>";
		}
		return $sideBar; 
	}
	
	public function logoutButtonClicked()
	{
		$this->Application->getModule('auth')->logout();
		$url=$this->Service->DefaultPageUrl;
		
		$this->Response->redirect($url);
	}
}

?>
