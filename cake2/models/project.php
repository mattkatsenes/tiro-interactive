<?php
class Project extends AppModel {

	var $name = 'Project';
	var $useTable = 'projects';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id'
			)
	);

	var $hasMany = array(
			'Annotation' => array('className' => 'Annotation',
								'foreignKey' => 'project_id',
								'dependent' => true
			)
	);

}
?>