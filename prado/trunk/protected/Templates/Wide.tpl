<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >

<com:THead Title="tiro interactive">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="content-language" content="en"/>

<com:TStyleSheet StyleSheetUrl="<%= $this->ApplicationContext %>/css/style-wide.css" />
</com:THead>

<body>
<div id="container">
<com:TForm>
<div id="mainColumn">

<div id="menubar">
<com:TBulletedList id="MenuList"
	DisplayMode="HyperLink" />
</div>

<com:TConditional condition="in_array('Plugins',explode('.',$this->Request->getServiceParameter()))">
	<prop:TrueTemplate>
	<div>
		<com:TDropDownList ID='dropDownList' AutoPostBack='true' OnSelectedIndexChanged="Parent.Parent.Parent.changeLoc">
		  <com:TListItem Value="null" Text="Options" />
		  <com:TListItem Value="Defs" Text="Defs" />
		  <com:TListItem Value="Notes" Text="Notes"/>
		  <com:TListItem Value="Images" Text="Images" />
		</com:TDropDownList>
	</div>
	</prop:TrueTemplate>
	<prop:FalseTemplate />
</com:TConditional>

<div id="guts">
<com:TContentPlaceHolder ID="guts" />
</div>

</div>
<div id="credits">
<ul>
	<li>Copyright 2008 Matthew Katsenes</li>
	<li>Powered By <a href="http://www.pradosoft.com" target="_blank">PRADO</a>, <a href="http://www.php.net" target="_blank">PHP</a>, <a href="http://tomcat.apache.org" target="_blank">Tomcat</a>, <a href="http://cocoon.apache.org" target="_blank">Cocoon</a>, <a href="http://www.perseus.tufts.edu">Perseus</a>, and <a href="http://www.tei-c.org">TEI</a>.</li>
</ul>
</div>
</com:TForm>
</div>
</body>
</html>
