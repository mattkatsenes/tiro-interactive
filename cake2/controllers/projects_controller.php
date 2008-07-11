<?php
class ProjectsController extends AppController {

	var $name = 'Projects';
	var $helpers = array('Html', 'Form','Javascript','Ajax');
	var $components = array('TiroText');
	var $_DarkAuth;
	
	/**
	 * Projects Index
	 * 
	 * Shows a registered user his projects.
	 */
	function index() {
		$this->User->recursive = 1;
		$user_id = $this->DarkAuth->current_user['User']['id'];
		$user = $this->User->find(array('id' => $user_id));
		
		$this->set('projects',$user['Project']);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Project.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$project = $this->Project->read(null, $id);

		if($project['User'] != $this->DarkAuth->getUserInfo() ) {
			$this->Session->setFlash("Invalid Project.");
			$this->redirect(array('action'=>'index'));
		}
		
		$this->TiroText->loadText($id);
		$this->set('pretty',$this->TiroText->getTextPretty());
		$this->set(compact('project'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Project->create();
			$user = $this->DarkAuth->getUserInfo();
			$this->data['Project']['user_id'] = $user['id'];
			
			if ($this->Project->save($this->data)) {
				$this->Session->setFlash(__('The Project has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Project could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null,$latin_text = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Project', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Project->save($this->data)) {
				$this->Session->setFlash(__('The Project has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Project could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}

		$this->TiroText->loadText($id);
		
		$this->set('sections',$this->TiroText->getSectionsPlain());
	}
	
	/**
	 * Copy & Paste in Latin Text
	 *
	 * @param int $id
	 */
	function textAdd($id = null) {
		$this->layout = 'ajax';
		if(!$id) {
			$this->Session->setFlash(__('Invalid id for Project', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$project = $this->Project->read(null, $id);
		
		if($project['User'] != $this->DarkAuth->getUserInfo() ) {
			$this->Session->setFlash("Invalid Project.");
			$this->redirect(array('action'=>'index'));
		}
		
		$this->TiroText->loadText($id);
		
		if(!empty($_POST['value'])) {
			$this->TiroText->deleteSection($_POST['editorId']);
			$newId = $this->TiroText->addRawText($_POST['value']);
		}
		
		$section = $this->TiroText->getSection($newId);
		
		$this->set(compact('section'));
		$this->set('id',$newId);
	}
	
	function perseusAdd() {
		//add text from Perseus
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Project', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Project->del($id)) {
			$this->Session->setFlash(__('Project deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>