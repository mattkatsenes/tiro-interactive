<?php
/*
 * /auth/my_projects.php
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

	pageHeader(array('Create Project' => 'create_project.php',
					 'Preferences' => 'preferences.php',
					 'Logout' => 'index.php?logout=1'),
			   "Welcome, $username");

	//Get projects in an associative array format 'title' => 'xmlfile.xml'
	$projects = getProjects($username);

	echo <<<EOT
<table class="projectList">
	<caption>My Projects</caption>
	<thead>
		<tr>
			<th scope="col">Name</th>
			<th scope="col">Edit</th>
			<th scope="col">Display</th>
		</tr>
	</thead>
EOT;

	foreach($projects as $title => $file)
		echo <<<EOT
<tr><td>$title</td><td><a href="pj_edit.php?file=$file">edit</a></td><td><a href="pj_display.php?file=$file">display</a></td></tr>
EOT;

	echo "</table>";
}

htmlFooter();
?>
