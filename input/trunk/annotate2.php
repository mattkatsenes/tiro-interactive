<?
include "php/teiPage.php";

session_start();

//$tei = new teiPage($_SESSION['tei']);
//$tei->outXML();

echo "<pre>" . htmlspecialchars($_SESSION['tei']) . "</pre>";

?>
