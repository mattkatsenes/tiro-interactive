<?php

/**
 * getParse function($inflected-latin-term)
 * 
 * @author Drew Buschhorn <drewbuschhorn@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage definition-management
 * @version tiro-input-side v. 0.2
 * @todo
 * @param string $query_term an inflected latin word.
 * @return DOMDocument an XML formatted document containing the possible parsings/definition of the given word
 */
function getParse($query_term, $return_type = "xml")
{
global $PERSEUS_SERVER;
//Create our perseus api query
$xml_chunker = $PERSEUS_SERVER . "xmlmorph2.jsp?";
$perseus_query = $xml_chunker ."lang=la" ."&" ."lookup=". $query_term;
//

//Load the perseus parsing result into $doc.
$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->preserveWhiteSpace =false;
	$doc->load($perseus_query);
//

//Create a new document to hold our xml output
//This should contain our <ParseLookupResults>
//
$result_doc = new DOMDocument();
		$result_doc->formatOutput = true;
		$result_doc->preserveWhiteSpace =false;
	$result_doc_root = $result_doc->createElement("ParseLookupResults");  //Root of xml_output
	$result_doc_root->setAttribute('status','incomplete');
		$result_doc->appendChild($result_doc_root);
//

//Collection of temporary variables
$temp_doc = new DOMDocument();		//
$temp_definitionXML = "";
$previouslyDefdLemma_array = array();
//

$xpath 	= new DOMXPath($doc);
	$analysisRoot_nodes = $xpath->query('//analysisRoot');
	
	foreach($analysisRoot_nodes as $analysisRoot_node)
		{
		$xpath 	= new DOMXPath($doc);	//Necessary to refresh the xpath within the current context.

			//Create a new xpath query using the current <analysisRoot> as the context point
			//to get the <morphAnalysis> which we assume there is only one of, per <analysisRoot>.
			$morphAnalysis_node = $xpath->query('morphAnalysis', $analysisRoot_node);
			$morphAnalysis_node = $morphAnalysis_node->item(0);  //Should be only one result, but returns a node list, so redef to a node.
			//
		
			//Create a new xpath query using the current <analysisRoot> as the context point
			//to get the <query ref="definition_url"> which we assume there is only one of.
			$analysisQuery_node = $xpath->query('lemma//query', $analysisRoot_node);
			$analysisQuery_node = $analysisQuery_node->item(0);  //Should be only one result, but returns a node list, so redef to a node.
			//
			
			$lemma = $xpath->query('analysis/lemma',$analysisRoot_node)->item(0)->nodeValue; //Should only be one lemma, same as with <query>
			if(in_array($lemma, $previouslyDefdLemma_array))
				{
				//If is this lemma is already defined in the output xml, then we only want to find out what
				//its parse info/<morphAnalysis> is, and to add that to the already given definition of this lemma.
				$result_doc_xpath = new DOMXPath($result_doc);		//We get the output xml node which contains the already defined lemma
				$query = "//Definition[@lemma='{$lemma}']";					//because we are just appending a new <morphAnalysis> to the 
				$old_def =	$result_doc_xpath->query($query);				//<Definition lemma="X"> not creating a new <Definition>
				$old_def = $old_def->item(0);	//Should only be one matching lemma
				
				$old_def->appendChild($result_doc->importNode($morphAnalysis_node,true));
				}
			else
				{
					$previouslyDefdLemma_array[] = $lemma;		//Adds <lemma> into defdLemma array for future comparison
				
					if($analysisQuery_node->getAttribute('name') == "Elem. Lewis")	//Make sure we're pulling the right type of definition.  May need to be changed later.
						$temp_definitionXML = getDefinition($analysisQuery_node->getAttribute('ref'));  //pull <query @ref="defintion_url">, push to getDefinition(defintion_url) which returns the entry;
					else
						$temp_definitionXML = "<Definition lemma='invalid dictionary'></Definition>";
					
					$temp_doc->loadXML($temp_definitionXML);		//Create and load a XML doc from the result of getDefinition.
						$xpath = new DOMXPath($temp_doc);
					
					$definition_nodes = $xpath->query('/Definition');  //getDefinition has <Definition> as root, so pull those and add to the result doc.
					foreach($definition_nodes as $definition_node)
						{
						$definition_node->setAttribute("lemma",$lemma);	//Need to add a @lemma handle for seeing if a lemma has been definied already.
						$definition_node->appendChild($temp_doc->importNode($morphAnalysis_node, true));
						
						$result_doc_root->appendChild($result_doc->importNode($definition_node, true));
						}
				}
		}
		
	if($result_doc_root->childNodes->length == 0)
		$result_doc_root->setAttribute('status','failed');
	else
		$result_doc_root->setAttribute('status','complete');
		
	return $result_doc;
}


/**
 * getDefinition function($query_term_url)
 * 
 * @author Drew Buschhorn <drewbuschhorn@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage definition-management
 * @version tiro-input-side v. 0.2
 * @todo add ability to output as a simple text string.  Split definitions by &emdash; to make each type of meaning more clear.
 * @param string $query_term_url Output of <query ref="query_term_url"> from morph2.jsp
 * @return string an XML formatted document containing the definition of the given latin lemma signified by $query_term_url
 */
