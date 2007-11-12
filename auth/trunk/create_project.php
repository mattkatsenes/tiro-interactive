<?php
/*
 * /auth/create_project.php
 * created:	Sep 8, 2007
 * author: 	Matthew Katsenes
 * purpose:
 * status:
 */
require_once 'php/html.inc.php';
require_once 'php/auth.inc.php';
require_once 'php/project.inc.php';

global $auth,$prefmanager;

$auth->start();

if(!$auth->getAuth())
{
	htmlHeader('Error');
	showError();
}
else
{
	htmlHeader('Projects');
	$username = $auth->getUsername();

	pageHeader(array('My Projects' => 'my_projects.php',
					 'Preferences' => 'preferences.php',
					 'Logout' => 'index.php?logout=1'),
			   "Welcome, $username");

	$newProject = makeNewProjectForm();

	if($newProject->validate())
	{
		$title = $newProject->exportValue('title');
		$author = $newProject->exportValue('author');
		$filename = preg_replace('/ /','',$title) . preg_replace('/ /','',$author);
		createProject($username,$title,$author,$filename);

		echo "Project $title created.";
		echo "Want to <a href=\"pj_edit.php?project=$filename\""""
	}
	else
	{
		$renderer =& new HTML_QuickForm_Renderer_Tableless();

		$newProject->accept($renderer);
		echo $renderer->toHtml();
	}
}
?>
