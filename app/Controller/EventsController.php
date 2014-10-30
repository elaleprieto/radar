<?php
	App::uses('AppController', 'Controller');

	/**
	 * Events Controller
	 *
	 * @property Event $Event
	 */
	class EventsController extends AppController {
		
		public $components = array('Paginator', 'RequestHandler');
		
		/**************************************************************************************************************
		 *  Authentication
		**************************************************************************************************************/
		public function beforeFilter() {
			parent::beforeFilter();
			$this -> Auth -> allow('get', 'getJSON', 'index', 'view');
		}
		
		public function isAuthorized($user = null) {
			$owner_allowed = array('edit', 'delete');
			$user_allowed = array('add', 'resume');
			$admin_allowed = array_merge($owner_allowed, $user_allowed, array('admin_resume', 'resume', 'edit', 'delete'));

			# All registered users can:
			if (in_array($this->action, $user_allowed))
				return true;

			# Admin users can:
			if ($user['role'] === 'admin')
				if (in_array($this->action, $admin_allowed))
					return true;
		
			# The owner of an event can:
			if (in_array($this->action, $owner_allowed)) {
				$eventId = $this->request->params['pass'][0];
				if ($this->Event->isOwnedBy($eventId, $user['id']))
					return true;
			}
		
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
		public function add() {
			if ($this->request->is('ajax') && AuthComponent::user('id')) {
				$this->autoRender = false;
				date_default_timezone_set('UTC');
				
				$data = $this->request->input('json_decode');
				$date_start = strtotime($data->Event->date_from);
				$time_start = strtotime($data->Event->time_from);
				$date_end = strtotime($data->Event->date_to);
				$time_end = strtotime($data->Event->time_to);

				# Se arma el Evento
				$event['Event']['date_start'] = date('Y-m-d ', $date_start) . date('H:i', $time_start);
				$event['Event']['date_end'] = date('Y-m-d ', $date_end) . date('H:i', $time_end);
				$event['Event']['title'] = $data->Event->title;
				$event['Event']['address'] = $data->Event->address;
				$event['Event']['description'] = $data->Event->description;
				$event['Event']['lat'] = $data->Event->lat;
				$event['Event']['long'] = $data->Event->long;
				$event['Event']['website'] = $data->Event->website;
				$event['Event']['cost'] = $data->Event->cost;
				$event['Event']['user_id'] = AuthComponent::user('id');
				
				// if(sizeof($data->Category) > 3)
				$event['Event']['Category'] = $data->Category;
								
			//imagen inicio
			# Se verifica si se subió una imagen y se setea la imagen
			
			if (isset($event['Event']['image']['name']) && ($event['Event']['image']['name'] != '')) {
				$imageName = $event['Event']['image']['name'];
				$uploadDir = IMAGES_URL . 'photos/';
				$uploadFile = $uploadDir . $imageName;
				
				if (!move_uploaded_file($event['Event']['image']['tmp_name'], $uploadFile)) {
					$this->Session->setFlash(__('The image could not be saved. Please, verify the file.'));
					return $this->redirect(array('action' => 'add'));
				}
				
				$image = $imageName;
				$event['Event']['image'] = $data->Event->image;
			}			
			//imagen fin
								
				# Se crea el evento
				$this->Event->create();
				if(!$this->Event->save($event)) {
					throw new Exception('Evento inválido', 1);
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
		 * resume method
		 *
		 * @return void
		 */
		public function admin_resume() {
			$this->Event->recursive = -1;
			$this->Event->Behaviors->load('Containable');
			$this->Paginator->settings = 
				array('conditions' => 
						array('Event.date_end >=' => date('Y-m-d H:i'))
					, 'contain' => array('User' => array('fields'=>array('User.id', 'User.username')))
					, 'order' => 'Event.date_start ASC'
			);

			$this->set('events', $this->Paginator->paginate());
		}

		/**
		 * resume method
		 *
		 * @return void
		 */
		public function resume() {
			$user_id = $this->Auth->user('id');
			if(!$user_id) {
				$this->Session->setFlash(__('You must be logged in to access :/'));
				$this->redirect('/');
			}
			$this->Event->recursive = -1;
			$this->Paginator->settings = 
				array('conditions' => 
						array('Event.user_id' => $user_id
							, 'Event.date_end >=' => date('Y-m-d H:i')
						)
					, 'order' => 'Event.date_start ASC'
			);
			$this->set('events', $this->Paginator->paginate());
		}

		/**
		 * view method
		 *
		 * @throws NotFoundException
		 * @param string $id
		 * @return void
		 */
		public function view($id = null) {
			if (!$this -> Event -> exists($id)) {
				throw new NotFoundException(__('Invalid event'));
			}
			$options = array('conditions' => array('Event.' . $this -> Event -> primaryKey => $id));
			$event = $this -> Event -> find('first', $options);
			$this->set(array('event' => $event, '_serialize' => array('event')));
		}


		/**
		 * edit method
		 *
		 * @throws NotFoundException
		 * @param string $id
		 * @return void
		 */
		public function edit($id = null) {
			if (!$this -> Event -> exists($id)) {
				throw new NotFoundException(__('Invalid event'));
			}
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				if ($this -> Event -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('The event has been saved'));
					$this -> redirect(array('action' => 'index'));
				} else {
					$this -> Session -> setFlash(__('The event could not be saved. Please, try again.'));
				}
			}
			
			// $this->Paginator->settings = 
			// 	array('conditions' => 
			// 			array('Event.date_end >=' => date('Y-m-d H:i'))
			// 		, 'contain' => array('User' => array('fields'=>array('User.id', 'User.username')))
			// 		, 'order' => 'Event.date_start ASC'
			// );


			$this->Event->Behaviors->load('Containable');
			$options['conditions'] = array('Event.' . $this->Event->primaryKey => $id);
			$options['contain'] = array('Category');
			// $options['recursive'] = -1;
			$event = $this->Event->find('first', $options);
			
			$categories = $this -> Event -> Category -> find('list');
			$places = $this -> Event -> Place -> find('list');
			$this -> set(compact('categories', 'event', 'places'));
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
			$this -> Event -> id = $id;
			if (!$this -> Event -> exists()) {
				throw new NotFoundException(__('Invalid event'));
			}
			$this -> request -> onlyAllow('post', 'delete');
			if ($this -> Event -> delete()) {
				$this -> Session -> setFlash(__('Event deleted'));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Event was not deleted'));
			$this -> redirect(array('action' => 'index'));
		}

		public function get() {
			if($this->request->isAjax() && isset($this->request->query['params'])) {
				$params = json_decode($this->request->query['params']);
				$eventCategory = isset($params->categoriesSelected) ? $params->categoriesSelected : null;
				$eventInterval = isset($params->eventInterval) ? $params->eventInterval : null;
				$neLat = isset($params->neLat) ? $params->neLat : null;
				$neLong = isset($params->neLong) ? $params->neLong : null;
				$swLat = isset($params->swLat) ? $params->swLat : null;
				$swLong = isset($params->swLong) ? $params->swLong : null;
				if ($neLat && $neLong && $swLat && $swLong) {
					switch ($eventInterval) {
						case '2' :
							$tomorrow = strtotime("+1 days");
							$intervalConditions = array('OR' => array(
									array('AND' => array(
											array('Event.date_start >=' => date("Y-m-d", $tomorrow)),
											# # Tomorrow
											array('Event.date_start <' => date("Y-m-d", strtotime("+$eventInterval days")))
											# # After Tomorrow
										)),
									array('AND' => array(
											'Event.date_start <' => date("Y-m-d", $tomorrow),
											'Event.date_end >=' => date("Y-m-d", $tomorrow)
										)),
								));
							break;

						default :
							$intervalConditions = array('OR' => array(
									array('AND' => array(
											array('Event.date_start >=' => date("Y-m-d")),
											array('Event.date_start <' => date("Y-m-d", strtotime("+$eventInterval days")))
										)),
									array('AND' => array(
											'Event.date_start <' => date("Y-m-d"),
											'Event.date_end >=' => date("Y-m-d")
										)),
								));
							break;
					}
					$options['conditions'] = array(
						'Event.lat <' => $neLat,
						'Event.lat >' => $swLat,
						'Event.long <' => $neLong,
						'Event.long >' => $swLong,
						$intervalConditions
					);
					$categories = array();
					// $eventCategory = json_decode($eventCategory); # Angular lo manda en formato JSON
					if (sizeof($eventCategory) > 0) {
						$categoryConditions = array();
						foreach ($eventCategory as $key => $category) {
							array_push($categoryConditions, array('CategoriesEvent.category_id =' => $category));
						}
						// array_push($conditions, array("OR" => $categoryConditions));
						array_push($options['conditions'], array("OR" => $categoryConditions));
					}
					$options['fields'] = array('Event.id'
						, 'Event.title'
						, 'Event.address'
						, 'Event.date_start'
						, 'Event.date_end'
						, 'Event.lat'
						, 'Event.long'
						, 'Event.rate'
						, 'CategoriesEvent.category_id'
						, 'Category.icon'
						, 'Compliant.user_id'
						, 'Rate.user_id'
					);
					$options['group'] = array('Event.id');
					$options['recursive'] = 0;
					
					$options['joins'] = array(
						array('table' => 'categories_events',
							'alias' => 'CategoriesEvent',
							'type' => 'LEFT',
							'conditions' => array(
								'Event.id = CategoriesEvent.event_id',
							)
						)
						, array('table' => 'categories',
							'alias' => 'Category',
							'type' => 'LEFT',
							'conditions' => array(
								'Category.id = CategoriesEvent.category_id',
							)
						)
						, array('table' => 'compliants',
							'alias' => 'Compliant',
							'type' => 'LEFT',
							'conditions' => array(
								'Event.id = Compliant.event_id',
								'Compliant.user_id = \'' . (AuthComponent::user('id') ? AuthComponent::user('id') : 0) . '\''
							)
						)
						, array('table' => 'rates',
							'alias' => 'Rate',
							'type' => 'LEFT',
							'conditions' => array(
								'Event.id = Rate.event_id',
								'Rate.user_id = \'' . (AuthComponent::user('id') ? AuthComponent::user('id') : 0) . '\''
							)
						)
					);

					$events = $this -> Event -> find('all', $options);
					$this->set(array('events' => $events, '_serialize' => array('events')));
					return;
				}
			}
		}

		public function getJSON() {
			$this -> autoRender = FALSE;

			if ($this -> request -> is('get')) {
				$eventCategory = isset($this -> request -> query['eventCategory']) ? $this -> request -> query['eventCategory'] : array();
				$eventInterval = $this -> request -> query['eventInterval'];
				$neLat = $this -> request -> query['neLat'];
				$neLong = $this -> request -> query['neLong'];
				$swLat = $this -> request -> query['swLat'];
				$swLong = $this -> request -> query['swLong'];
				if (isset($neLat) && isset($neLong) && isset($swLat) && isset($swLong)) {
					switch ($eventInterval) {
						case '2' :
							$tomorrow = strtotime("+1 days");
							$intervalConditions = array('OR' => array(
									array('AND' => array(
											array('Event.date_start >=' => date("Y-m-d", $tomorrow)),
											# # Tomorrow
											array('Event.date_start <' => date("Y-m-d", strtotime("+$eventInterval days")))
											# # After Tomorrow
										)),
									array('AND' => array(
											'Event.date_start <' => date("Y-m-d", $tomorrow),
											'Event.date_end >=' => date("Y-m-d", $tomorrow)
										)),
								));
							break;

						default :
							$intervalConditions = array('OR' => array(
									array('AND' => array(
											array('Event.date_start >=' => date("Y-m-d")),
											array('Event.date_start <' => date("Y-m-d", strtotime("+$eventInterval days")))
										)),
									array('AND' => array(
											'Event.date_start <' => date("Y-m-d"),
											'Event.date_end >=' => date("Y-m-d")
										)),
								));
							break;
					}
					$options['conditions'] = array(
						'Event.lat <' => $neLat,
						'Event.lat >' => $swLat,
						'Event.long <' => $neLong,
						'Event.long >' => $swLong,
						$intervalConditions
					);
					$categories = array();
					$eventCategory = json_decode($eventCategory); # Angular lo manda en formato JSON
					if (sizeof($eventCategory) > 0) {
						$categoryConditions = array();
						foreach ($eventCategory as $key => $category) {
							array_push($categoryConditions, array('CategoriesEvent.category_id =' => $category));
						}
						// array_push($conditions, array("OR" => $categoryConditions));
						array_push($options['conditions'], array("OR" => $categoryConditions));
					}
					$options['fields'] = array('Event.id'
						, 'Event.title'
						, 'Event.address'
						, 'Event.date_start'
						, 'Event.date_end'
						, 'Event.lat'
						, 'Event.long'
						, 'CategoriesEvent.category_id'
						, 'Category.icon'
					);
					$options['group'] = array('Event.id');
					$options['recursive'] = 0;
					
					$options['joins'] = array(
						array('table' => 'categories_events',
							'alias' => 'CategoriesEvent',
							'type' => 'LEFT',
							'conditions' => array(
								'Event.id = CategoriesEvent.event_id',
							)
						)
						, array('table' => 'categories',
							'alias' => 'Category',
							'type' => 'LEFT',
							'conditions' => array(
								'Category.id = CategoriesEvent.category_id',
							)
						)
					);

					// $this -> Event -> bindModel(array('hasOne' => array('CategoriesEvents')));
					$events = $this -> Event -> find('all', $options);
					return json_encode($events);
				}
			}
		}

	}
