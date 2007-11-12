<?
// Update the text in the 'main' div on annotater1.php

session_start();

include "teiPage.php";

$tei = new teiPage($_SESSION['tei']);
$tei->outAnnotateDef();

echo "Hit updateText1.php";

?>
