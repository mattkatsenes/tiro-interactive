<?php
prado::Using('Application.Engine.*');

class temporary extends TPage 
{
	public $tiroText;
	
	public function onLoad()
	{
		
		global $ABS_PATH,$USERS_PREFIX;
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/matt/aeneid_11');
		
		$this->tiroText->titleEditorSet("Aeneid 1.1", "Matt");
	}	
}
?>