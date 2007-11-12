<?
session_start();

include "teiPage.php";

$tei = new teiPage($_SESSION['tei']);

$target = $_POST['target'];

$tei->removeEntry($target);

$tei->outputDefinitions();

$_SESSION['tei'] = $tei->saveXML();

?>
