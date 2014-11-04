<?php
App::uses('AppController', 'Controller');
/**
 * Compliants Controller
 *
 * @property Compliant $Compliant
 */
class CompliantsController extends AppController {
	
	/**************************************************************************************************************
	 *  Authentication
	**************************************************************************************************************/
	public function isAuthorized($user = null) {
	    # All registered users can add compliants
	    if ($this->action === 'add') {
	        return true;
	    }
// 	
	    // # The owner of an event can edit and delete it
	    // if (in_array($this->action, array('edit', 'delete'))) {
	        // $eventId = $this->request->params['pass'][0];
	        // if ($this->Event->isOwnedBy($eventId, $user['id'])) {
	            // return true;
	        // }
	    // }

	    $owner_allowed = array();
		$user_allowed = array();
		$admin_allowed = array_merge($owner_allowed, $user_allowed, array('index', 'admin_index', 'admin_view'));

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
	
		# The owner of an event can:
		if (in_array($this->action, $owner_allowed)) {
			$eventId = $this->request->params['pass'][0];
			if ($this->Compliant->isOwnedBy($eventId, $user['id']))
				return true;
		}
		

	    return parent::isAuthorized($user);
	}
	/**************************************************************************************************************
	 *  /authentication
	**************************************************************************************************************/

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Compliant->recursive = 0;
		$this->set('compliants', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Compliant->exists($id)) {
			throw new NotFoundException(__('Invalid compliant'));
		}
		$options = array('conditions' => array('Compliant.' . $this->Compliant->primaryKey => $id));
		$this->set('compliant', $this->Compliant->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Compliant->create();
			if ($this->Compliant->save($this->request->data)) {
				$this->Session->setFlash(__('The compliant has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compliant could not be saved. Please, try again.'));
			}
		}
		$events = $this->Compliant->Event->find('list');
		$users = $this->Compliant->User->find('list');
		$this->set(compact('events', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Compliant->exists($id)) {
			throw new NotFoundException(__('Invalid compliant'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Compliant->save($this->request->data)) {
				$this->Session->setFlash(__('The compliant has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compliant could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Compliant.' . $this->Compliant->primaryKey => $id));
			$this->request->data = $this->Compliant->find('first', $options);
		}
		$events = $this->Compliant->Event->find('list');
		$users = $this->Compliant->User->find('list');
		$this->set(compact('events', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Compliant->id = $id;
		if (!$this->Compliant->exists()) {
			throw new NotFoundException(__('Invalid compliant'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Compliant->delete()) {
			$this->Session->setFlash(__('Compliant deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Compliant was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			$evento = $this->request->input('json_decode');
			$this->Compliant->add($evento);
		}
	}
}
