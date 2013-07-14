<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

	/**************************************************************************************************************
	 *  Authentication
	**************************************************************************************************************/
    public function beforeFilter() {
        parent::beforeFilter();
        $this -> Auth -> allow('get', 'index', 'indice', 'listar');
    }
	
	public function isAuthorized($user) {
	    # All registered users can add events
	    if ($this->action === 'index') {
	        return true;
	    }
	
	    // # The owner of a category can edit and delete it
	    // if (in_array($this->action, array('edit', 'delete'))) {
	        // $categoryId = $this->request->params['pass'][0];
	        // if ($this->Event->isOwnedBy($categoryId, $user['id'])) {
	            // return true;
	        // }
	    // }
	
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
	public function index() {
	    $this->autoRender = false;
	    if ($this->request->is('ajax')) {
	        $this->Category->recursive = -1;
            return json_encode($this->Category->find('all'));
        }
        throw new NotFoundException("Categoría Inválida", 404);
        
		// $this->Category->recursive = 0;
		// $this->set('categories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
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
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('Category deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Category was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
