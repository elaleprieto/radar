<?php
	App::uses('AppModel', 'Model');
	/**
	 * Place Model
	 *
	 * @property Event $Event
	 */
	class Place extends AppModel {

		/**
		 * Validation rules
		 *
		 * @var array
		 */
		public $validate = array(
			'name' => array('notempty' => array('rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'sort' => array('numeric' => array('rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				), ),
			'email' => array('email' => array(
					'rule' => array(
						'email',
						true
					),
					'allowEmpty' => true,
					'required' => false,
				)),
			'website' => array('website' => array(
					'rule' => 'url',
					'allowEmpty' => true,
					'required' => false,
				)),
		);

		//The Associations below have been created with all possible keys, those that are
		// not needed can be removed

		/**
		 * hasMany associations
		 *
		 * @var array
		 */
		public $hasMany = array('Event' => array(
				'className' => 'Event',
				'foreignKey' => 'place_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			));

		public $hasAndBelongsToMany = array('Classification' => array(
				'className' => 'Classification',
				'joinTable' => 'classifications_places',
				'foreignKey' => 'place_id',
				'associationForeignKey' => 'classification_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			), );

		public function crear($place = null) {
			$this->begin();
			
			if (!$this->save($place['Place'])) {
				$this->rollback();
				return false;
			}
			
			# Se guardan las ClassificationPlace nuevas
			foreach ($place['Classification'] as $classification) :
				$this->ClassificationsPlace->create();
				$classificationsPlace['place_id'] = $this->id;
				$classificationsPlace['classification_id'] = $classification['id'];
				
				if (!$this->ClassificationsPlace->save($classificationsPlace)) {
					$this->rollback();
					return false;
				}
			endforeach;
			
			
			$this->commit();
			return true;
		}
		
		
		/**
		 * edita el place pasado como parámetro
		 * @param pedido
		 */
		public function edit($place = null) {
			$this->begin();

			if (!$this->save($place['Place'])) {
				$this->rollback();
				return false;
			}

			// # Se buscan las Classification guardadas
			// $classificationsEnPlace = array();
			// foreach ($place['Classification'] as $classification) :
				// $classificationsPlace['place_id'] = $this->id;
				// $classificationsPlace['classification_id'] = $classification['id'];
// 				
				// if (!$this->ClassificationsPlace->save($classificationsPlace)) {
					// $this->rollback();
					// return false;
				// }
// 				
				// array_push($classificationsEnPlace, $classification['id']);
			// endforeach;
// 
			// $conditions = array(
				// 'ClassificationsPlace.place_id' => $this->id,
				// 'NOT' => array('ClassificationsPlace.classification_id' => $classificationsEnPlace)
			// );
// 
			// # Se eliminan las ordenes que no están el pedido pasado como parámetro.
			// if (!$this->ClassificationsPlace->deleteAll($conditions, false)) {
				// $this->rollback();
				// return false;
			// }
			
			$conditions = array(
				'ClassificationsPlace.place_id' => $this->id,
			);

			# Se eliminan todas las referencias del Place en ClassificationPlace
			if (!$this->ClassificationsPlace->deleteAll($conditions, false)) {
				$this->rollback();
				return false;
			}
			
			# Se guardan las ClassificationPlace nuevas
			foreach ($place['Classification'] as $classification) :
				$this->ClassificationsPlace->create();
				$classificationsPlace['place_id'] = $this->id;
				$classificationsPlace['classification_id'] = $classification['id'];
				
				if (!$this->ClassificationsPlace->save($classificationsPlace)) {
					$this->rollback();
					return false;
				}
			endforeach;


			// Everything went well, commit and close the transaction
			$this->commit();
			return true;
		}

	}
?>