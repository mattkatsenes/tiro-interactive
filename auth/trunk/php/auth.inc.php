<?php
require_once "Auth.php";
require_once "DB.php";
require_once "HTML/QuickForm.php";
require_once 'HTML/QuickForm/Renderer/Tableless.php';
require_once "Auth/PrefManager.php";
require_once "html.inc.php";
require_once "user.inc.php";

$dsn = 'mysql://mkatsenes:whois@localhost/auth1';
$opts = array('dsn' => $dsn);
$auth = new Auth('DB',$opts,"showLogin");

$opts_prefmanager = array('serialize' => false);
$prefmanager = new Auth_PrefManager($dsn, $opts_prefmanager);

// This is here to set up user directories when the svn is checked out.
// If directories are not properly set up, chmod 777 on the users dir.
$users = $auth->listUsers();

foreach($users as $number => $info)
{
	userDirSetup($info['username']);
}
?>
