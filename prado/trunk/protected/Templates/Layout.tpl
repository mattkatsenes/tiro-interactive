<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >

<com:THead Title="tiro interactive">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="content-language" content="en"/>

<link href="css/style.css" rel="stylesheet" type="text/css"/>

</com:THead>

<body>
<com:TForm>
<div id="pageHeader">
<div id="logo"><img src="images/tiro-quill1s.jpg" /></div>
<div id="welcome">
<com:TMultiView ID="WelcomeMultiView">
<com:TView ID="WelcomeGuest">
Please login.
</com:TView>
<com:TView ID="WelcomeUser">
Welcome,  <%= $this->Application->getModule('auth')->User->Name %>
</com:TView>
</com:TMultiView>
</div>
</div>

<div id="sidebar">
<com:TContentPlaceHolder ID="sidebar" />
</div>

<div id="mainColumn">

<div id="menubar">
<com:TMultiView ID="MenubarMultiView">
<com:TView ID="MenubarGuest">
	<ul>
		<li><a href="index.php?page=About">About Tiro</a></li>
		<li><a href="index.php?page=UserManagement.Login">Login</a></li>
		<li><a href="index.php?page=UserManagement.Create">Create User</a></li>
	</ul>
</com:TView>
<com:TView ID="MenubarUser">
	<ul>
		<li><a href="index.php?page=About">About Tiro</a></li>
		<li><a href="index.php?page=UserManagement.Preferences">Edit Preferences</a></li>
		<li><com:TLinkButton Text="Logout" OnCommand="logoutButtonClicked" /></li>

	</ul>

</com:TView>
</com:TMultiView>
</div>

<div id="guts">
<com:TContentPlaceHolder ID="guts" />
</div>

</div>
<div id="credits">
<ul>
	<li>Copyright 2007 Matthew Katsenes</li>
	<li>Powered By <a href="http://www.pradosoft.com" target="_blank">PRADO</a>, <a href="http://www.php.net" target="_blank">PHP</a>, <a href="http://tomcat.apache.org" target="_blank">Tomcat</a>, and <a href="http://cocoon.apache.org" target="_blank">Cocoon</a></li>
</ul>
</div>
</com:TForm>
</body>
</html>
