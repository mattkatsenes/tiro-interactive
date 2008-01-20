<?php

/**
 * Text Creation page.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage text-management
 * @version tiro-input side v. 0.1
 */
class NewText extends TPage
{    
	public function textCreate($sender, $param)
	{
		$newText = new TextRecord();
		$newText->author_id = $this->User->Name;
		$newText->title = $this->Title->Text;
		$newText->status = 0;

		$directory = $this->filename_safe($newText->title);
		
		$id = 0;
		if(TextRecord::finder()->findByDir_name($directory) != null)
		{
			while(TextRecord::finder()->findByDir_name($directory . $id) != null)
				$id++;
			$directory .= $id;
		}
		
		$newText->dir_name = $directory;

		$this->textSetup($newText);
		
		$newText->save();
		
//		$this->Response->redirect($this->Service->DefaultPageUrl);
	}
	
	private function textSetup($newText)
	{
		global $ABS_PATH,$USERS_PREFIX;
		$success = false;

		$path = $ABS_PATH . "/" . $USERS_PREFIX . "/" . $this->User->Name ."/". $newText->dir_name;
		
		mkdir($path);
		require_once($ABS_PATH . "/protected/Engine/TeiBase.php");
		
		$text = new TeiBase;
		$text->saveText();
		
		return $path;
	}
	
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