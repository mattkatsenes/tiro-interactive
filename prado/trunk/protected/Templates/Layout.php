<?php

/**
 * The default template for the whole project.
 * 
 * This template wraps around every page.  It provides
 * a header, nav-bar, and side-bar for each page.
 * It's built on @link http://www.pradosoft.com Prado PHP Framework.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage layout
 * @version tiro-input side v. 0.1
 */
class Layout extends TTemplateControl
{
	/**
	 * Layout Constructor.
	 * 
	 * Calls the parent constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Set the TMultiView for logged-in or not.
	 * 
	 * This changes the login state in the welcome div.
	 * @param mixed $param I've no idea what this actually is.
	 */
	public function onLoad ($param)
	{
		$authManager=$this->Application->getModule('auth');
		$logged_in = !$authManager->User->IsGuest;
		
		if($logged_in)
			$this->WelcomeMultiView->activeView=$this->WelcomeUser;
		else
			$this->WelcomeMultiView->activeView=$this->WelcomeGuest;
	}
	
	/**
	 * Create the MenuBar.
	 * 
	 * Parse the $pageService to see what page we're on.  Then use that info
	 * and the $logged_in state to create the <li>'s for the MenuBar.
	 * 
	 * So, if we're logged in and on the Home page, the MenuBar will hold all
	 * the items from $MENUBAR_ITEMS_USER except the one with RequestedPagePath
	 * Home.
	 * 
	 * @staticvar array $MENUBAR_ITEMS_GUEST An array of descriptive_title => prado_path for guest options.
	 * @staticvar array $MENUBAR_ITEMS_USER An array of descriptive_title => prado_path for user options. 
	 * @return string The <li>'s for the MenuBar
	 */
	public function menuBar()
	{
		static $MENUBAR_ITEMS_GUEST = array(
			'Home' => 'Home',
			'About Tiro' => 'About',
			'Login' => 'UserManagement.Login',
			'Create User' => 'UserManagement.Create'
			);
		static $MENUBAR_ITEMS_USER = array(
			'Home' => 'Home',
			'About Tiro' => 'About',
			'Login' => 'UserManagement.Login',
			'Create User' => 'UserManagement.Create'
			);
	
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
		
		$pageService = $this->Application->getService('page');
		
		$menuList .= $pageService->RequestedPagePath;
		return $menuList; 
	}

	/**
	 * Generates the HTML for the SideBar.
	 * 
	 * The SideBar has (right now) two sections (12/13/2007):
	 * - News Items
	 * - Project Listing (once logged in)
	 * 
	 * @return string $sideBar The complete HTML for the SideBar
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
