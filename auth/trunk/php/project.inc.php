<?php
/*
 * /auth/project.inc.php
 * created:	Sep 8, 2007
 * author: 	Matthew Katsenes
 * purpose:	functions for project creation and manipulation
 * status:
 */
require_once 'auth.inc.php';

function makeNewProjectForm()
{
	$newProject = new HTML_QuickForm('create_project');

	$newProject->addElement('text','title','Title: ');
	$newProject->addElement('text','author','Author: ');
	$newProject->addElement('radio','prosePoetry','Prose ',' OR ','prose');
	$newProject->addElement('radio','prosePoetry','Poetry ','','poetry');
	$newProject->addElement('submit','submit','Create');

	return $newProject;
}

function getProjects($username)
{
	global $dsn;

	$db =& DB::connect($dsn);
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}

	$res =& $db->query("SELECT * FROM `projects` WHERE `user` =  '$username'");

	if (PEAR::isError($res)) {
		die($res->getMessage());
	}

	$projects = array();

	while ($res->fetchInto($row)) {
		$projects[$row[1]] = $row[2];
	}

	$db->disconnect();

	return $projects;
}

function createProject($username,$title,$author,$filename)
{
	global $dsn, $auth, $prefmanager;

	$db =& DB::connect($dsn);
	if (PEAR::isError($db)) {
		return $db->getMessage();
	}

	$res =& $db->query("INSERT INTO `projects` (`user`, `projectname`, `filename`) VALUES ('$username', '$title', '$filename')");

	if (PEAR::isError($res)) {
		return $res->getMessage();
	}

	$db->disconnect();

	$xml = new DOMDocument();
	$xml->load('xml/template.xml');

	$xpath = new DOMXpath($xml);
	$query = "//title";

	$title_node = $xpath->query($query)->item(0); //DOMNode
	$title_node->nodeValue = $title;

	$query = "//author";

	$title_node = $xpath->query($query)->item(0); //DOMNode
	$title_node->nodeValue = $author;

	$home_dir = $prefmanager->getPref($username,'home_dir');

	if(!is_dir("$home_dir/$filename"))
		mkdir("$home_dir/$filename");

	$xml->save("$home_dir/$filename/text.xml");
	return true;
}
?>
