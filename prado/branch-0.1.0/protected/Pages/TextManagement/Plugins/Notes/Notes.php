<?php

/**
 * Get the TiroText class (and the rest of that directory) involved.
 */
prado::Using('Application.Engine.*');

class Notes extends TPage
{

	public $tiroText;
	public $html;

	/**
	 * This runs as soon as the page loads.
	 * 
	 * The class constructor is gobbled up by the "TPage" class, but it
	 * calls this baby, so fo our purposes, this is equivalent.
	 */
	function onLoad()
	{
		global $ABS_PATH,$USERS_PREFIX;
		$dbRecord = TextRecord::finder()->findByPk($_GET['id']);
		$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name;
		$this->tiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$dbRecord->dir_name);

		$xmlString = $this->tiroText->getText();
		
		$xml = new SimpleXMLElement($xmlString);
		$path = "";
		
		$this->html = "<div></div>";		
		$this->LoadLatinText($xml,$path);

		$this->LatinLabel->Text = $this->html;
	}

	/**
	 * Adds the contents of $xmlChunk to the page as
	 * properly rendered HTML with associated JavaScript.
	 * 
	 * This should recurse through the text, adding a
	 * <div class="DOMElement->nodeName"> for each element
	 * with children, and a <span id="DOMElement->nodeValue">
	 * for each element without kiddies (<term>) tag.
	 *
	 * @param $xmlChunk string raw xml string.
	 * @return string HTML for javascript access.
	 */
	function LoadLatinText($xml,$path)
	{
		if(count($xml->children()) > 0)
			foreach($xml->children() as $key => $value)
			{
				if($key != 'term')
				{
					$att_string = "";
					if( count( $value->attributes()) > 0)
					{
						$att_string .= "[";
						foreach($value->attributes() as $name => $guts)
							$att_string .= '@' . $name . '=\'' . $guts . '\' and ';
						
						$att_string = substr($att_string,0,-5);
						$att_string .= ']';
					}
					$this->appendElement($path.$key.$att_string.'/');
					$this->LoadLatinText($value,$path.$key.$att_string.'/');
				}
				else
					$this->appendText($path.(string)$key .'='.(string)$value);
			}
	}

	function appendElement($path)
	{
		$path = substr($path,0,-1);
		$nodes = explode('/',$path);
		$doc = new DomDocument;
		$doc->loadHTML($this->html);
		$query = "//";
		for($i = 0; $i < sizeof($nodes)-1;$i++)
		{
			$query .= $nodes[$i] .'/';
		}
		
		$xpath = new DomXpath($doc);
//		$results = $xpath->query($query);
	}
	
	function appendText($path)
	{
		echo "HIT appendText with path = $path <br>\n";
	}
}
?>