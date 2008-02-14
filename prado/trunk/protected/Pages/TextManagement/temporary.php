<?php
prado::Using('Application.Engine.*');

class temporary extends TPage 
{
	public $perseusObject;
	public $tiroObject;
	public $perseusObjectTwo;
	
	public function onLoad()
	{
		$this->perseusObject = new PerseusChunk('Perseus:text:1999.02.0002',':book=1:chapter=1:section=1');
		$this->tiroObject = new TiroText('/Users/mkatsenes/Sites/workspace/prado-gcode/protected/users/matt/worker');
		
		$this->perseusObjectTwo = new PerseusChunk('Perseus:text:1999.02.0002',':book=1:chapter=1:section=2');
		
		$this->tiroObject->addPerseusChunk($this->perseusObject);
		$this->tiroObject->addPerseusChunk($this->perseusObjectTwo);
		
		$this->tiroObject->saveText();
	}	
}
?>