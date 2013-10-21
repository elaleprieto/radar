<?php
App::uses('AppController', 'Controller');
/**
 * CategoriesPlaces Controller
 *
 * @property CategoriesPlace $CategoriesPlace
 */
class CategoriesPlacesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CategoriesPlace->recursive = 0;
		$this->set('categoriesPlaces', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoriesPlace->exists($id)) {
			throw new NotFoundException(__('Invalid categories place'));
		}
		$options = array('conditions' => array('CategoriesPlace.' . $this->CategoriesPlace->primaryKey => $id));
		$this->set('categoriesPlace', $this->CategoriesPlace->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoriesPlace->create();
			if ($this->CategoriesPlace->save($this->request->data)) {
				$this->Session->setFlash(__('The categories place has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categories place could not be saved. Please, try again.'));
			}
		}
		$categories = $this->CategoriesPlace->Category->find('list');
		$places = $this->CategoriesPlace->Place->find('list');
		$this->set(compact('categories', 'places'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CategoriesPlace->exists($id)) {
			throw new NotFoundException(__('Invalid categories place'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CategoriesPlace->save($this->request->data)) {
				$this->Session->setFlash(__('The categories place has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categories place could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoriesPlace.' . $this->CategoriesPlace->primaryKey => $id));
			$this->request->data = $this->CategoriesPlace->find('first', $options);
		}
		$categories = $this->CategoriesPlace->Category->find('list');
		$places = $this->CategoriesPlace->Place->find('list');
		$this->set(compact('categories', 'places'));
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
		$this->CategoriesPlace->id = $id;
		if (!$this->CategoriesPlace->exists()) {
			throw new NotFoundException(__('Invalid categories place'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CategoriesPlace->delete()) {
			$this->Session->setFlash(__('Categories place deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Categories place was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
