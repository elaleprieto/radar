<?php
	App::uses('AppModel', 'Model');
	/**
	 * Rate Model
	 *
	 * @property Event $Event
	 * @property User $User
	 */
	class Rate extends AppModel {

		/**
		 * Validation rules
		 *
		 * @var array
		 */
		public $validate = array(
			'rate' => array('numeric' => array('rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'event_id' => array('uuid' => array('rule' => array('uuid'),
					// //'message' => 'Your custom message here',
					// //'allowEmpty' => false,
					// //'required' => false,
					// //'last' => false, // Stop validation after this rule
					// //'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'user_id' => array('uuid' => array('rule' => array('uuid'),
					// //'message' => 'Your custom message here',
					// //'allowEmpty' => false,
					// //'required' => false,
					// //'last' => false, // Stop validation after this rule
					// //'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
		);

		//The Associations below have been created with all possible keys, those that are
		// not needed can be removed

		/**
		 * belongsTo associations
		 *
		 * @var array
		 */
		public $belongsTo = array(
			'Event' => array(
				'className' => 'Event',
				'foreignKey' => 'event_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);

		/**
		 * add: si el usuario está registrado, se agrega la votación por el evento
		 * y se llama al método que recalcula el rate global del evento.
		 * @param evento: el evento votado
		 * @param user->id: el id del usuario registrado.
		 */
		public function add($evento = null) {
			if ($evento && AuthComponent::user('id') && !$this->userHasRated($evento)) {
				$rate['Rate']['rate'] = $evento->Rate->rate;
				$rate['Rate']['event_id'] = $evento->Event->id;
				$rate['Rate']['user_id'] = AuthComponent::user('id');

				$this->create();
				if ($this->save($rate)) {
					return $this->Event->rate($evento->Event->id, $evento->Rate->rate);
				}
			}
		}

		/**
		 * rate: si el usuario está registrado y no ha votado,
		 * se llama al método que agrega la votación.
		 * Si el usuario ya votó, se borra la votación y se llama al método que agrega la
		 * votación.
		 * @param evento: el evento votado
		 * @param user->id: el id del usuario registrado.
		 */
		public function rateEvent($evento = null) {
			if ($evento && AuthComponent::user('id')) {
				debug($evento);
				if (!$this->userHasRated($evento)) {
					$this->add($evento);
				} else {
					$this->deleteUserRates($evento->Event->id, AuthComponent::user('id'));
					$this->add($evento);
				}
			}
		}

		/**
		 * deleteUserRates: elimina las votaciones del evento y usuario pasados como
		 * parámetro.
		 * @param evento_id: el evento buscado
		 * @param user_id: el id del usuario.
		 */
		public function deleteUserRates($evento_id = null, $user_id = null) {
			if ($evento_id && $user_id) {
				$this->deleteAll(array(
					'Rate.event_id' => $evento_id,
					'Rate.user_id' => $user_id
				), false);
			}
		}

		/**
		 * userHasRated: retorna verdadero si el usuario que está registrado, ha
		 * hecho una votación,
		 * retorna falso en otro caso.
		 * @param evento: el evento a ser votado
		 * @param user->id: el id del usuario registrado.
		 */
		public function userHasRated($evento = null) {
			if ($evento && AuthComponent::user('id')) {
				$options['conditions'] = array(
					'event_id' => $evento->Event->id,
					'user_id' => AuthComponent::user('id')
				);
				$rate = $this->find('first', $options);
				return sizeof($rate) > 0;
			}
		}

	}
