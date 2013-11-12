<?php
App::uses('AppController', 'Controller');
/**
 * Rates Controller
 *
 * @property Rate $Rate
 */
class RatesController extends AppController {
	
	/**************************************************************************************************************
	 *  Authentication
	**************************************************************************************************************/
	public function isAuthorized($user = null) {
	    # All registered users can add rates
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
// 	
	    // return parent::isAuthorized($user);
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
		$this->Rate->recursive = 0;
		$this->set('rates', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Rate->exists($id)) {
			throw new NotFoundException(__('Invalid rate'));
		}
		$options = array('conditions' => array('Rate.' . $this->Rate->primaryKey => $id));
		$this->set('rate', $this->Rate->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Rate->create();
			if ($this->Rate->save($this->request->data)) {
				$this->Session->setFlash(__('The rate has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rate could not be saved. Please, try again.'));
			}
		}
		$events = $this->Rate->Event->find('list');
		$users = $this->Rate->User->find('list');
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
		if (!$this->Rate->exists($id)) {
			throw new NotFoundException(__('Invalid rate'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rate->save($this->request->data)) {
				$this->Session->setFlash(__('The rate has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rate could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rate.' . $this->Rate->primaryKey => $id));
			$this->request->data = $this->Rate->find('first', $options);
		}
		$events = $this->Rate->Event->find('list');
		$users = $this->Rate->User->find('list');
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
		$this->Rate->id = $id;
		if (!$this->Rate->exists()) {
			throw new NotFoundException(__('Invalid rate'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Rate->delete()) {
			$this->Session->setFlash(__('Rate deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rate was not deleted'));
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
			return $this->Rate->rateEvent($evento);
			
			// if ($this->Rate->save($rate)) {
				// // $this->Session->setFlash(__('The rate has been saved'));
				// // $this->redirect(array('action' => 'index'));
			// } else {
				// $this->Session->setFlash(__('The rate could not be saved. Please, try again.'));
			// }
		}
		// $events = $this->Rate->Event->find('list');
		// $users = $this->Rate->User->find('list');
		// $this->set(compact('events', 'users'));
	}
}
