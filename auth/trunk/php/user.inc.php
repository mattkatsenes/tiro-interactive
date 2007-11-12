<?php

function userDirSetup($username)
{
	global $prefmanager;

	if(!is_dir($prefmanager->getPref($username,'home_dir')))
		mkdir($prefmanager->getPref($username,'home_dir'));
}

function userSetup($username,$password,$email)
{
	global $prefmanager, $opts, $auth;

	$users = $auth->listUsers();
	foreach($users as $user)
		if($user['username'] == $username)
			return false;

	$auth->addUser($username,$password);
	$auth->logout();

	$prefmanager->setPref($username,'email',$email);
	$prefmanager->setPref($username,'home_dir',"users/$username");

	userDirSetup($username);

	return true;
}

function showUserSetupForm()
{
	//Form
	$userSetup = new HTML_QuickForm('newuser');
	$userSetup->addElement('header','','Your details, please.');
	$userSetup->addElement('text','username','username: ');
	$userSetup->addElement('password','password','password: ');
	$userSetup->addElement('password','password2','retype password: ');
	$userSetup->addElement('text','email','email: ');
	$userSetup->addElement('submit','submit','Submit');

	//Rules
	$userSetup->addRule('username', 'We really need a username...', 'required');
	$userSetup->addRule('password', 'We really need a password...', 'required');
	$userSetup->addRule('email', 'Valid email, please.','email');
	$userSetup->addRule('password2', 'Please confirm your password...', 'required');
	$userSetup->addRule(array('password','password2'), 'Passwords not the same...', 'compare');

	return $userSetup;
}
?>
