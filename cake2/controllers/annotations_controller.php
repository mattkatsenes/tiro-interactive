<?php
class AnnotationsController extends AppController {

	var $name = 'Annotations';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Annotation->recursive = 0;
		$this->set('annotations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Annotation.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('annotation', $this->Annotation->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Annotation->create();
			if ($this->Annotation->save($this->data)) {
				$this->Session->setFlash(__('The Annotation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Annotation could not be saved. Please, try again.', true));
			}
		}
		$projects = $this->Annotation->Project->find('list');
		$this->set(compact('projects'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Annotation', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Annotation->save($this->data)) {
				$this->Session->setFlash(__('The Annotation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Annotation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Annotation->read(null, $id);
		}
		$projects = $this->Annotation->Project->find('list');
		$this->set(compact('projects'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Annotation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Annotation->del($id)) {
			$this->Session->setFlash(__('Annotation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>