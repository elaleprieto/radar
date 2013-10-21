<?php
App::uses('AppController', 'Controller');
/**
 * Places Controller
 *
 * @property Place $Place
 */
class PlacesController extends AppController {

	public $components = array('RequestHandler');

	/**************************************************************************************************************
	 *  Authentication
	 **************************************************************************************************************/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	public function isAuthorized($user = null) {
		// # All registered users can add events
		// if ($this->action === 'add') {
		// return true;
		// }

		
		# Admin users can add places
		if ($this->action === 'add') {
			if (isset($user['role']) && $user['role'] === 'admin') {
				return true;
			}
		}

		// # The owner of an event can edit and delete it
		// $actions = array(
			// 'edit',
			// 'delete'
		// );
		// if (in_array($this->action, $actions)) {
			// $eventId = $this->request->params['pass'][0];
			// if ($this->Event->isOwnedBy($eventId, $user['id'])) {
				// return true;
			// }
		// }

		return parent::isAuthorized($user);
	}

	/**************************************************************************************************************
	 *  /authentication
	 **************************************************************************************************************/

	 
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post') && AuthComponent::user('id')) {
			$place = $this->request->data;
			$place['Place']['user_id'] = AuthComponent::user('id');
			
			$this->Place->create();
			if ($this->Place->save($place)) {
				$this->flash(__('Place saved.'), array('action' => 'index'));
			} else {
			}
		}
	}
	 
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Place->recursive = 0;
		$this->set('places', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Place->exists($id)) {
			throw new NotFoundException(__('Invalid place'));
		}
		$options = array('conditions' => array('Place.' . $this->Place->primaryKey => $id));
		$this->set('place', $this->Place->find('first', $options));
	}


	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->Place->exists($id)) {
			throw new NotFoundException(__('Invalid place'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Place->save($this->request->data)) {
				$this->flash(__('The place has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$options = array('conditions' => array('Place.' . $this->Place->primaryKey => $id));
			$this->request->data = $this->Place->find('first', $options);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Place->id = $id;
		if (!$this->Place->exists()) {
			throw new NotFoundException(__('Invalid place'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Place->delete()) {
			$this->flash(__('Place deleted'), array('action' => 'index'));
		}
		$this->flash(__('Place was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Place->recursive = 0;
		$this->set('places', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Place->exists($id)) {
			throw new NotFoundException(__('Invalid place'));
		}
		$options = array('conditions' => array('Place.' . $this->Place->primaryKey => $id));
		$this->set('place', $this->Place->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Place->create();
			if ($this->Place->save($this->request->data)) {
				$this->flash(__('Place saved.'), array('action' => 'index'));
			} else {
			}
		}
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Place->exists($id)) {
			throw new NotFoundException(__('Invalid place'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Place->save($this->request->data)) {
				$this->flash(__('The place has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$options = array('conditions' => array('Place.' . $this->Place->primaryKey => $id));
			$this->request->data = $this->Place->find('first', $options);
		}
	}

	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Place->id = $id;
		if (!$this->Place->exists()) {
			throw new NotFoundException(__('Invalid place'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Place->delete()) {
			$this->flash(__('Place deleted'), array('action' => 'index'));
		}
		$this->flash(__('Place was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}

}
