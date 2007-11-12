<?php
/* auth/index.php
 * author: 	Matthew Katsenes
 * created:	8/29/2007
 * purpose:	Entry point for Latin Annotater.
 * status:	08/30/2007 	- User creation (new_user.php) and login functionality established.
 						+ BUG: On unsuccessful login, the html headers do not send properly (hence css doesn't work).
						+ BUG-FIXED 08/30/2007.
						+ BUG: "or click here" should appear at the bottom, but the css somehow puts it at the side.
 */

require_once 'php/html.inc.php';
require_once 'php/auth.inc.php';

global $auth,$prefmanager;

$auth->start();

if(!$auth->getAuth())
{
	htmlHeader('Index');
}

if($auth->checkAuth() && isset($_GET['logout']))	{
	session_unset();
	htmlHeader('Index');

	$auth->logout();
	$auth->start();
}
elseif ($auth->checkAuth()) {
	require_once 'my_projects.php';
}
pageFooter();
htmlFooter();

?>