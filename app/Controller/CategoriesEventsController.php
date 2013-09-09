<?php
App::uses('AppController', 'Controller');
/**
 * CategoriesEvents Controller
 *
 * @property CategoriesEvent $CategoriesEvent
 */
class CategoriesEventsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CategoriesEvent->recursive = 0;
		$this->set('categoriesEvents', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoriesEvent->exists($id)) {
			throw new NotFoundException(__('Invalid categories event'));
		}
		$options = array('conditions' => array('CategoriesEvent.' . $this->CategoriesEvent->primaryKey => $id));
		$this->set('categoriesEvent', $this->CategoriesEvent->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoriesEvent->create();
			if ($this->CategoriesEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The categories event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categories event could not be saved. Please, try again.'));
			}
		}
		$categories = $this->CategoriesEvent->Category->find('list');
		$events = $this->CategoriesEvent->Event->find('list');
		$this->set(compact('categories', 'events'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CategoriesEvent->exists($id)) {
			throw new NotFoundException(__('Invalid categories event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CategoriesEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The categories event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categories event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoriesEvent.' . $this->CategoriesEvent->primaryKey => $id));
			$this->request->data = $this->CategoriesEvent->find('first', $options);
		}
		$categories = $this->CategoriesEvent->Category->find('list');
		$events = $this->CategoriesEvent->Event->find('list');
		$this->set(compact('categories', 'events'));
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
		$this->CategoriesEvent->id = $id;
		if (!$this->CategoriesEvent->exists()) {
			throw new NotFoundException(__('Invalid categories event'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CategoriesEvent->delete()) {
			$this->Session->setFlash(__('Categories event deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Categories event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
