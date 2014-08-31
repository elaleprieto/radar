<?php
    /**
     * Application level Controller
     *
     * This file is application-wide controller file. You can put all
     * application-wide controller-related methods here.
     *
     * PHP 5
     *
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright 2005-2012, Cake Software Foundation, Inc.
     * (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc.
     * (http://cakefoundation.org)
     * @link          http://cakephp.org CakePHP(tm) Project
     * @package       app.Controller
     * @since         CakePHP(tm) v 0.2.9
     * @license       MIT License
     * (http://www.opensource.org/licenses/mit-license.php)
     */

    App::uses('Controller', 'Controller');
	
    /**
     * Application Controller
     *
     * Add your application-wide methods in the class below, your controllers
     * will inherit them.
     *
     * @package       app.Controller
     * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
     */
    class AppController extends Controller {
        public $components = array(
            'Session',
            'Auth' => array(
                'loginAction' => array(
                    'admin' => FALSE,
                    'controller' => 'users',
                    'action' => 'login'
                ),
                'loginRedirect' => array(
                    // 'admin' => TRUE,             # Ver
                    'controller' => 'events',
                    'action' => 'index'
                ),
                'logoutRedirect' => array(
                    'admin' => FALSE,
                    'controller' => 'events',
                    'action' => 'index'
                ),
                'authorize' => array('Controller'),
            ),
			'Facebook.Connect' => array(
            	'model' => 'User'
			),
        );
		
		public $helpers = array('Facebook.Facebook');
		public $uses = array('User');

        public function beforeFilter() {
        	# Using the session's user id is fine because it doesn't change/update
        	$id = $this->Auth->user('id');
    		$userData = $this->User->findById($id);
			
            // if ($userData['User']['role'] === 'admin') {
                // $this -> layout = 'admin';
            // } else {
	            // $this -> layout = 'default';
            // }
            
            $this -> layout = 'default';
    		$this->set('userData', $userData);
        }

        public function isAuthorized($user = null) {
            // Admin can access every action
            // if (isset($user['role']) && $user['role'] === 'admin') {
                // return true;
            // }

            # Admin users can:
            if ($user['role'] === 'admin')
                # Access to actions that start with admin_
                if (strpos($this->action, 'admin_') === 0)
                    return true;

            // Default deny
            return false;
        }
		
	/**
	 *  Facebook Plugin. Guardo los datos del usuario en la bd
	 */
		public function beforeFacebookSave(){
			$usuario = $this->Connect->user();
    		$this->Connect->authUser['User']['email'] = $this->Connect->user('email');
			$this->Connect->authUser['User']['username'] = $this->Connect->user('username');
			$this->Connect->authUser['User']['name'] = $this->Connect->user('name');
			
			if(isset($usuario['location']['name']))
				$this->Connect->authUser['User']['location'] = $usuario['location']['name'];

			if($usuario['gender']=='female'){
				$this->Connect->authUser['User']['gender'] = '1';
			} else {
				$this->Connect->authUser['User']['gender'] = '2';
			}  
			$this->Connect->authUser['User']['birthday'] = date('Y-m-d ',strtotime($this->Connect->user('birthday')));
				
			return true; //Must return true or will not save.
		}
		
		public function afterFacebookLogin(){
    		//Logic to happen after successful facebook login.
    	  	$this->redirect($this -> Auth -> redirect());
		} 
}