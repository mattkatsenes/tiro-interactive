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
	function onLoad()
	{
		$teachers = TeacherRecord::finder()->findAll();

		foreach($teachers as $teacher)
			$teacherArray[$teacher->username] = $teacher->last_name;
		
		$this->teacherDropDown->DataSource=$teacherArray;
		$this->teacherDropDown->dataBind();	
	}

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
			
			if($this->teacher->Checked)
			{
				$userRecord->role = 1;
				$teacherRecord = new TeacherRecord;
				$teacherRecord->username = $userRecord->username;
				$teacherRecord->save();
				
				// umm.. create all the directories and whatnot.
				global $ABS_PATH,$USERS_PREFIX;

				$path = $ABS_PATH . "/" . $USERS_PREFIX . "/" . $userRecord->username;
				mkdir($path);				
			}
			elseif($this->student->Checked)
			{
				$userRecord->role = 2;
				$studentRecord = new StudentRecord;
				$studentRecord->username = $userRecord->username;
				$studentRecord->teacher_id = $this->teacherDropDown->SelectedValue;
				$studentRecord->save();
			}
			// saves to the database via Active Record mechanism
			$userRecord->save();

			// redirects the browser to the homepage.. should go to preferences.
			$this->Response->redirect($this->Service->DefaultPageUrl);
		}
	}
}
?>