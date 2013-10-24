<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

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
		// if ($this->action === 'index') {
		// return true;
		// }

		# Admin Users can do admin_actions
		$admin_actions = array(
			'admin_add',
			'admin_delete',
			'admin_edit',
			'admin_index'
		);
		if (in_array($this->action, $admin_actions)) {
			if (isset($user['role']) && $user['role'] === 'admin') {
				return true;
			}
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

	/**************************************************************************************************************
	 *  Admin Users
	 **************************************************************************************************************/

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
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
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
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
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
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

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		// debug($this->request->isAjax());
		// if ($this->request->isAjax()) {
		// $this->Category->recursive = -1;
		// $categories = $this->Category->find('all');
		// $this->set(array(
		// 'categories' => $categories,
		// '_serialize' => array('categories')
		// ));
		// return;
		// // return json_encode($this->Category->find('all'));
		// }
		// throw new NotFoundException("Categoría Inválida", 404);

		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	/**************************************************************************************************************
	 *  /admin users
	 **************************************************************************************************************/

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		// debug($this->request->isAjax());
		if ($this->request->isAjax()) {
			$this->Category->recursive = -1;
			$categories = $this->Category->find('all');
			$this->set(array(
				'categories' => $categories,
				'_serialize' => array('categories')
			));
			return;
			// return json_encode($this->Category->find('all'));
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

}
