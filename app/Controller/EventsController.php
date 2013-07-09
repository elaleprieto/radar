<?php
    App::uses('AppController', 'Controller');
    /**
     * Events Controller
     *
     * @property Event $Event
     */
    class EventsController extends AppController {

        public function beforeFilter() {
            parent::beforeFilter();
            $this -> Auth -> allow('get', 'index', 'indice', 'listar');
        }

        /**
         * index method
         *
         * @return void
         */
        public function index() {
            $this->Event->Category->recursive = -1;
            $categories = $this->Event->Category->find('list', array('fields' => 'name'));
            $categorias = $this -> Event -> Category -> find('all', array('order'=>'Category.name ASC'));
            $this -> set(compact('categories', 'categorias'));
        }
        
        public function indice() {
            $this->layout='ajax';
        }
 
        /**
         * list method
         *
         * @return void
         */
        public function listar() {
            $this->Event->Category->recursive = -1;
            $categories = $this -> Event -> Category -> find('list', array('fields' => 'name'));
            $categorias = $this -> Event -> Category -> find('all', array('order'=>'Category.name ASC'));
            $this -> set(compact('categories', 'categorias'));
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
            $this -> set('event', $this -> Event -> find('first', $options));
        }

        /**
         * add method
         *
         * @return void
         */
        public function add() {
            if ($this->request->is('post')) {
                $this->layout = 'ajax';
                
                $data = $this->request->input('json_decode');
                // debug($data);
                // return;
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
                
                // if(sizeof($data->Category) > 3)
                $event['Event']['Category'] = $data->Category;
                
                # Se crea el evento
                $this->Event->create();
                if(!$this->Event->save($event)) {
                    throw new Exception('Evento inválido', 1);
                }
                
				$this->render();
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
            } else {
                $options = array('conditions' => array('Event.' . $this -> Event -> primaryKey => $id));
                $this -> request -> data = $this -> Event -> find('first', $options);
            }
            $categories = $this -> Event -> Category -> find('list');
            $places = $this -> Event -> Place -> find('list');
            $this -> set(compact('categories', 'places'));
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
                    $conditions = array(
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
                            array_push($categoryConditions, array('CategoriesEvents.category_id =' => $category));
                        }
                        array_push($conditions, array("OR" => $categoryConditions));
                    }
                    $fields = array('Event.id'
                        , 'Event.title'
                        , 'Event.address'
                        , 'Event.date_start'
                        , 'Event.date_end'
                        , 'Event.lat'
                        , 'Event.long'
                    );

                    $this -> Event -> bindModel(array('hasOne' => array('CategoriesEvents')));
                    $events = $this -> Event -> find('all'
                    	, array('conditions' => $conditions
                        	, 'fields' => $fields
                        	, 'group' => array('Event.id')
                        	, 'recursive' => 0
                    	)
					);
                    return json_encode($events);
                }
            }
        }

    }
