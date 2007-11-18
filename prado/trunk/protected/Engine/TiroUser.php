<?php
Prado::using('System.Security.TDbUserManager');

class TiroUser extends TDbUser {

	public function validateUser($username, $password)
	{
		return UserRecord::finder()->findBy_username_AND_password($username,$password)!==null;
	}

	public function createUser($username)
	{
        // use UserRecord Active Record to look for the specified username
        $userRecord=UserRecord::finder()->findByPk($username);
        if($userRecord instanceof UserRecord) // if found
        {
            $user=new TiroUser($this->Manager);
            $user->Name=$username;  // set username
            $user->IsGuest=false;   // the user is not a guest
            return $user;
        }
        else
            return null;
    }
}

?>
