<?php 
/* SVN FILE: $Id: schema.php 6311 2008-01-02 06:33:52Z phpnut $ */
/*TiroCake schema generated on: 2008-06-05 11:06:08 : 1212678308*/


class TiroCakeSchema extends CakeSchema {

	var $name = 'TiroCake';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $groups = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'name' => array('type'=>'string', 'null' => false, 'length' => 32),
			'indexes' => array()
		);

	var $groups_users = array(
			'group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
			'indexes' => array()
		);

	var $users = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'username' => array('type'=>'string', 'null' => false, 'length' => 16),
			'password' => array('type'=>'string', 'null' => false, 'length' => 32),
			'indexes' => array()
		);

}
?>