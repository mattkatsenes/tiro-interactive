<?php
$temp =get_defined_vars();

echo "GET variables: ";
print_r($temp["_GET"]);
echo  "<br /><br/>";

echo "POST variables: ";
print_r($temp["_POST"]);
echo  "<br /><br/>";

echo "REQUEST variables: ";
print_r($temp["_REQUEST"]);
echo  "<br /><br/>";

echo "<pre><br>\n-1---------------------------------------------\n<br>";

$input_array = json_decode(stripcslashes($temp["_POST"]["param"]), true);
print_r($input_array);

echo "<br>\n--1--------------------------------------------\n<br>";

$doc = new DOMDocument();
$doc->formatOutput = true;
$doc->preserveWhiteSpace =false;
$doc->load('john.xml');
	$xpath = new DOMXPath($doc);
	
echo "<br>\n--2--------------------------------------------\n<br>";

foreach($input_array as $input)
{

	switch($input['verb'])
	{
		case	'save-note':
										echo "save\n";
										save_note($input,$xpath,$doc,$entries);
										break;		
		case	'load-note':
										echo "load\n";
										load_note($input,$xpath,$doc,$entries);
										break;	
	}
}

echo "<br>\n----3------------------------------------------\n<br>";

echo $doc->save('john.xml');
echo "<br>\n---3-------------------------------------------\n<br></pre>";


function save_note($input, $xpath,$doc, $entries)
{
		$current_page = $input['text_location'];
		$query_text = "//page[@n='$current_page']/comment";
		$entries = $xpath->query($query_text);
		
		echo "\n s-entries count = {$entries->length}\n";
		
			if($entries->length == 0)
			{
				$query_text1 = "//page[@n='$current_page']";
				$entries = $xpath->query($query_text1);
					if($entries->length == 0)
					{
							$page_xml = $doc->createElement('page');
							$page_xml->setAttribute('n',$current_page);
							$query_text2 = "/text";
							$xpath->query($query_text2)->item(0)->appendChild($page_xml);
					}
				$xpath->query($query_text)->item(0)->appendChild($doc->createElement('comment'));
				$entries = $xpath->query($query_text);
			}
			
		foreach ($entries as $entry)
			{
			$content = $input['text'];
			$entry->nodeValue = "{$content}";
			echo "entry: {$entry->nodeName} - {$entry->nodeValue}\n";
			}
		echo "\n\n";
}


function load_note($input, $xpath, $doc, $entries)
{
		$current_page = $input['text_location'];
		$query_text = "//page[@n='$current_page']/comment";
		$entries = $xpath->query($query_text);

		echo "\n l-entries count = {$entries->length}\n";

			if($entries->length == 0)
			{
				$query_text1 = "//page[@n='$current_page']";
				$entries = $xpath->query($query_text1);
					if($entries->length == 0)
					{
							$page_xml = $doc->createElement('page');
							$page_xml->setAttribute('n',$current_page);
							$query_text2 = "/text";
							$xpath->query($query_text2)->item(0)->appendChild($page_xml);
					}
				$xpath->query($query_text1)->item(0)->appendChild($doc->createElement('comment'));
				$entries = $xpath->query($query_text);
			}
		
		foreach ($entries as $entry)
			{
			echo "\n entry: {$entry->nodeName} - [[[{$entry->nodeValue}]]]\n";
			}
		echo "\n\n";
}


?>