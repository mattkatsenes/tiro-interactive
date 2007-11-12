<?
include "teiPage.php";

//$filename = "../xml/" . $_COOKIE["Annotater"] . ".xml";

session_start();

$tei = new teiPage($_SESSION['tei']);

// $_POST['choice'] = "prose|poetry"
// $_POST['line_#'] = "text of line #."


if($_GET['choice'] == 'poetry')
{
	$line_num = 1;
	echo "in poetry";
	foreach($_GET as $key => $value)
		if(strstr($key,'line'))
		{
			$tei->addPoetryLine($line_num,$value);
			$line_num++;
		}
}
else // Same for prose!
	echo "oy.  I'll do this someday.";

$_SESSION['tei'] = $tei->saveXML();
?>
