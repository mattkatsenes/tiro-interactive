<?php
/* auth/new_user.php
 * author: 	Matthew Katsenes
 * created:	8/30/2007
 * purpose:	create new users.
 * status:
 */

require_once 'php/auth.inc.php';
require_once 'php/html.inc.php';
require_once 'php/user.inc.php';

htmlHeader('New User');

pageHeader(array('' => ''),
		   'Welcome!');

$userSetup = showUserSetupForm();
global $auth,$prefmanager;

if($userSetup->validate())
{
	$worked = userSetup($userSetup->exportValue('username'),$userSetup->exportValue('password'),$userSetup->exportValue('email'));

	if($worked)
		echo $userSetup->exportValue('username').", your user info is now added.  Click <a href=\"index.php\">here</a> to login.";
	else
	{
		echo "Username already taken.  Please choose another.";
		$renderer =& new HTML_QuickForm_Renderer_Tableless();

		$userSetup->accept($renderer);
		echo $renderer->toHtml();
	}
}
else
{
	$renderer =& new HTML_QuickForm_Renderer_Tableless();

	$userSetup->accept($renderer);
	echo $renderer->toHtml();
}

pageFooter();
htmlFooter();

?>
