<?php
App::uses('AppController', 'Controller');
/**
 * Classifications Controller
 *
 * @property Classification $Classification
 */
class ClassificationsController extends AppController {
	
	/**************************************************************************************************************
	 *  Authentication
	**************************************************************************************************************/
    // public function beforeFilter() {
        // parent::beforeFilter();
        // $this -> Auth -> allow('get', 'getJSON', 'index', 'view');
    // }
	
	public function isAuthorized($user = null) {
	    // # All registered users can add events
	    // if ($this->action === 'add') {
	        // return true;
	    // }
	
	    // # The owner of an event can edit and delete it
	    // if (in_array($this->action, array('edit', 'delete'))) {
	        // $eventId = $this->request->params['pass'][0];
	        // if ($this->Event->isOwnedBy($eventId, $user['id'])) {
	            // return true;
	        // }
	    // }
	    
	    # Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
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
		$this->Classification->recursive = 0;
		$this->set('classifications', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Classification->exists($id)) {
			throw new NotFoundException(__('Invalid classification'));
		}
		$options = array('conditions' => array('Classification.' . $this->Classification->primaryKey => $id));
		$this->set('classification', $this->Classification->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Classification->create();
			if ($this->Classification->save($this->request->data)) {
				$this->Session->setFlash(__('The classification has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classification could not be saved. Please, try again.'));
			}
		}
		$places = $this->Classification->Place->find('list');
		$this->set(compact('places'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Classification->exists($id)) {
			throw new NotFoundException(__('Invalid classification'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Classification->save($this->request->data)) {
				$this->Session->setFlash(__('The classification has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classification could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Classification.' . $this->Classification->primaryKey => $id));
			$this->request->data = $this->Classification->find('first', $options);
		}
		$places = $this->Classification->Place->find('list');
		$this->set(compact('places'));
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
		$this->Classification->id = $id;
		if (!$this->Classification->exists()) {
			throw new NotFoundException(__('Invalid classification'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Classification->delete()) {
			$this->Session->setFlash(__('Classification deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Classification was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
