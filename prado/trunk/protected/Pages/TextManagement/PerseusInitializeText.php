<?php
define("RDFAPI_INCLUDE_DIR", "/etc/rap/api/"); 
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


/**
 * Get Data from Perseus!
 * 
 * First, present
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2007 Matthew Katsenes
 * @package tiro-input
 * @subpackage text-management
 * @version tiro-input side v. 0.1
 */
class PerseusInitializeText extends TPage
{
	public $text;
	private $perseusRdf;
	public $textArray;

	public function onLoad()
	{
		global $ABS_PATH;
		$this->text = TextRecord::finder()->findByTitle($_GET['title']);
		
		// Query the Perseus RDF to get a list of Authors.
		$this->perseusRdf = ModelFactory::getDefaultModel();
		$this->perseusRdf->load($ABS_PATH . "/protected/Data/classics.xml");
		
		$authorQuery = <<<EOT
SELECT DISTINCT ?author
WHERE { ?perseus <http://purl.org/dc/terms/isPartOf> <Perseus:corpus:perseus,Latin Texts> .
		?perseus <http://purl.org/dc/terms/isVersionOf> ?about .
		?about <http://purl.org/dc/elements/1.1/creator> ?author
EOT;
		$authors = $this->perseusRdf->sparqlQuery($authorQuery);
		
		// Bind this list of authors to the dropdown
		foreach($authors as $author)
			$authorArray[$author['?author']->label] = $author['?author']->label;
		
		$this->authorDropDown->DataSource=$authorArray;
		$this->authorDropDown->dataBind();
		
		//Load up an array of all authors and their titles.
		foreach($authorArray as $author)
		{
				$titleQuery = <<<EOT
SELECT DISTINCT ?title ?perseus
WHERE { { ?perseus <http://purl.org/dc/terms/isPartOf> <Perseus:corpus:perseus,Latin Texts> .
		?perseus <http://purl.org/dc/terms/isVersionOf> ?about .
		?about <http://purl.org/dc/elements/1.1/creator> "$author"@en .
		?about <http://purl.org/dc/elements/1.1/title> ?title }
UNION { ?perseus <http://purl.org/dc/terms/isPartOf> <Perseus:corpus:perseus,Latin Texts> .
		?perseus <http://purl.org/dc/terms/isVersionOf> ?about .
		?about <http://purl.org/dc/elements/1.1/creator> "$author" .
		?about <http://purl.org/dc/elements/1.1/title> ?title } }
EOT;

				$titles = $this->perseusRdf->sparqlQuery($titleQuery);
		
				// Bind this list of authors to the dropdown
				foreach($titles as $title)
					$this->textArray[$author][$title['?perseus']->uri] = $title['?title']->label;			
		}
		
		$author = 'Plautus';
		$this->titleDropDown->DataSource=$this->textArray[$author];
		$this->titleDropDown->dataBind();
	}
	
	public function authorChosen($sender, $param)
	{
		$author = $sender->Text;
		
		$this->titleDropDown->DataSource=$this->textArray[$author];
		$this->titleDropDown->dataBind();
	}
	
	public function buttonClick($sender, $param)
	{
//		global $PERSEUS_SERVER;
		$perseus_id = $this->titleDropDown->SelectedValue;
		echo $perseus_id;
	}
}
?>