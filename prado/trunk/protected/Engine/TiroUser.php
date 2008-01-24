<?php

/**
 * User base file.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage user-management
 * @version tiro-input-side v. 0.2
 * @todo Rewrite this to implement several different types of user
 */

Prado::using('System.Security.TDbUserManager');
/**
 * User Manager class.
 * 
 * Extends Prado's Database Authentication class. 
 */
class TiroUser extends TDbUser {

	/**
	 * @param string $username
	 * @param string $password Already passed through an MD5 Hash.
	 * @return bool Is the name/pass combination valid?
	 */
	public function validateUser($username, $password)
	{
		return UserRecord::finder()->findBy_username_AND_password($username,$password)!==null;
	}

	/**
	 * Create an INSTANCE of this class.
	 * 
	 * This function does not create a new user record entry in
	 * the DB.  @see UserRecord.php for that.  This function is
	 * not meant for use in my code.  It implements an abstract
	 * from the Prado code.
	 * 
	 * @return mixed Either the logged-in user object OR null.
	 */
	public function createUser($username)
	{
		$userRecord = UserRecord::finder()->findByPk($username);
		if($userRecord instanceof UserRecord)
		{
			$user = new TiroUser($this->Manager);
			$user->Name = $username;
			$user->IsGuest = false;
			
			if($userRecord->role == 0)
				$user->Roles = 'admin';
			elseif($userRecord->role == 1)
				$user->Roles = 'teacher';
			elseif($userRecord->role == 2)
				$user->Roles = 'student';
			else
				$user->Roles = 'oops';			
			return $user;
		}
		else
			return null;
	}
}

?>
