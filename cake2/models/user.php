<?php
class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	var $validate = array(
		'username' => array('alphaNumeric'),
		'password' => array('alphaNumeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
			'Group' => array('className' => 'Group',
						'joinTable' => 'groups_users',
						'foreignKey' => 'user_id',
						'associationForeignKey' => 'group_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

}
?>