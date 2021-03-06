<?php
/*
 * createXMLform page
 * 
 * @author Drew Buschhorn <drewbuschhorn@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage definition-management
 * @version tiro-input-side v. 0.2
 * @depends Needs inputtest-wordbox.js to function properly.
 * @param $_GET['word'] an inflected latin word, whose definition is to be created.
 * @return HTMLSpan an HTMLSpan which contains an  HTMLForm to be displayed to the user, allowing them to choose the root word, and edit the definition.
 */

$GLOBALS['PERSEUS_SERVER']="http://www.tiro-interactive.org/hopper/";

header ('Content-type: text/xml; charset=utf-8');
include_once('/Library/WebServer/Documents/tiro/prado/trunk/protected/Engine/PerseusDictFunc.php');


$word = $_GET['word'];
$xmlDoc = getParse($word,'xml',false); //getParse($latin_word, $is_test_run = false)

//Create the containing span, and the form.  A containing span is used to provide for easy ajax insertion into a webpage.
echo <<<HTML
<span>\n
<h3 id="query_word">$word</h3>\n
<form id="wordbox" name="wordbox">\n
HTML;

$xpath = new DOMXPath($xmlDoc);
	$definitions = $xpath->query('/ParseLookupResults/Definition'); //Find the possible definitions of the given inflected word ($_GET['word'])
	
foreach($definitions as $definition)
{
$morphs = $definition->getElementsByTagName("morphAnalysis");  //Find the possible parts of speech that the word could be from
$morph = "";
for($i = 0; $i<$morphs->length; $i++)
	{
	if( $i == ($morphs->length)-1) //If last morph possibility, we dont need to put in commas
		$morph .= trim($morphs->item($i)->nodeValue);
	else
		$morph .= trim($morphs->item($i)->nodeValue) . ", "; //If not last morph possibility, we do need to put in commas
	}

//Collecting together the different grammatical pieces of be displayed.
$orth 	= trim($definition->getElementsByTagName("orth")->item(0)->textContent);
$iparts 	= $definition->getElementsByTagName("itype");
$gramGrp		= $xpath->query('entry/gramGrp/*', $definition);
$gramInfo	="";
	foreach($gramGrp as $gramPt)
			{
				if($gramPt->nodeName == "itype")
					{ }
				else
					{
					$gramAdd = trim($gramPt->nodeValue);
					$gramInfo .= "{$gramAdd}";
					}
			}

$lemma = trim($definition->getAttribute("lemma")); //Get the dictionary index entry for this definition.

if	($iparts->length == 0) 
	{	$iparts = " - "; }  //If there is no data on principle parts or gender, return '-';
else
	{	$iparts = trim($iparts->item(0)->textContent);}  //Get data on principle parts or gender.	


//Begin creating the form body	
echo "<span class='lemma_choice'>";
echo "<input onclick=\"javascript: move_lemma(this.attributes.getNamedItem('value').value); \" type='radio' class='lemma' name='lemma' ";
echo "value='{$lemma}' ";
echo "id='{$lemma}' ";
echo "/>\n";
echo "<span class='orth_form' id='{$lemma}-orth'>{$orth}, {$iparts}</span>\n";
echo "<span class='misc' id='{$lemma}-misc'>{$gramInfo}</span>\n";
echo "<span class='morph_analysis' id='{$lemma}-morph'>[{$morph}]</span>\n";
echo "<br/>\n";

	//Display each definition-group's actual set of definition texts.
	$translations = $xpath->query('entry/shortDef/sense/trans/tr',$definition);
	if($translations->length > 5 )
	{
		$short_list = array();
		for($i=0; $i<5; $i++)
			$short_list[] = $translations->item($i);
		createTranslationText($lemma,$short_list, $translations);
	}
	else
	{
		createTranslationText($lemma,$translations);
	}
	
///This compresses and encodes the whole definition xml string for passing into the xml definition creation section.
///It will be removed once these parts are made object oriented into tiro. Drew. 03/02/2008
$localxml = new DOMDocument;
$localxml->appendChild($localxml->importNode($definition,true));
$zipxml = base64_encode($localxml->saveXML()); //$zipxml = base64_encode(gzcompress($localxml->saveXML()));
echo "<span class='zipxml' id='{$lemma}-zipxml' style='display: none'>{$zipxml}</span>\n";
///

	
echo "</span>";
echo  "<br/>\n";
}

//Create user editable area for definitions.  Because no dictionary definition will be quite perfect for a user, on selecting each
//possible definition, the definition data is moved into this edit box by javascript. 
echo "Term: <input id='definition_area_title' disabled='true' style='width: 20em; color: black; background-color: white; border: 0px;' value=' '> </input><br/>";
echo "<textarea rows='10' cols='50' id='definition_area' value=' '></textarea>";

echo "<input type='submit'/>";
echo "</form>";
echo "</span>";

function createTranslationText($lemma,$short_list, $long_list = null)
{
		if($long_list == null)
			$long_list = $short_list;

		foreach($short_list as $translation)
		{
		$translation_value = trim($translation->nodeValue);
		echo "		<input onclick=\"javascript:move_trans(this.value) \" type='checkbox' class='translations' name='translations' ";
		echo "value=\"{$translation_value}\" ";
		echo "/>\n";
		echo"		<span class='translation_value'>{$translation_value}</span>\n";
		echo "		<br/>\n";
		}
		
		$length = 0;
		if(!is_array($long_list))
			$length = $long_list->length;
		else
			$length = count($long_list);
		
		$js_call = "javascript:$('{$lemma}').checked='true';move_lemma($('{$lemma}').attributes.getNamedItem('value').value,false); move_trans(this.lastChild.innerHTML);";
		echo "<span onclick=\"{$js_call}\"	style='font-size: small; font-decoration:underline;'>Copy all ($length) entries";
		echo "<span style='display: none;' class='translations_all' id='flame'>";
			$outputstring ="";
			foreach($long_list as $key => $translation)
			{
			$translation_value = trim($translation->nodeValue,",.");
				if($key > 0)
					$outputstring .="-";	//Add dashes for readablity
			$outputstring .= "{$translation_value}" . ". ";
			}
			$outputstring = trim($outputstring);
		echo $outputstring;
		echo "</span></span><br/>\n";
		
}

?>
