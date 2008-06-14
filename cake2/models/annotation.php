<?php
class Annotation extends AppModel {

	var $name = 'Annotation';
	var $useTable = 'annotations';
	var $validate = array(
		'type' => array('alphaNumeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Project' => array('className' => 'Project',
								'foreignKey' => 'project_id'
			)
	);

}
?>