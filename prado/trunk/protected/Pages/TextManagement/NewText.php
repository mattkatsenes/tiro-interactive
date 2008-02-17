<?php

/**
 * Text Creation page.
 * 
 * This uses the hard-coded arrays $AUTHOR_ARRAY and 
 * $TEXT_ARRAY because RDF processing is incredibly slow.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage text-management
 * @version tiro-input side v. 0.1
 */
class NewText extends TPage
{    
	/**
	 * Load the page and choose the View.
	 * 
	 * If we are loading for the first time, go to Author.
	 * Otherwise, someone else should've reset it.
	 */
	public function onLoad()
	{
		if(!$this->IsPostBack)
			$this->loadAuthorView();
	}

	public function loadAuthorView()
	{
		global $AUTHOR_ARRAY;
		$this->AuthorList->DataSource=$AUTHOR_ARRAY;
		$this->AuthorList->dataBind();
		$this->ChoicesMultiView->ActiveView = $this->AuthorView;		
	}
	
	public function authorChosen($sender,$param)
	{
		global $AUTHOR_ARRAY, $TEXT_ARRAY;
		$author_index = $param->Index;
		$author = $AUTHOR_ARRAY[$author_index];
		$this->AuthorName->Text = $author;
		
		$this->TextList->DataTextField="title";
		$this->TextList->DataValueField="perseus";
		$this->TextList->DataSource=$TEXT_ARRAY[$author];
		$this->TextList->dataBind();
		
		$this->ChoicesMultiView->ActiveView = $this->TextView;
	}
	
	public function textChosen($sender,$param)
	{
		$this->ToCAuthorName->Text = $this->AuthorName->Text;
		$this->ToCTextName->Text = $sender->Items->offsetGet($param->Index)->Text;
		$this->ToCPerseus->Text = $sender->Items->offsetGet($param->Index)->Value;
		
		$this->ChoicesMultiView->ActiveView = $this->ToCView;
	}
	
	/**
	 * Creation Button Clicked.
	 * 
	 * Check to see if the author has another text with this title.
	 * Check for a non-unique 'directory' since this is the PK.
	 * Make the directories and default files.
	 */
	public function textCreate($sender, $param)
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
		if(TextRecord::finder()->findByDir_name($directory) != null)
		{
			while(TextRecord::finder()->findByDir_name($directory . $id) != null)
				$id++;
			$directory .= $id;
		}
		$newText->dir_name = $directory;

		$this->dirSetup($newText);
		
		$newText->save();
		
		global $PERSEUS_SERVER;
		$this->Response->redirect($PERSEUS_SERVER . 'xmltoc.jsp?doc=' . $this->ToCPerseus->Text);
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