function getDefinition($query_term_url, $return_type = "xml", $short_definition=null)
{
//Create our perseus api query
$xml_chunker = "http://www.tiro-interactive.org/hopper/xmlchunk.jsp?doc=";
$perseus_query = $xml_chunker . $query_term_url;
//

//Load the perseus dictionary entry into $doc.
$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->preserveWhiteSpace =false;
	$doc->load($perseus_query);
//

//Create a new document to hold our xml output
//This should contain only the dictionary definitions xml for our query
//with also a shortened form of the entry called <shortDef> appended into entry
$result_doc = new DOMDocument();
		$result_doc->formatOutput = true;
		$result_doc->preserveWhiteSpace =false;
	$result_doc_root = $result_doc->createElement("Definition");
		$result_doc->appendChild($result_doc_root);
//

//This loads up the entries from the dictionary associated with our lemma
$xpath 	= new DOMXPath($doc);
	$LemmaEntry_nodes		=	$xpath->query('//entry');
	
foreach($LemmaEntry_nodes as $LemmaEntry_node)
{
	// if there is more than one entry, we want all of them copied over, and thier children.
	$ImportedLemmaEntry_node = $result_doc->importNode($LemmaEntry_node,true);

	//Create the shortDef element for adding the new definition data to.
	$QuickDefinition_node = $result_doc->createElement("shortDef");	

	if($short_definition != null)
	{
			$CreatedTranslation_node = $result_doc->createElement("trans");
			$CreatedTranslation_node->setAttribute('created','true');
			$CreatedTranslation_node->setAttribute("opt","n");
			$CreatedTranslation_node->nodeValue = $short_definition;
			
			$QuickDefinition_node->appendChild($CreatedTranslation_node);
	}
	else
	{	
		$Sense_nodes = $xpath->query('sense',$LemmaEntry_node);
		foreach($Sense_nodes as $Sense_node)
		{
			$new_doc = new DOMDocument();
				$new_doc->appendChild($new_doc->importNode($Sense_node,true));
			$val =  trim(strip_tags($new_doc->saveXML()));
				$matches=explode('&#x2014;',$val);
			 
			 foreach($matches as $key => $match)
			{
			$match = trim($match);
				if(!empty($match))
				{
				$first_match = strpos($match,':');
						if($first_match > 10)
							$match = substr($match,0,$first_match);
						else
						{ 
							$second_match = strpos($match,':',$first_match+1);
							if( ($second_match <= 0) || ($second_match === false))
								$second_match = strlen($match);
							$match = substr($match,0, $second_match);	//Get second string match
						}
				}
			$match = preg_replace("/[0-9]? [A-Z]+-[\,\.\;]?/","",$match);	//Get rid of etymological notes, "1 CUR-"
			$match = trim($match);
			$matches[$key] = $match;
			}
							
			$matches = array_filter($matches, "notEmpty");
			
			$sense = $QuickDefinition_node->ownerDocument->importNode($Sense_node,false);
			foreach($Sense_node->attributes as $attrs)
				$sense->setAttribute($attrs->nodeName,$attrs->nodeValue);

			foreach($matches as $match)
			{
				$trans_node 	= $result_doc->createElement('trans');
					$trans_node->setAttribute("opt","n");
					$tr_node	= $result_doc->createElement('tr');
						$tr_node->setAttribute("opt","n");
						$tr_node->nodeValue = $match;
			
					$trans_node->appendChild($tr_node);
				$sense->appendChild($trans_node);
			}
		$QuickDefinition_node->appendChild($sense);
		}
	}
//Add our <shortDef> node to the <entry> node, (placing it first in the list), which is now prepared for returning.
$QuickDefinition_node = $ImportedLemmaEntry_node->insertBefore($QuickDefinition_node,$ImportedLemmaEntry_node->childNodes->item(0));	

//Add our new modified <entry> node to the root <Definition> node;
$result_doc_root->appendChild($ImportedLemmaEntry_node);
}
return $result_doc->saveXML();
}




////////////////
function stripTags($xmlNode)
{
$resultString ="";

$doc = new DOMDocument();
	$doc->formatOutput = true;
	$doc->preserveWhiteSpace =true;
	$doc->appendChild($doc->importNode($xmlNode,true));

$resultString = $doc->saveXML();
$resultString = strip_tags($resultString);

return $resultString;
}
function uniord($c) {
    $h = ord($c{0});
    if ($h <= 0x7F) {
        return $h;
    } else if ($h < 0xC2) {
        return false;
    } else if ($h <= 0xDF) {
        return ($h & 0x1F) << 6 | (ord($c{1}) & 0x3F);
    } else if ($h <= 0xEF) {
        return ($h & 0x0F) << 12 | (ord($c{1}) & 0x3F) << 6
                                 | (ord($c{2}) & 0x3F);
    } else if ($h <= 0xF4) {
        return ($h & 0x0F) << 18 | (ord($c{1}) & 0x3F) << 12
                                 | (ord($c{2}) & 0x3F) << 6
                                 | (ord($c{3}) & 0x3F);
    } else {
        return false;
    }
}

			function notEmpty($givenValue)
							{ 
								if(strlen($givenValue) > 5) 
								return true; 
								else 
								return false;
							};

?>