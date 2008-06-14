<?php
class TiroTextComponent extends Object {
	var $test = "testing 123.";
	/**
	 * @var DomDocument holds the xml tree of the main text.
	 */
	private $xml;
	
	//called before Controller::beforeFilter()
	function initialize() {

	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
		$this->controller =& $controller;
	}
	
}
?>
