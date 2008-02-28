<?php
/**
 * Get the TiroText class (and the rest of that directory) involved.
 */
prado::Using('Application.Engine.*');

class Definitions extends TPage
{

	public $tiroText;

	/**
	 * This runs as soon as the page loads.
	 * 
	 * The class constructor is gobbled up by the "TPage" class, but it
	 * calls this baby, so fo our purposes, this is equivalent.
	 */
	function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$dbRecord = TextRecord::finder()->findByPk($_GET['id']);
		$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name;
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name);
	}

	function Load()
	{
	
	$this->myName->Text = $this->User->Name;
	
	}

}
?>