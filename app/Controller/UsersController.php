<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public $components = array('RequestHandler');

	/**************************************************************************************************************
	 *  Authentication
	**************************************************************************************************************/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'callbackTwitter', 'confirm', 'contactar', 'loginTwitter', 'logout');
	}

	public function isAuthorized($user = null) {
		$owner_allowed = array('edit', 'setLocation');
		$user_allowed = array();
		$admin_allowed = array_merge($owner_allowed, $user_allowed, array('active', 'delete', 'inactive', 'index', 'view'));

		# All registered users can:
		if (in_array($this->action, $user_allowed))
			return true;

		# Admin users can:
		// if ($user['role'] === 'admin')
		// if ($user['Rol']['weight'] >= User::ADMIN)
		$id = $this->Auth->user('id');
    	$userData = $this->User->findById($id);
		if (isset($userData) && isset($userData['Rol']) && isset($userData['Rol']['weight']) && $userData['Rol']['weight'] >= User::ADMIN)
			if (in_array($this->action, $admin_allowed))
				return true;

		# The owner of an user can:
		if (in_array($this->action, $owner_allowed)) {
			$userId = $this->request->params['pass'][0];
			// if ($this->User->isOwnedBy($userId, $user['id']))
			if ($userId == $user['id'])
				return true;
		}

		return parent::isAuthorized($user);
	}
	/**************************************************************************************************************
	 *  /authentication
	**************************************************************************************************************/


	/**
	* active method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function active($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this -> User -> saveField('active', TRUE);
		$this -> redirect(array('action' => 'index'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {

			# Se carga la librería del catpcha
			// require_once('recaptchalib.php');
			App::import('Vendor', 'extras', array('file' => 'extras.php'));
			App::import('Vendor', 'recaptchalib', array('file' => 'recaptchalib.php'));

			$privatekey = PRIVATE_KEY;
			$recaptcha_challenge_field = $this->request->data['recaptcha_challenge_field'];
			$recaptcha_response_field = $this->request->data['recaptcha_response_field'];

			$resp = recaptcha_check_answer($privatekey
				, $_SERVER["REMOTE_ADDR"]
				, $recaptcha_challenge_field
				, $recaptcha_response_field
			);

			if (!$resp->is_valid) {
				// What happens when the CAPTCHA was entered incorrectly
				// die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				// 	 "(reCAPTCHA said: " . $resp->error . ")");
				$this->Session->setFlash(__('The reCAPTCHA wasn\'t entered correctly. Go back and try it again.'));
				$this->redirect('/');
			}

			$user = $this->request->data;

			$this->User->create();
			if ($this->User->save($user)) {
				$to = $user['User']['email'];
				$subject = 'Radar Cultural :: Confirma tu correo';
				$message = 'Confirma tu correo haciendo clic en el siguiente enlace: ' . Router::fullBaseUrl() . '/confirm/' . $this->User->id;
				$additional_headers = 'From: Radar Cultural <contacto@colectivolibre.com.ar>' . "\r\n" .
					'Reply-To: contacto@colectivolibre.com.ar' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$additional_parameters = '';

				# Se envía el correo de confirmación
				mail($to, $subject, $message, $additional_headers, $additional_parameters);

				# Se envía al usuario a un mensaje de confirmación
				return $this->redirect(__('/emailconfirm'));

				// $id = $this->User->id;
				// $this->request->data['User'] = array_merge($this->request->data['User'], array('id' => $id));
				// $this->Auth->login($this->request->data['User']);
				// $this->redirect(array(
				// 	'controller' => 'events',
				// 	'action' => 'index'
				// ));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

	public function callbackTwitter() {
		App::import('Vendor', 'twitteroauth/twitteroauth');

		define('CONSUMER_KEY', 'gJos51nlduv7o47481Mg4A');
		define('CONSUMER_SECRET', 'rwa1AfOL2vbnPrrHoYcdHaLd4m37x4fDEGc0Pm11Q');
		define('OAUTH_CALLBACK', '/users/callbackTwitter');

		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, CakeSession::read('twitter_token_aux'), CakeSession::read('twitter_token_secret_aux'));
		$twitterToken = $twitter->getAccessToken($this->request->query['oauth_verifier']);

		if ($twitter->http_code == 200) {
			CakeSession::write('twitter_token', $twitterToken['oauth_token']);
			CakeSession::write('twitter_token_secret', $twitterToken['oauth_token_secret']);
			CakeSession::write('twitter_status', true);

			$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitterToken['oauth_token'], $twitterToken['oauth_token_secret']);

			# Se obtienen los datos de twitter
			$twitterData = $twitter->get('account/verify_credentials');

			# Se busca el usuario a través del id de twitter
			$existentUser = $this->User->find('first', array('conditions' => array('User.twitter_id' => $twitterData->id)));

			# Si no existe, se crea y se logea con él. Si existe, sólo se logea.
			if (sizeof($existentUser) == 0) {
				$user['User']['username'] = 'tw_' . $twitterData->screen_name;
				$user['User']['password'] = $twitterToken['oauth_token'];
				$user['User']['name'] = $twitterData->name;
				$user['User']['location'] = $twitterData->location;
				$user['User']['twitter_id'] = $twitterData->id;

				$this->User->create();
				if ($this->User->save($user)) {
					$user = $this->User->read(null, $this->User->id);
					$this->Auth->login($user['User']);
				} else {
					$this->redirect(Router::url(array(
						'controller' => 'users',
						'action' => 'login'
					)));
				}
			} else {
				$active = $existentUser['User']['active'];

				if(!$active) {
					$this->Session->setFlash(__('User inactive'));
					# Se redirige al inicio.
					$this->redirect(array('controller' => 'events', 'action' => 'index'));
				}


				$this->Auth->login($existentUser['User']);
			}

			# Se redirige al inicio.
			$this->redirect(array(
				'controller' => 'events',
				'action' => 'index'
			));
		}
	}


/**
 * confirm method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function confirm($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->read(null, $id);

		# Se verifica que el usuario no haya sido confirmado previamente,
		# es una especie de medida de seguridad para que no se loguee cualquiera
		# con cualquier ID
		if(!$user['User']['confirmed']) {
			$this->User->id = $id;
			$this->User->saveField('confirmed', TRUE);

			$this->Auth->login($user['User']);
			return $this->redirect('/');
		}
		$this->redirect('/logout');
	}

	/**
	 * contactar method
	 * Se utiliza por el formulario de contacto para enviar el mensaje.
	 * @return void
	 */
	public function contactar() {
		$this->autoRender = FALSE;
		if ($this->request->isPost() && isset($this->request->data)):
			# Validación de Campos
			$contacto = $this->request->data;
			if (isset($contacto['nombre']) && $contacto['nombre'] !== ''
				&& isset($contacto['apellido']) && $contacto['apellido'] !== ''
				&& isset($contacto['mail']) && $contacto['mail'] !== ''
				&& isset($contacto['asunto']) && $contacto['asunto'] !== ''
				&& isset($contacto['mensaje']) && $contacto['mensaje'] !== ''):

				App::import('Vendor', 'contras', array('file' => 'contras.php'));

				# Se crea el mensaje
				$mensaje = 'Enviado por: ' . $contacto['nombre'] . "\n";
				$mensaje .= 'Mail de contacto: ' . $contacto['mail'] . "\n";
				$mensaje .= 'Asunto del mensaje: ' . $contacto['asunto'] . "\n";
				$mensaje .= 'Mensaje: ' . $contacto['mensaje'];

				# Se envía el mensaje
				mail(TO, ASUNTO, $mensaje, 'From: ' . FROM);
				$this->Session->setFlash(__('Message sent. Thank you!'));
				$this->redirect('/contacto');
				return json_encode(true);
			endif;
		endif;
		return json_encode(false);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if ($id == AuthComponent::user('id')) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'));
					$this->redirect(array(
						'controller' => 'events',
						'action' => 'index'
					));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
		} else {
			$this->redirect(array(
				'controller' => 'events',
				'action' => 'index'
			));
		}
	}

	/**
	* inactive method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function inactive($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this -> User -> saveField('active', FALSE);
		$this -> redirect(array('action' => 'index'));
	}

	/**
	* index method
	*
	* @return void
	*/
	public function index() {
		$this -> User -> recursive = 0;
		$this -> set('users', $this -> paginate());
	}

	public function login() {
		// $this -> layout = 'login';

		if ($this->request->is('post')) {
			if (isset($this->request->data['User'])) {
				$user = $this->request->data['User'];
				$active = $this->User->field('active', array('username' => $user['username']));
				$confirmed = $this->User->field('confirmed', array('username' => $user['username']));

				if($active && $confirmed) {
					if ($this->Auth->login()) {
						$this->redirect($this->Auth->redirect());
					}
				}
				$this->Session->setFlash(__('User inactive or unconfirmed, verify and try again'));
				$this->redirect('/');
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
			$this->redirect('/');
		}

		// if ($this->request->is('post')) {
		// 	if ($this->Auth->login()) {
		// 		$this->redirect($this->Auth->redirect());
		// 	} else {
		// 		$this->Session->setFlash(__('Invalid username or password, try again'));
		// 	}
		// }
	}

	public function loginTwitter() {
		App::import('Vendor', 'twitteroauth/twitteroauth');

		define('CONSUMER_KEY', 'gJos51nlduv7o47481Mg4A');
		define('CONSUMER_SECRET', 'rwa1AfOL2vbnPrrHoYcdHaLd4m37x4fDEGc0Pm11Q');
		define('OAUTH_CALLBACK', Router::url(array(
			'controller' => 'users',
			'action' => 'callbackTwitter'
		), true));

		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		$twitterAux = $twitter->getRequestToken(OAUTH_CALLBACK);
		CakeSession::write('twitter_token_aux', $twitterAux['oauth_token']);
		CakeSession::write('twitter_token_secret_aux', $twitterAux['oauth_token_secret']);

		$twitterURL = $twitter->getAuthorizeURL($twitterAux['oauth_token']);
		$this->redirect($twitterURL);
	}

	public function setLocation($id = null, $location = null) {
		$this->autoRender = false;
		if ($id && $location) {
			$this->User->id = $id;
			$this->User->saveField('location', $location);
		}
	}

	public function logout() {
		//Logout según Cakephp
		//$this -> redirect($this -> Auth -> logout());

		//Logout a partir de plugin de facebook
		if ($this->Connect->FB->getUser() == 0) {
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

	/**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function view($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this -> set('user', $this -> User -> read(null, $id));
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
