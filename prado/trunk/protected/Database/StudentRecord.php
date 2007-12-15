<?php
/**
 * Auto generated by prado-cli.php on 2007-12-14 09:57:49.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage database
 * @version tiro-input side v. 0.1
 */
class StudentRecord extends TActiveRecord
{
	const TABLE='studentUsers';

	public $username;
	public $password;
	public $teacher_id;
	public $email;

	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
	
	public $teacher;
	
	public static $RELATIONS = array(
		'teacher' => array(self::BELONGS_TO,'TeacherRecord'),
	);
}
?>