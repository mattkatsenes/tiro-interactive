<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	
	/**
	 * List users: available to Root only.
	 */
	function index() {
		$this->DarkAuth->requiresAuth('Root');
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			/**
			 * Check Password-confirmation
			 */
			if($this->data['User']['password'] != $this->data['User']['password_confirm']) {
				$this->Session->setFlash(__('Your passwords do not match.  Please confirm.', true));
			}
			
			else {
				/**
				 * Each teacher user gets a group of the form: group_username
				 */
				$newgroup = array('Group' => array(
								'name' => 'group_'.$this->data['User']['username']));
				$this->User->Group->save($newgroup);

				/**
				 * Add this teacher to its own group, and the Teacher group (2)
				 */
				$this->data['Group']['Group'][] = $this->User->Group->getLastInsertId();
				$this->data['Group']['Group'][] = '2';
					
				/**
				 * Hash the password.
				 */
				$old_pass = $this->data['User']['password'];
				$this->data['User']['password'] = DarkAuthComponent::hasher($this->data['User']['password']);

				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('The User has been saved', true));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->data['User']['password'] = $old_pass;
					$this->Session->setFlash(__('This name is already taken. Please, choose another.', true));
				}
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function login() {
		if (!empty($this->data)) {
			$this->redirect('/');
		}
	}
}
?>