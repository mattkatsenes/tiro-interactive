<?php 
/* SVN FILE: $Id: schema.php 6311 2008-01-02 06:33:52Z phpnut $ */
/*App schema generated on: 2008-05-31 17:05:58 : 1212270238*/


class AppSchema extends CakeSchema {

	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $acos = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'parent_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'model' => array('type'=>'string', 'null' => true),
			'foreign_key' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'alias' => array('type'=>'string', 'null' => true),
			'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array()
		);

	var $aros = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'parent_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'model' => array('type'=>'string', 'null' => true),
			'foreign_key' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'alias' => array('type'=>'string', 'null' => true),
			'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array()
		);

	var $aros_acos = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'aro_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'aco_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'_create' => array('type'=>'string', 'null' => false, 'default' => '0', 'length' => 2),
			'_read' => array('type'=>'string', 'null' => false, 'default' => '0', 'length' => 2),
			'_update' => array('type'=>'string', 'null' => false, 'default' => '0', 'length' => 2),
			'_delete' => array('type'=>'string', 'null' => false, 'default' => '0', 'length' => 2),
			'indexes' => array()
		);

	var $chunks = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'text' => array('type'=>'text', 'null' => true, 'default' => NULL),
			'type' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 30),
			'index' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array()
		);

	var $projects = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'dir_name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
			'author' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
			'indexes' => array()
		);

	var $users = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'login' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
			'password' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
			'role' => array('type'=>'integer', 'null' => false, 'default' => '1', 'length' => 3),
			'indexes' => array()
		);

}
?>