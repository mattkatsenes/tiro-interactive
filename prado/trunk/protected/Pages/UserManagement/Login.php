<?php

/**
 * Login Page.
 * 
 * User login page.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage user-management
 * @version tiro-input side v. 0.1
 */
class Login extends TPage {

	public function validateUser($sender,$param)
    {
        $authManager=$this->Application->getModule('auth');
        if(!$authManager->login($this->username->Text,md5($this->password->Text)))
            $param->IsValid=false;  // tell the validator that validation fails
    }


	public function loginButtonClicked ($sender, $param)
	{
		if ($this->Page->IsValid) // login successful?
		{
			// obtain the URL of the privileged page that the user wanted to visit originally
            $url=$this->Application->getModule('auth')->ReturnUrl;
            if(empty($url))  // the user accesses the login page directly
                $url=$this->Service->DefaultPageUrl;
           	$this->Application->getModule('auth')->User->IsGuest=false;
            $this->Response->redirect($url);
		}
	}
}

?>
