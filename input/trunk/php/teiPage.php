<?
// teiPage.php
// a class to hold data about TEI compliant xml pages

include "tei_headword.php";

class teiPage {
	private $xml; //DOMDocument holding the TEI-compliant xml
	
	function __construct($string_or_file)
	{
		$this->xml = new DOMDocument;
		if(file_exists($string_or_file)) // file
			$this->xml->load($string_or_file);
		else // string
			$this->xml->loadXML($string_or_file);
		
		$this->xml->preserveWhiteSpace = false;
	}

	function outXML()
	{
		$this->xml->preserveWhiteSpace = true;
		$this->xml->formatOutput = true;
		echo htmlspecialchars($this->xml->saveXML());
	}
	
	function saveXML()
	{
		$this->xml->preserveWhiteSpace = false;
		$this->xml->formatOutput = true;
		return $this->xml->saveXML();
	}
	
	function save($filename)
	{
		$this->xml->formatOutput = true;
		$this->xml->save($filename);
	}
	
	function outDisplay()
	{
		
	}
	
	function outAnnotateDef()
	{
		$xpath =  new DOMXpath($this->xml);
		$query = "//div[@n='text']/*";
		
		$text_elements = $xpath->query($query); //DOMNodeList
		
// WORK HERE
// Possibilities: a) line/block of text with no annotations: <l xml:id="text.1">blah blab eadsf</l>
//				  b) line/block with annotations: <l xml:id="text.1">blah <term xml:id="text.1.blab">blab</term> eadsf</l>
// Solution: $defined[$id] = [words, defined, in, this, line]
		echo "<pre>";
		$defined;
		
		foreach($text_elements as $block)
		{
			$id = $block->attributes->getNamedItem("id")->nodeValue;
			$text_blocks[$id] = $block->nodeValue;
			$defined[$id][] = "";
			if($block->childNodes->length > 1)		// Annotation
				foreach($block->childNodes as $kiddy)
				{
					if($kiddy->nodeName == 'term')
						$defined[$id][] = $kiddy->nodeValue;
				}
		}
		
		$punctuation = Array(',','.','?','"','\'',';',':','!','*');
		$replacements = Array('','','','','','','','','');
				
		foreach($text_blocks as $id => $block)
		{
				$words = explode(' ',$block);
				echo "$id : ";
				foreach($words as $word)
				{
					$target = str_replace($punctuation,$replacements,$word);
					if(in_array($target,$defined[$id]))
						echo "<span class=\"word defined\"name=\"{$id}.{$target}\">$word</span> ";  // OR class="word defined"						
					else
						echo "<span class=\"word\"name=\"{$id}.{$target}\">$word</span> ";  // OR class="word defined"
				}
				echo "<br />\n";
		}
		
		
	}
	
	function outAnnotateNote()
	{
		
	}
	
	function addPoetryLine($number,$content)
	{
		$xpath = new DOMXpath($this->xml);
		$query = "//div[@n='text']";
		
		$text = $xpath->query($query)->item(0); //DOMNode
		$line = $this->xml->createElement('l',$content);
		$line->setAttribute('xml:id',"text.$number");
		$text->appendChild($line);
	}
	
	function removeEntry($term_id)
	{
		$xpath = new DOMXpath($this->xml);
		$query = "//term[@xml:id='$term_id']";

		$term = $xpath->query($query)->item(0);
		
		$text = $this->xml->createTextNode($term->textContent);
		$term->parentNode->replaceChild($text,$term);
		
		// Now remove the glossary if it needs to be removed
		$query = "//link[contains(@targets,'$term_id')]";
		$link = $xpath->query($query)->item(0);
		
		$targets = $link->getAttribute('targets');
		$target_arr = preg_split('/#/',$targets);
		
//		print_r($target_arr);
		
		if(sizeof($target_arr) > 3) // KEEP THE ENTRY  ... untested
		{
			$new_target = "";
			foreach($target_arr as $possible)
				if(preg_match("/$term_id/",$possible))
					unset($possible);
				else
					$new_target = $new_target . "#" . $possible;
			
			$new_link = $this->xml->createElement('link');
			$new_link->setAttribute('targets',$new_target);
			$link->parentNode->replaceChild($new_link,$link);
		}
		else	// Remove it from the glossary .. not yet working
		{
			$target_text = trim($target_arr[1]);
			$query = "//entry[@xml:id='$target_text']";
			$entry = $xpath->query($query)->item(0);
			
			$entry->parentNode->removeChild($entry);
			$link->parentNode->removeChild($link);
		}
	}
	
	function addEntry($entry,$target) //$entry is a teiHeadword();
	{
		$xpath = new DOMXpath($this->xml);
		$query = "//div[@n='glossary']";
		
		$glossary = $xpath->query($query)->item(0); //DOMNode
		
		$new_entry = $this->xml->importNode($entry->word->documentElement,true); //Import to our document
		
		$glossary->appendChild($new_entry);
		$link = $this->xml->createElement('link');
		
		preg_match('/\b.+?\b/',$entry->getParam('orth'),$matches); //get out the first bit from the orth form for the "link"
		
		$link_target = $matches[0];
		
		$link->setAttribute('targets','#g.' . $link_target . ' #' . $target);
		$glossary->appendChild($link);
		
		// Also make a <term> tag in the body of the text... DONE 08/20/2007
		// Find $target in text.
		preg_match('/(.+)\.(\b.+\b)$/',$target,$matches);
//		print_r($matches);
		$line = $matches[1];		// $matches[1] = text.line_number
		$word = $matches[2];		// $matches[2] = inflected_form
		$query = "//l[@xml:id='$line']";

		$line_dom = $xpath->query($query)->item(0);
		$bits = $line_dom->childNodes; // all children of this 
				
		foreach($bits as $chunk)
			if(preg_match("/$word/",$chunk->nodeValue))
			{
				
				$subnodes = preg_split("/$word/",$chunk->nodeValue);
				
				$nodeA = $this->xml->createTextNode($subnodes[0]);	// bit before $word
				$nodeB = $this->xml->createElement('term',$word);	// <term> subnode
				$nodeB->setAttribute('xml:id',$target);
				$nodeC = $this->xml->createTextNode($subnodes[1]);	// bit afterward
				
				$line_dom->replaceChild($nodeC,$chunk);
				$line_dom->insertBefore($nodeB,$nodeC);
				$line_dom->insertBefore($nodeA,$nodeB);
			}
	}

	function outputDefinitions()
	{
		$xpath = new DOMXpath($this->xml);
		$query = "//div[@n='glossary']";
		
		$glossary = $xpath->query($query)->item(0); //DOMNode
		
		// Output them prettily.
		
		foreach($glossary->childNodes as $entry)
		{
			if($entry->nodeName == 'entry')
			{
				$entry_hw = new teiHeadword($entry);
				$entry_hw->Output();
			}
		}
	}
}
?>
