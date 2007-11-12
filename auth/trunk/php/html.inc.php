<?php

function htmlHeader($title)
{
	echo <<<EOT
<html>
<head>
	<title>$title</title>
	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body>
EOT;
}

function htmlFooter()
{
	echo <<<EOT
</body>
</html>
EOT;
}

function pageHeader($menuitems,$msg)
{
	echo <<<EOT
<div id="pageHeader">
<div class="graphic"><img src="img/tiro3-wide4.jpg" /></div>
<div class="menu">
<ul>
EOT;

	foreach($menuitems as $title =>$link)
		echo "<li><a href=\"$link\">$title</a></li>";

echo <<<EOT
	<li><span class="message">$msg</span></li>
</ul>
</div>

</div>
<div id="content">
EOT;
}

function pageFooter()
{
	echo <<<EOT
</div>
<div id="pageFooter">Copyright 2007 Matthew Katsenes</div>
EOT;
}

function showLogin()
{
	pageHeader(array('Create User' =>'new_user.php'),
			   'Or Login.' );

	$form = new HTML_QuickForm('login');
	$form->addElement('header','','Login, please.');
	$form->addElement('text','username','username: ');
	$form->addElement('password','password','password: ');
	$form->addElement('submit','submit','Submit');

	$renderer =& new HTML_QuickForm_Renderer_Tableless();

	$form->accept($renderer);
	echo $renderer->toHtml();

}

function showPrefEdit()
{
	echo "<span class=\"pref_link\" >Click <a href=\"preferences.php\">here</a> to edit preferences.</span>";
}

function showLogout()
{
	echo "<span class=\"logout_link\">Click <a href=\"index.php?logout=1\">here</a> to logout.</span>";
}

function showError()
{
	echo "We've had an error!  Go <a href=\"index.php\">home</a>.";
}
?>