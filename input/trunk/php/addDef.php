<?
session_start();

include "teiPage.php";

$word = new teiHeadword();
$target = $_POST['target'];

foreach($_POST as $key => $value)
	if(strstr("orth,pos,gen,subc,def",$key))
		$word->addParam($key,$value);

$tei = new teiPage($_SESSION['tei']);
$tei->addEntry($word,$target);


$_SESSION['tei'] = $tei->saveXML();

$tei->outputDefinitions();

?>
