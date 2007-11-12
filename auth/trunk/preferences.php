<?php
/* auth/preferences.php
 * author: 	Matthew Katsenes
 * created:	8/31/2007
 * purpose:	User Preferences editor for tiro-interactive.
 * status:	09/02/2007	+ BUG:	Preferences won't update when I say they should.
 */

require_once 'php/html.inc.php';
require_once 'php/auth.inc.php';
require_once 'php/preferences.inc.php';

global $auth,$prefmanager;

$auth->start();

if ($auth->checkAuth()) {
	htmlHeader('User Preferences');
	pageHeader(array('Create Project' => 'create_project.php',
					 'Current Texts' => 'my_projects.php',
					 'Preferences' => 'preferences.php',
					 'Logout' => 'index.php?logout=1'),
			   'Welcome, ' . $auth->getUsername() );
	$username = $auth->getUsername();

	$pref_update = showPrefForm($username);

	$renderer =& new HTML_QuickForm_Renderer_Tableless();
	$pref_update->accept($renderer);

	if($pref_update->isSubmitted())
	{
		updatePrefsDB($username,$pref_update->getSubmitValues());
//		echo "Preferences Updated";
//	drew-test-090607-delete me
	}

	echo $renderer->toHtml();
}
else	{
	pageHeader(array('Create Project' => 'create_project.php',
				 'Current Texts' => 'my_projects.php',
				 'Preferences' => 'preferences.php',
				 'Logout' => 'index.php?logout=1'),
		   'Oops' );
	htmlHeader('Error');
	echo "User not logged in";
}

pageFooter();
htmlFooter();


?>
