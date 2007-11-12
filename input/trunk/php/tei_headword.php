<?

class teiHeadword {
	
	public $word;
	
	function __construct() {				
		// You can pass it a DOMNode which is in the correct format.
		if(func_num_args() > 0)
		{
			$passed_entry = func_get_arg(0);
			
			$this->word = new DOMDocument();
			$imported = $this->word->importNode($passed_entry,true);
			$this->word->appendChild($imported);
		}
		else
		{
			$this->word = new DOMDocument();
			$entry = $this->word->createElement('entry');
			$this->word->appendChild($entry);
			
			$form = $this->word->createElement('form');
			$entry->appendChild($form);
			
			$orth = $this->word->createElement('orth');
			$form->appendChild($orth);
			
			
			$gramGrp = $this->word->createElement('gramGrp');
			$entry->appendChild($gramGrp);
			
			$pos = $this->word->createElement('pos');
			$gramGrp->appendChild($pos);
			
			$gen = $this->word->createElement('gen');
			$gramGrp->appendChild($gen);
			
			$subc = $this->word->createElement('subc');
			$gramGrp->appendChild($subc);
			
			$def = $this->word->createElement('def');
			$entry->appendChild($def);
		}
	}
	
	function addParam($param, $value) {
		$list = $this->word->getElementsByTagName($param);
		if($list->length != 1)
			echo "This shouldn't happen.  Oops.";
		else
		{
			$node = $list->item(0);
			$node->nodeValue = $value;
			if($param == 'orth')
			{
				preg_match('/\b.+?\b/',$value,$matches); //get out the first bit from the orth form for the "link"
				$link_target = $matches[0];
				$this->word->documentElement->setAttribute('xml:id',"g.$link_target");
			}
		}
	}

	function getParam($param)
	{
		$xpath = new DOMXpath($this->word);
		$value = $xpath->evaluate("//$param")->item(0)->nodeValue;
		return $value;
	}
	
	function Output() {
		$xpath = new DOMXpath($this->word);
		$orth = $xpath->evaluate('//orth')->item(0)->nodeValue;
		$pos = $xpath->evaluate('//pos')->item(0)->nodeValue;
		$gen = $xpath->evaluate('//gen')->item(0)->nodeValue;
		$subc = $xpath->evaluate('//subc')->item(0)->nodeValue;
		$def = $xpath->evaluate('//def')->item(0)->nodeValue;

		echo <<<EOT
<span class="definition">
<span class="orth">$orth</span> <span class="pos">$pos</span> 
EOT;
		if($pos == 'n')
			echo <<<EOT
<span class="gen">($gen)</span> <span class="subc">$subc</span> - <span class="def">$def</span>
</span><br />
EOT;
		else
			echo <<<EOT
<span class="subc">$subc</span> - <span class="def">$def</span>
</span><br />
EOT;
	}
	
	function prettyOutput()	{
		$xpath = new DOMXpath($this->word);
		$orth = $xpath->evaluate('//orth')->item(0)->nodeValue;
		$pos = $xpath->evaluate('//pos')->item(0)->nodeValue;
		$gen = $xpath->evaluate('//gen')->item(0)->nodeValue;
		$subc = $xpath->evaluate('//subc')->item(0)->nodeValue;
		$def = $xpath->evaluate('//def')->item(0)->nodeValue;
		
		echo <<<EOT
<table>
<tr><td>Entry</td><td><input type="text" size="40" name="orth" value="$orth" /></td></tr>
<tr><td>Part of Speech</td><td><input type="text" size="5" name="pos" value="$pos" /></td></tr>
EOT;
		if($pos == 'n')
			echo <<<EOT
<tr><td>Gender</td><td><input type="text" size="5" name="gen" value="$gen" /></td></tr>
EOT;
		echo <<<EOT
<tr><td>Extra Info</td><td><input type="text" size="30" name="subc" value="$subc" /></td></tr>
<tr><td>Definition</td><td><input type="text" size="80" name="def" value="$def" /></td></tr>
</table>
EOT;
	}
}



?>
