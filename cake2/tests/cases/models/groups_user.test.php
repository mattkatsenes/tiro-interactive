<?php 

App::import('Model', 'GroupsUser');

class GroupsUserTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new GroupsUser();
	}

	function tearDown() {
		unset($this->TestObject);
	}

	/*
	function testMe() {
		$result = $this->TestObject->findAll();
		$expected = 1;
		$this->assertEqual($result, $expected);
	}
	*/
}
?>