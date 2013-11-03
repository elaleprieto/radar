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
				$rate['Rate']['rate'] = $evento -> Event -> rate;
				$rate['Rate']['event_id'] = $evento -> Event -> id;
				$rate['Rate']['user_id'] = AuthComponent::user('id');

				$this -> create();
				if ($this -> save($rate)) {
					$this -> Event -> rate($evento -> Event -> id, $evento -> Event -> rate);
				}
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
					'event_id' => $evento -> Event -> id,
					'user_id' => AuthComponent::user('id')
				);
				$rate = $this -> find('first', $options);
				return sizeof($rate) > 0;
			}
		}

	}
