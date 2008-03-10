<?php

Prado::Using('Application.Engine.*');

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
		
		if($_GET['doc'])
			$this->confirmChunk($_GET['doc']);
		elseif(!$this->IsPostBack)
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
		
		/**
		 * Load up the Perseus TOC
		 */
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
		
		$this->ChoicesMultiView->ActiveView = $this->ToCView;
	}
	
	/**
	 * Chunk Chosen
	 */
	public function confirmChunk($chunk_id)
	{
		if($this->IsPostBack)
			$this->addChunk($chunk_id);
		else
		{
			$this->ChoicesMultiView->ActiveView = $this->ChunkView;
			global $PERSEUS_SERVER;
			require_once "HTTP/Request.php";

			$req =& new HTTP_Request($PERSEUS_SERVER . 'xmlchunk.jsp?doc=' . $chunk_id);
			if (!PEAR::isError($req->sendRequest()))
				$chunkString = $req->getResponseBody();
			
			$this->ChunkText->Controls[] = $chunkString;
		
			$submit = new TButton;
			$submit->Text = 'Insert this text';
		
			$this->ChunkText->Controls[] = $submit;
		}
	}
	
	public function addChunk($chunk_id)
	{
		$perseusChunk = new PerseusChunk($chunk_id);

		global $ABS_PATH,$USERS_PREFIX;
		$path = $ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name;
		$myTiroText = new TiroText($ABS_PATH.'/'.$USERS_PREFIX.'/'.$this->User->Name.'/'.$this->text->dir_name);
		
		$myTiroText->addPerseusChunk($perseusChunk);
		$myTiroText->saveText();
	}

}
?>