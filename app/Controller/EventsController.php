<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 */
class EventsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = -1;
		$events = $this->Event->find('all', array('fields'=>array('title', 'date_start', 'date_end')));
		$categories = $this->Event->Category->find('list', array('fields'=>'name'));
		// $this->Event->Behaviors->load('Containable');
		// $categories = $this->Event->Category->find('list', array('conditions'=>'category_id=1'));
		// $events = $this->Event->find('all', array('conditions'=>'id=1'));
		// $events = $this->Event->find('all', array('conditions'=>'CategoriesEvents.category_id=1'));
		// $events = $this->Event->find('all', array('conditions'=>array('id'=>$this->Event->Category->find('id'=>1))));
		// $events = $this->Event->find('all');
		
		// $this->Event->bindModel(array('hasOne' => array('CategoriesEvents')));

	    // $events = $this->Event->find('all', array(
	                                        // 'conditions' => array('CategoriesEvents.category_id' => 2),
	                                        // 'recursive' => 2
	    // ));
		
		// debug($events);
		//$this->set('events', $this->paginate());
		$this->set(compact('events','categories'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$event = $this->request->data;
			$start = split('/', $event['Event']['date_from']);
			$event['Event']['date_start']['day'] = $start[0]; 
			$event['Event']['date_start']['month'] = $start[1]; 
			$event['Event']['date_start']['year'] = $start[2]; 
			$event['Event']['date_start']['hour'] = substr($event['Event']['time3'], 0, 2); 
			$event['Event']['date_start']['min'] = substr($event['Event']['time3'], 3, 2);
			$end = split('/', $event['Event']['date_to']);
			$event['Event']['date_end']['day'] = $end[0]; 
			$event['Event']['date_end']['month'] = $end[1]; 
			$event['Event']['date_end']['year'] = $end[2]; 
			$event['Event']['date_end']['hour'] = substr($event['Event']['time4'], 0, 2); 
			$event['Event']['date_end']['min'] = substr($event['Event']['time4'], 3, 2);
			$this->Event->create();
			if ($this->Event->save($event)) {
				$this->Session->setFlash(__('The event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		}
		// $categories = $this->Event->Category->find('list');
		$categories = $this->Event->Category->find('list', array('fields'=>array('id','name')));
		$places = $this->Event->Place->find('list');
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
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
		$categories = $this->Event->Category->find('list');
		$places = $this->Event->Place->find('list');
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
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('Event deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function get() {
		$this->autoRender = FALSE;
		
		if($this->request->is('get')) {
			$eventCategory = isset($this->request->query['eventCategory']) ? $this->request->query['eventCategory'] : array();
			$eventInterval = $this->request->query['eventInterval'];
			$neLat = $this->request->query['neLat'];
			$neLong = $this->request->query['neLong'];
			$swLat = $this->request->query['swLat'];
			$swLong = $this->request->query['swLong'];
			if(isset($neLat) && isset($neLong)  && isset($swLat) && isset($swLong)) {
				$conditions = array('Event.date_start >=' => date("Y-m-d"),
					'Event.date_start <=' => date("Y-m-d", strtotime("+$eventInterval days")),
					'Event.lat <' => $neLat,
					'Event.lat >' => $swLat,
					'Event.long <' => $neLong,
					'Event.long >' => $swLong,
				);
				$categories = array();
				if(sizeof($eventCategory) > 0) {
					$categoryConditions = array();
					foreach($eventCategory as $key => $category) {
						array_push($categoryConditions, array('CategoriesEvents.category_id =' => $category));
					}
					array_push($conditions, array("OR" => $categoryConditions));
				}
				$fields = array('Event.id', 'Event.title', 'Event.date_start', 'Event.date_end', 'Event.lat', 'Event.long');
				
				$this->Event->bindModel(array('hasOne' => array('CategoriesEvents')));
			    $events = $this->Event->find('all', array(
                    'conditions' => $conditions,
                    'fields' => $fields,
                    'recursive' => 0
			    ));
				return json_encode($events);
			}
		}
	}
}


































