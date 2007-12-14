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
		$newText->text_id = rand();
		$newText->author_id = $this->Application->getModule('auth')->User->Name;
		$newText->title = $this->Title->Text;
		$newText->status = 0;		
		
		$newText->save();
		
		$this->Response->redirect($this->Service->DefaultPageUrl);
	}
}

?>