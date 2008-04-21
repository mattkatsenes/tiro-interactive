<?php
class Hyperlink extends TPage
{
	function onLoad()
	{
		if($_GET['action'] == 'input')
			$this->LinkMultiView->ActiveView = $this->Input;
		elseif($_GET['action'] == 'attach')
			$this->attachLink();
		else
			echo "error";
	}
	
	function attachLink()
	{
		$this->LinkMultiView->ActiveView = $this->Success;
	}
}
?>