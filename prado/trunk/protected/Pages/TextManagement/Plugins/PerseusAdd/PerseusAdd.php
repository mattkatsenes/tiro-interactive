<?php

/**
 * Add text chosen from Perseus.
 * 
 * This uses the hard-coded arrays $AUTHOR_ARRAY and 
 * $TEXT_ARRAY because RDF processing is incredibly slow.
 * 
 * @author Matthew Katsenes <psalakanthos@gmail.com>
 * @copyright Copyright (c) 2008 Matthew Katsenes
 * @package tiro-input
 * @subpackage plugins
 * @version tiro-input side v. 0.2
 */
class PerseusAdd extends TPage
{
	public $text;
	/**
	 * Load the page and choose the View.
	 * 
	 * If we are loading for the first time, go to Author.
	 * Otherwise, someone else should've reset it.
	 */
	public function onLoad()
	{
		$this->text = TextRecord::finder()->findByPk($_GET['id']);
		
		if(!$this->IsPostBack)
			$this->loadAuthorView();
	}
	
	public function loadAuthorView()
	{
		global $AUTHOR_ARRAY;
		$this->AuthorList->DataSource=$AUTHOR_ARRAY;
		$this->AuthorList->dataBind();
		$this->ChoicesMultiView->ActiveView = $this->AuthorView;		
	}
	
	public function authorChosen($sender,$param)
	{
		global $AUTHOR_ARRAY, $TEXT_ARRAY;
		$author_index = $param->Index;
		$author = $AUTHOR_ARRAY[$author_index];
		$this->AuthorName->Text = $author;
		
		$this->TextList->DataTextField="title";
		$this->TextList->DataValueField="perseus";
		$this->TextList->DataSource=$TEXT_ARRAY[$author];
		$this->TextList->dataBind();
		
		$this->ChoicesMultiView->ActiveView = $this->TextView;
	}
	
	public function textChosen($sender,$param)
	{
		$this->ToCAuthorName->Text = $this->AuthorName->Text;
		$this->ToCTextName->Text = $sender->Items->offsetGet($param->Index)->Text;
		$this->ToCPerseus->Text = $sender->Items->offsetGet($param->Index)->Value;
		
		$this->ChoicesMultiView->ActiveView = $this->ToCView;
	}
	
	/**
	 * Add Button clicked
	 * 
	 * Check to see if the author has another text with this title.
	 * Check for a non-unique 'directory' since this is the PK.
	 * Make the directories and default files.
	 */
	public function addChunk($sender, $param)
	{
		global $PERSEUS_SERVER;
		
		require_once "HTTP/Request.php";

		$req =& new HTTP_Request($PERSEUS_SERVER . 'xmltoc.jsp?doc=' . $this->ToCPerseus->Text);
		if (!PEAR::isError($req->sendRequest()))
			$tocString = $req->getResponseBody();
		
		$tocXml = new DomDocument;
		$tocXml->loadXML($tocString);
		
		$stylesheet = new DomDocument;
		$stylesheet->load('protected/Pages/TextManagement/Plugins/PerseusAdd/sidetoc.xsl');

		$proc = new XSLTProcessor;
		$proc->importStyleSheet($stylesheet);
		$tocXml->loadXML($proc->transformToXML($tocXml));

		$this->TableOfContents->Controls[] = $tocXml->saveHTML();
	}
}
?>