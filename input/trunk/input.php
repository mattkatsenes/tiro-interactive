<?
include "php/teiPage.php";

// M-08-18-2007 - switch to php sessions instead of using cookies improperly.
session_start();

if(!isset($_SESSION['tei']))
	$tei = new teiPage('xml/template.xml');
else
	$tei = new teiPage($_SESSION['tei']);
?>

<html>
<head>
<title>PHP Input 0.1b</title>
<link 	rel=Stylesheet		href="css/input.css" 	type="text/css" >
<script	src="js/prototype.js" 	type="text/javascript"></script>
<script	src="js/loader.js" 	type="text/javascript"></script>

</head>
<body>
<div id="top_matter">
<h1>got text?</h1>

<p><span class="label">Instructions:</span> Choose either line-by-line poetry input, or chunk-by-chunk prose input.  Alternatively, you may upload TEI compliant XML file (you can get these on <a href="http://www.perseus.tufts.edu">Perseus</a>).  Do not worry about canonical text numbering at this point (we will adjust for this later).</p>

</div>
<form id="annotate1">
<div id="main">
<input type="button" name="poetry" id="poetry" value="Poetry" onclick="choosePoetry();" />
<input type="button" name="prose"  id="prose"  value="Prose"  onclick="chooseProse();" />
</div>


<div id="submit_button">
</div>

</form>

<?
	$_SESSION['tei'] = $tei->saveXML();
?>

</body>
</html>
