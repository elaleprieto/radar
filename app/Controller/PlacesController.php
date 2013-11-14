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
		$this->Auth->allow('get', 'index', 'view');
	}

	public function isAuthorized($user = null) {
		// # All registered users can add places
		// if ($this->action === 'add') {
		// return true;
		// }

		# Admin users can add places
		if ($this->action === 'admin_add') {
			if (isset($user['role']) && $user['role'] === 'admin') {
				return true;
			}
		}

		// # The owner of a place can edit and delete it
		// $actions = array(
		// 'edit',
		// 'delete'
		// );
		// if (in_array($this->action, $actions)) {
		// $placeId = $this->request->params['pass'][0];
		// if ($this->Place->isOwnedBy($placeId, $user['id'])) {
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
	public function admin_add() {
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

	public function get() {
		if ($this->request->isAjax() && isset($this->request->query['params'])) {
			$params = json_decode($this->request->query['params']);
			$placeClassification = isset($params->classificationsSelected) ? $params->classificationsSelected : null;

			$neLat = isset($params->neLat) ? $params->neLat : null;
			$neLong = isset($params->neLong) ? $params->neLong : null;
			$swLat = isset($params->swLat) ? $params->swLat : null;
			$swLong = isset($params->swLong) ? $params->swLong : null;

			if ($neLat && $neLong && $swLat && $swLong) {
				$options['conditions'] = array(
					'Place.lat <' => $neLat,
					'Place.lat >' => $swLat,
					'Place.long <' => $neLong,
					'Place.long >' => $swLong,
				);
				$classifications = array();
				// $placeCategory = json_decode($placeCategory); # Angular lo manda en formato JSON
				if (sizeof($placeClassification) > 0) {
					$classificationConditions = array();
					foreach ($placeClassification as $key => $classification) {
						array_push($classificationConditions, array('ClassificationsPlace.classification_id =' => $classification));
					}
					// array_push($conditions, array("OR" => $categoryConditions));
					array_push($options['conditions'], array("OR" => $classificationConditions));
				}
				$options['fields'] = array(
					'Place.id',
					'Place.name',
					'Place.address',
					'Place.lat',
					'Place.long',
					'ClassificationsPlace.classification_id',
					'Classification.color'
				);
				$options['group'] = array('Place.id');
				$options['recursive'] = 0;

				$options['joins'] = array(
					array(
						'table' => 'classifications_places',
						'alias' => 'ClassificationsPlace',
						'type' => 'LEFT',
						'conditions' => array('Place.id = ClassificationsPlace.place_id', )
					),
					array(
						'table' => 'classifications',
						'alias' => 'Classification',
						'type' => 'LEFT',
						'conditions' => array('Classification.id = ClassificationsPlace.classification_id', )
					)
				);

				$places = $this->Place->find('all', $options);
				$this->set(array(
					'places' => $places,
					'_serialize' => array('places')
				));
				return;
			}
		}
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->layout = 'index';
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
