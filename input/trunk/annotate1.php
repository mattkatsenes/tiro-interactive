<?
session_start();
?>
<html>
<head>

<title>PHP Annotation 0.1b</title>
<link 	rel=Stylesheet		href="css/input.css" 	type="text/css" >
<script	src="js/prototype.js" 	type="text/javascript"></script>
<script	src="js/annotater.js" 	type="text/javascript"></script>

</head>
<body>
<div id="top_matter">
<h1>got definitions?</h1>
<p><span class="label">Instructions:</span> Click on any word to add its definition to the page.</p>
</div>

<div id="main">
<?
include "php/teiPage.php";

$tei = new teiPage($_SESSION['tei']);
$tei->outAnnotateDef();
?>

</div>

<div id="definition_container" style="display: none;"> ... 
</div>

<div id="glossary">
<?
$tei->outputDefinitions();
?>
</div>

</body>
</html>
