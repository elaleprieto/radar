<?php
    App::uses('AppController', 'Controller');
    App::uses('CakeEmail', 'Network/Email');
    /**
     * Users Controller
     *
     * @property User $User
     */
    class UsersController extends AppController {

        public function beforeFilter() {
            parent::beforeFilter();
            // $this -> Auth -> allow('contactar', 'mailup', 'logout');
            $this->Auth->allow('add', 'callbackTwitter', 'loginTwitter', 'edit', 'logout');
            // $this -> Auth -> allow('contactar');
        }

        /**
         * contactar method
         * Se utiliza por el formulario de contacto para enviar el mensaje.
         * @return void
         */
        public function contactar() {
            $this -> autoRender = FALSE;
            if ($this -> request -> isPost() && isset($this -> request -> data)) {
                # Validación de Campos
                $contacto = $this -> request -> data['Contacto'];
                if (isset($contacto['nombre']) && $contacto['nombre'] !== '' && isset($contacto['remitente']) && $contacto['remitente'] !== '' && isset($contacto['asunto']) && $contacto['asunto'] !== '' && isset($contacto['mensaje']) && $contacto['mensaje'] !== '') {

                    App::import('Vendor', 'contras', array('file' => 'contras.php'));

                    # Se crea el mensaje
                    $mensaje = 'Enviado por: ' . $contacto['nombre'] . "\n";
                    $mensaje .= 'Mail de contacto: ' . $contacto['remitente'] . "\n";
                    $mensaje .= 'Asunto del mensaje: ' . $contacto['asunto'] . "\n";
                    $mensaje .= 'Mensaje: ' . $contacto['mensaje'];

                    # Se envía el mensaje
                    mail(TO, ASUNTO, $mensaje, 'From: ' . FROM);
                    // $this->redirect('/contacto');
                    return json_encode(true);
                }
            }
            return json_encode(false);
        }

        # Prueba de correo... Se puede borrar o dejar para pruebas
        // public function mailup() {
        // $this->autoRender = FALSE;
        // App::import('Vendor', 'contras', array('file' => 'contras.php'));
        // echo mail(TO, ASUNTO, 'Cuerpo del mensaje', 'From: ' . FROM);
        // }

        public function login() {
            // $this -> layout = 'login';

            if ($this -> request -> is('post')) {
                if ($this -> Auth -> login()) {
                    $this -> redirect($this -> Auth -> redirect());
                } else {
                    $this -> Session -> setFlash(__('Invalid username or password, try again'));
                }
            }
        }

        public function logout() {
        	//Logout según Cakephp
            //$this -> redirect($this -> Auth -> logout());
			
			//Logout a partir de plugin de facebook
			if ($this->Connect->FB->getUser() == 0){
                    $this->redirect($this->Auth->logout());
        	} else {
                //ditch FB data for safety
                $this->Connect->FB->destroysession();
                //hope its all gone with this
        		session_destroy();
                //logout and redirect to the screen that you usually do.
        		$this->redirect($this->Auth->logout());
        	}
		}

        public function isAuthorized($user) {
            // All registered users can add posts
            // if ($this -> action === 'add') {
            // return true;
            // }
            
            // Todos los usuarios registrados podrán cambiar su location
            if ($this->action === 'setLocation') {
            	return true;
            }

            // The owner of a post can edit and delete it
            // if (in_array($this -> action, array(
            // 'edit',
            // 'delete'
            // ))) {
            // $postId = $this -> request -> params['pass'][0];
            // if ($this -> Post -> isOwnedBy($postId, $user['id'])) {
            // return true;
            // }
            // }

            return parent::isAuthorized($user);
        }

        // /**
        // * index method
        // *
        // * @return void
        // */
        // public function _index() {
        // $this -> User -> recursive = 0;
        // $this -> set('users', $this -> paginate());
        // }
        //
        // /**
        // * view method
        // *
        // * @throws NotFoundException
        // * @param string $id
        // * @return void
        // */
        // public function _view($id = null) {
        // $this -> User -> id = $id;
        // if (!$this -> User -> exists()) {
        // throw new NotFoundException(__('Invalid user'));
        // }
        // $this -> set('user', $this -> User -> read(null, $id));
        // }
        //
     
        /**
         * add method
         *
         * @return void
         */
        public function add() {		
            if ($this -> request -> is('post')) {
                $this -> User -> create();		            
                if ($this -> User -> save($this -> request -> data)) {
                    $id = $this -> User -> id;
                    $this -> request -> data['User'] = array_merge($this -> request -> data['User'], array('id' => $id));
                    $this -> Auth -> login($this -> request -> data['User']);
                    $this -> redirect(array(
                        'controller' => 'events',
                        'action' => 'index'
                    ));               	
                } else {
                	 $this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
                }
            }
        }

   	

		/**
         * edit method
         *
         * @throws NotFoundException
         * @param string $id
         * @return void
         */
        public function edit($id = null) {
            $this -> User -> id = $id;
            if (!$this -> User -> exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            if ($this -> request -> is('post') || $this -> request -> is('put')) {
                if ($this -> User -> save($this -> request -> data)) {
                    $this -> Session -> setFlash(__('The user has been saved'));
                    $this -> redirect(array('action' => 'index'));
                } else {
                    $this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this -> request -> data = $this -> User -> read(null, $id);
            }
        }


		public function loginTwitter() {
			App::import('Vendor', 'twitteroauth/twitteroauth');

			define('CONSUMER_KEY', 'gJos51nlduv7o47481Mg4A');
			define('CONSUMER_SECRET', 'rwa1AfOL2vbnPrrHoYcdHaLd4m37x4fDEGc0Pm11Q');
			define('OAUTH_CALLBACK', Router::url(array('controller'=>'users', 'action'=>'callbackTwitter'), true));
			
			$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
			$twitterAux = $twitter->getRequestToken(OAUTH_CALLBACK);
			CakeSession::write('twitter_token_aux', $twitterAux['oauth_token']);
			CakeSession::write('twitter_token_secret_aux', $twitterAux['oauth_token_secret']);
			
			$twitterURL = $twitter->getAuthorizeURL($twitterAux['oauth_token']);
			$this->redirect($twitterURL);
	    }
	
	    public function callbackTwitter() {
	        App::import('Vendor', 'twitteroauth/twitteroauth');

			define('CONSUMER_KEY', 'gJos51nlduv7o47481Mg4A');
			define('CONSUMER_SECRET', 'rwa1AfOL2vbnPrrHoYcdHaLd4m37x4fDEGc0Pm11Q');
			define('OAUTH_CALLBACK', '/users/callbackTwitter');
			
			$twitter = new TwitterOAuth(CONSUMER_KEY
				, CONSUMER_SECRET
				, CakeSession::read('twitter_token_aux')
				, CakeSession::read('twitter_token_secret_aux')
			);
			$twitterToken = $twitter->getAccessToken($this->request->query['oauth_verifier']);
			
			if($twitter->http_code == 200) {
				CakeSession::write('twitter_token', $twitterToken['oauth_token']);
				CakeSession::write('twitter_token_secret', $twitterToken['oauth_token_secret']);
				CakeSession::write('twitter_status', true);
				
				$twitter = new TwitterOAuth(CONSUMER_KEY
					, CONSUMER_SECRET
					, $twitterToken['oauth_token']
					, $twitterToken['oauth_token_secret']
				);
				
				# Se obtienen los datos de twitter
				$twitterData = $twitter->get('account/verify_credentials');
				
				# Se busca el usuario a través del id de twitter
				$existentUser = $this->User->find('first', array('conditions' => array('User.twitter_id' => $twitterData->id)));
				
				# Si no existe, se crea y se logea con él. Si existe, sólo se logea.
				if(sizeof($existentUser) == 0) {
					$user['User']['username'] = 'tw_'.$twitterData->screen_name; 
					$user['User']['password'] = $twitterToken['oauth_token']; 
					$user['User']['name'] = $twitterData->name; 
					$user['User']['location'] = $twitterData->location; 
					$user['User']['twitter_id'] = $twitterData->id;
					
					$this->User->create();
					if($this->User->save($user)) {
						$user = $this->User->read(null, $this->User->id);
	                    $this->Auth->login($user['User']);
					} else {
						$this->redirect(Router::url(array('controller'=>'users', 'action'=>'login')));
					}
				} else {
                    $this->Auth->login($existentUser['User']);
				}
				
				# Se redirige al inicio.
                $this->redirect(array('controller' => 'events', 'action' => 'index'));
			}
	    }

	public function setLocation($id = null, $location = null) {
		$this->autoRender = false;
		if($id && $location) {
			$this->User->id = $id;
			$this->User->saveField('location', $location);
		}
	}
		

        //
        // /**
        // * delete method
        // *
        // * @throws MethodNotAllowedException
        // * @throws NotFoundException
        // * @param string $id
        // * @return void
        // */
        // public function _delete($id = null) {
        // if (!$this -> request -> is('post')) {
        // throw new MethodNotAllowedException();
        // }
        // $this -> User -> id = $id;
        // if (!$this -> User -> exists()) {
        // throw new NotFoundException(__('Invalid user'));
        // }
        // if ($this -> User -> delete()) {
        // $this -> Session -> setFlash(__('User deleted'));
        // $this -> redirect(array('action' => 'index'));
        // }
        // $this -> Session -> setFlash(__('User was not deleted'));
        // $this -> redirect(array('action' => 'index'));
        // }
        //
        // /**
        // * admin_index method
        // *
        // * @return void
        // */
        // public function _admin_index() {
        // $this -> User -> recursive = 0;
        // $this -> set('users', $this -> paginate());
        // }
        //
        // /**
        // * admin_view method
        // *
        // * @throws NotFoundException
        // * @param string $id
        // * @return void
        // */
        // public function _admin_view($id = null) {
        // $this -> User -> id = $id;
        // if (!$this -> User -> exists()) {
        // throw new NotFoundException(__('Invalid user'));
        // }
        // $this -> set('user', $this -> User -> read(null, $id));
        // }
        //
        // /**
        // * admin_add method
        // *
        // * @return void
        // */
        // public function _admin_add() {
        // if ($this -> request -> is('post')) {
        // $this -> User -> create();
        // if ($this -> User -> save($this -> request -> data)) {
        // $this -> Session -> setFlash(__('The user has been saved'));
        // $this -> redirect(array('action' => 'index'));
        // } else {
        // $this -> Session -> setFlash(__('The user could not be saved. Please,
        // try again.'));
        // }
        // }
        // }
        //
        // /**
        // * admin_edit method
        // *
        // * @throws NotFoundException
        // * @param string $id
        // * @return void
        // */
        // public function _admin_edit($id = null) {
        // $this -> User -> id = $id;
        // if (!$this -> User -> exists()) {
        // throw new NotFoundException(__('Invalid user'));
        // }
        // if ($this -> request -> is('post') || $this -> request -> is('put')) {
        // if ($this -> User -> save($this -> request -> data)) {
        // $this -> Session -> setFlash(__('The user has been saved'));
        // $this -> redirect(array('action' => 'index'));
        // } else {
        // $this -> Session -> setFlash(__('The user could not be saved. Please,
        // try again.'));
        // }
        // } else {
        // $this -> request -> data = $this -> User -> read(null, $id);
        // }
        // }
        //
        // /**
        // * admin_delete method
        // *
        // * @throws MethodNotAllowedException
        // * @throws NotFoundException
        // * @param string $id
        // * @return void
        // */
        // public function _admin_delete($id = null) {
        // if (!$this -> request -> is('post')) {
        // throw new MethodNotAllowedException();
        // }
        // $this -> User -> id = $id;
        // if (!$this -> User -> exists()) {
        // throw new NotFoundException(__('Invalid user'));
        // }
        // if ($this -> User -> delete()) {
        // $this -> Session -> setFlash(__('User deleted'));
        // $this -> redirect(array('action' => 'index'));
        // }
        // $this -> Session -> setFlash(__('User was not deleted'));
        // $this -> redirect(array('action' => 'index'));
        // }
        //	 
    }
