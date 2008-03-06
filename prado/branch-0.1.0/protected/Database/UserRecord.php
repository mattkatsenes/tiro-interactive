<?php
/**
 * UserRecord / userRecords table
 *
 * Name & password holding DB abstraction.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-input
 * @subpackage database
 * @version tiro-input side v. 0.2
 */

class UserRecord extends TActiveRecord
{
	const TABLE='userRecords';

	public $username;
	public $password;
	public $role;

	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}

}
?>