<?php
/*
 * /auth/pj_display.php
 * created:	Sep 8, 2007
 * author: 	Matthew Katsenes
 * purpose:	Pass a project through cocoon and display it!
 * status:
 */

require_once 'php/html.inc.php';
require_once 'php/auth.inc.php';
require_once 'php/project.inc.php';

global $auth,$prefmanager;

$auth->start();
$project_id = $_GET['project'];

if(!$auth->getAuth())
{
	htmlHeader($project_id);
}
else
{
	htmlHeader("error");
}

?>
