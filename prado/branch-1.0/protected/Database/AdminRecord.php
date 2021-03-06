<?php
/**
 * Auto generated by prado-cli.php on 2007-12-14 09:57:08.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage database
 * @version tiro-input side v. 0.1
 */
class AdminRecord extends TActiveRecord
{
	const TABLE='adminUsers';

	public $username;
	public $email;

	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
	
	/**
	 * ActiveRecord array of NewsRecord objects.
	 */
	public $newsItems=array();
	
	public static $RELATIONS=array
	(
		'newsItems' => array(self::HAS_MANY, 'NewsRecord'),
	);
}
?>