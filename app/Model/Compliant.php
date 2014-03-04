<?php
	App::uses('AppModel', 'Model');
	/**
	 * Compliant Model
	 *
	 * @property Event $Event
	 * @property User $User
	 */
	class Compliant extends AppModel {

		/**
		 * Validation rules
		 *
		 * @var array
		 */
		public $validate = array(
			'title' => array('notempty' => array('rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'event_id' => array('uuid' => array('rule' => array('uuid'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'user_id' => array('uuid' => array('rule' => array('uuid'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		 * add: si el usuario está registrado, se agrega la denuncia del evento.
		 * @param evento: el evento denunciado
		 * @param user->id: el id del usuario registrado.
		 */
		public function add($evento = null) {
			if ($evento && AuthComponent::user('id') && !$this->userHasCompliant($evento)) {
				$compliant['Compliant']['title'] = $evento -> Compliant -> title;
				$compliant['Compliant']['description'] = $evento -> Compliant -> description;
				$compliant['Compliant']['event_id'] = $evento -> Event -> id;
				$compliant['Compliant']['user_id'] = AuthComponent::user('id');

				$this -> create();
				$this -> save($compliant);
			}
		}

		/**
		 * userHasCompliant: retorna verdadero si el usuario que está registrado, ha
		 * hecho una denuncia,
		 * retorna falso en otro caso.
		 * @param evento: el evento a ser denunciado
		 * @param user->id: el id del usuario registrado.
		 */
		public function userHasCompliant($evento = null) {
			if ($evento && AuthComponent::user('id')) {
				$options['recursive'] = -1;
				$options['conditions'] = array(
					'event_id' => $evento -> Event -> id,
					'user_id' => AuthComponent::user('id')
				);
				$compliant = $this -> find('first', $options);
				return sizeof($compliant) > 0;
			}
		}

	}
