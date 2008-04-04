<?php

/**
 * The default template for the whole project.
 * 
 * This template wraps around every page.  It provides
 * a header, nav-bar, and side-bar for each page.
 * It's built on @link http://www.pradosoft.com Prado PHP Framework.
 * 
 * UPDATE: The template now works properly using Prado's TBulletedList class.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage layout
 * @version tiro-input side v. 0.2
 * 
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
		
		$this->menuBar($logged_in);
		$this->sideBar($logged_in);
	}
	
	/**
	 * Gets the application context (the relative URL for the prado app without the index.php bit).
	 */
	public function getApplicationContext()
	{
		$context = $this->Application->Request->ApplicationUrl;
		return substr_replace($context,'',-9);
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
	 * @param bool $logged_in guest or user state?
	 * @staticvar array $MENUBAR_ITEMS_GUEST An array of  prado_path => descriptive_title for guest options.
	 * @staticvar array $MENUBAR_ITEMS_USER An array of prado_path => descriptive_title for user options. 
	 */
	public function menuBar($logged_in)
	{
		$MENUBAR_ITEMS_GUEST = array(
			$this->Application->Request->ApplicationUrl . '?page=Home' => 'Home',
			$this->Application->Request->ApplicationUrl . '?page=About' => 'About Tiro',
			$this->Application->Request->ApplicationUrl . '?page=UserManagement.Login' => 'Login',
			$this->Application->Request->ApplicationUrl . '?page=UserManagement.Create' => 'Create User'
			);
		$MENUBAR_ITEMS_USER = array(
			$this->Application->Request->ApplicationUrl . '?page=Home' => 'Home',
			$this->Application->Request->ApplicationUrl . '?page=About' =>'About Tiro',
			$this->Application->Request->ApplicationUrl . '?page=UserManagement.Logout' => 'Logout'
			);
		
		if(!$logged_in)
		{
			$this->MenuList->DataSource=$MENUBAR_ITEMS_GUEST;
			$this->MenuList->databind();
		}
		else
		{
			$this->MenuList->DataSource=$MENUBAR_ITEMS_USER;
			$this->MenuList->databind();
		}
	}

	/**
	 * Binds the data for the SideBar.
	 */
	public function sideBar($logged_in)
	{	
/*		if(!$logged_in)
		{
			$this->SideBarLabel->Text = "Please login.";
			$this->SideBarList->DataSource = Array("Please Login");
		} */
		
		$exist = false;
		if(isset($this->User->Roles[0]))
			$exist = true;

		if($exist == true && ($this->User->Roles[0] == 'teacher'))
		{
			$this->SideBarLabel->Text = "My Texts:";
			$username = $this->User->Name;
			$my_texts = TextRecord::finder()->findAllByAuthor_id($username);

			$textArray = Array("index.php?page=TextManagement.NewText" => "New Text");
			foreach($my_texts as $text)
				$textArray[$this->Application->Request->ApplicationUrl . "/$text->id"] = $text->title;
				
			$this->SideBarList->DataSource = $textArray;
			$this->SideBarList->databind();
		}
		elseif( ($exist == true) && $this->User->Roles[0] == 'student')
		{
			$teacherRecord = StudentRecord::finder()->withTeacher()->findByPk($this->User->Name)->teacher;
			
			$this->SideBarLabel->Text = "Teacher: $teacherRecord->first_name $teacherRecord->middle_name $teacherRecord->last_name";
			
			$textArray = Array();
			
			$teacherTexts= TextRecord::finder()->findAllByAuthor_id($teacherRecord->username);
			foreach($teacherTexts as $text)
				if($text->status > 0)
					$textArray["index.php?page=Student.View&id=$text->dir_name"] = $text->title;
			
			$this->SideBarList->DataSource = $textArray;
			$this->SideBarList->databind();
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
