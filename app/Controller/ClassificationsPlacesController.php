<?php
App::uses('AppController', 'Controller');
/**
 * ClassificationsPlaces Controller
 *
 * @property ClassificationsPlace $ClassificationsPlace
 */
class ClassificationsPlacesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ClassificationsPlace->recursive = 0;
		$this->set('classificationsPlaces', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ClassificationsPlace->exists($id)) {
			throw new NotFoundException(__('Invalid classifications place'));
		}
		$options = array('conditions' => array('ClassificationsPlace.' . $this->ClassificationsPlace->primaryKey => $id));
		$this->set('classificationsPlace', $this->ClassificationsPlace->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClassificationsPlace->create();
			if ($this->ClassificationsPlace->save($this->request->data)) {
				$this->Session->setFlash(__('The classifications place has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classifications place could not be saved. Please, try again.'));
			}
		}
		$classifications = $this->ClassificationsPlace->Classification->find('list');
		$places = $this->ClassificationsPlace->Place->find('list');
		$this->set(compact('classifications', 'places'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ClassificationsPlace->exists($id)) {
			throw new NotFoundException(__('Invalid classifications place'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClassificationsPlace->save($this->request->data)) {
				$this->Session->setFlash(__('The classifications place has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classifications place could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ClassificationsPlace.' . $this->ClassificationsPlace->primaryKey => $id));
			$this->request->data = $this->ClassificationsPlace->find('first', $options);
		}
		$classifications = $this->ClassificationsPlace->Classification->find('list');
		$places = $this->ClassificationsPlace->Place->find('list');
		$this->set(compact('classifications', 'places'));
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
		$this->ClassificationsPlace->id = $id;
		if (!$this->ClassificationsPlace->exists()) {
			throw new NotFoundException(__('Invalid classifications place'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ClassificationsPlace->delete()) {
			$this->Session->setFlash(__('Classifications place deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Classifications place was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
