<?php
/**
 * User Creation Page.
 * 
 * Create new users and store them in our database.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage user-management
 * @version tiro-input side v. 0.1
 */
class Create extends TPage
{
	function checkUsername($sender,$param)
	{
		$param->IsValid=UserRecord::finder()->findByPk($this->username->Text)===null;
	}

	function createButtonClicked($sender,$param)
	{
		if($this->IsValid)  // when all validations succeed
        {
			// populates a UserRecord object with user inputs
			$userRecord=new UserRecord;
			$userRecord->username=$this->username->Text;
			$userRecord->password=md5($this->password->Text);

			// saves to the database via Active Record mechanism
			$userRecord->save();

			// umm.. create all the directories and whatnot.
			
			$this->Application->getModule('auth')->login($this->username->Text,md5($this->password->Text));

			// redirects the browser to the homepage
			$this->Response->redirect($this->Service->DefaultPageUrl);
		}
	}
}
?>