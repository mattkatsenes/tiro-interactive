<?php
prado::Using('Application.Engine.*');

class temporary extends TPage 
{
	public $tiroText;
	
	public function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/matt/arma_virumque');
		
		
	}	
}
?>