<?php
/**
 * AppController for Tiro
 *
 * Includes ACL stuff?
 *
 * @author Matthew Katsenes
 * @package tiro
 */
class AppController extends Controller {
	var $uses = array('User');
	var $components = array('DarkAuth');
	
	/**
	 * Runs Before whole app.
	 *
	 * Includes Auth & ACL.
	 */
	function beforeFilter() {
		//        $access = $this->Acl->check($user_id, $page, 'read');
	}


	/**
	 * Copied from DarkAuth
	 */
	function _login(){
		if(is_array($this->data) && array_key_exists('DarkAuth',$this->data) ){
			$this->DarkAuth->authenticate_from_post($this->data['DarkAuth']);
			$this->data['DarkAuth']['password'] = '';
		}
	}

	function logout(){
		$this->DarkAuth->logout();
	}
}
?>