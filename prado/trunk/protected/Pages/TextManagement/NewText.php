<?php

/**
 * Text Creation page.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-input
 * @subpackage text-management
 * @version tiro-input side v. 0.2
 */
class NewText extends TPage
{    
	public function Create()
	{
		$newText = new TextRecord();
		$newText->author_id = $this->User->Name;
		$newText->title = $this->Title->Text;
		$newText->status = 0;
		$newText->creation_date = date("m-d-Y H:i:s");		//%m-%d-%Y %H:%M:%S",'now'

		// Check to see if this author has already created this title.
		$id=2;
		foreach(TeacherRecord::finder()->withTexts()->findByUsername($this->User->Name)->texts as $text)
		{
			if($text->title == $newText->title)	
			{
				// find a title that's not yet taken
				while(TextRecord::finder()->find('title = :title AND author_id = :author_id',
							array(':title'=>$newText->title . $id,':author_id'=>$this->User->Name)) != null)
					$id++;

				$newText->title .= $id;
			}
		}
		
		$directory = $this->filename_safe($newText->title);
		
		$id = 0;
		if(TextRecord::finder()->find('author_id = ? AND dir_name = ?', $this->User->Name, $directory) != null)
		{
			while(TextRecord::finder()->find('author_id = ? AND dir_name = ?', $this->User->Name, $directory . $id) != null)
				$id++;
			$directory .= $id;
		}
		$newText->dir_name = $directory;

		$this->dirSetup($newText);
		
		$newText->save();
		$this->Response->redirect('index.php/'.$newText->id);
	}
	
	/**
	 * Setup the directories and files for this text.
	 */
	private function dirSetup($newText)
	{
		global $ABS_PATH,$USERS_PREFIX;

		$path = $ABS_PATH . "/" . $USERS_PREFIX . "/" . $this->User->Name ."/". $newText->dir_name;
		
		mkdir($path);
		require_once($ABS_PATH . "/protected/Engine/TiroText.php");
		
		$text = new TiroText($path);
		$text->saveText();
	}
	
	/**
	 * Is this string reasonable to be a filename?
	 */
	private	function filename_safe($filename)
	{
    	$temp = $filename;

		// Lower case
		$temp = strtolower($temp);

		// Replace spaces with a '_'
		$temp = str_replace(" ", "_", $temp);

		// Loop through string
		$result = '';
		for ($i=0; $i<strlen($temp); $i++) 
		{
			if (preg_match('([0-9]|[a-z]|_)', $temp[$i]))
	            $result = $result . $temp[$i];
		}

		// Return filename
		return $result;
	}
}
?>