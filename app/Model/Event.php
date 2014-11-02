<?php
App::uses('AppModel', 'Model');

/**
 * Event Model
 *
 * @property Category $Category
 * @property Place $Place
 */
class Event extends AppModel {
	
/**
 * Validation rules
 *
 * @var array
 */

	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		), 
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		), 
		'lat' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El campo latitud no puede ser vacío.',
			),
			'decimal' => array(
				'rule' => array('decimal'),
				'message' => 'El campo latitud debe ser un valor numérico.')
		), 
		'long' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El campo longitud no puede ser vacío.',
			),
			'decimal' => array(
				'rule' => array('decimal'),
				'message' => 'El campo longitud debe ser un valor numérico.')
		), 
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric')
			)
		),
		//'date_start' => array('datetime' => array('rule' => array('datetime')))
/*		'date_start' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'allowEmpty' => false,
				'message' => 'El evento debe tener una fecha de inicio.'
			)
		),
*/		
		'date_start' => array(
			'allowempty' => array(
				'rule' => array('notEmpty'),
				'allowEmpty' => false,
				'message' => 'El evento debe tener una fecha de inicio.'
			),
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'El evento debe tener una fecha de inicio válida.'
			),
		),
		// 'date_end' => array('datetime' => array('rule' => array('datetime')))
/*		'date_end' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'allowEmpty' => false,
				'message' => 'El evento debe tener una fecha de fin.'
			)
		), 
*/		
		'date_end' => array(
			'allowempty' => array(
				'rule' => array('notEmpty'),
				'allowEmpty' => false,
				'message' => 'El evento debe tener una fecha de fin.'
			),
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'El evento debe tener una fecha de fin válida.'
			),
			'fechas' => array(
				'rule' => array('dateStartSmallThanDateEnd', 'date_start'),
				'message' => 'La Fecha de fin del evento debe ser superior a la fecha de inicio'
			)
		),
		'image' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe seleccionar un archivo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'website' => array(
			'website' => array(
				'rule' => 'url', 
				'allowEmpty' => true, 
				'required' => false
			)
		),
		/*'Category' => array(
			'multiple' => array('rule' => array('multiple', array('min' => 1))
			, 'message' => 'Es necesario seleccionar al menos una categoría'
			, 'required' => true
			)
		)*/
		'rate' => array(
			'allowempty' => array(
				'rule' => array('notEmpty'),
				'allowEmpty' => false,
				'message' => 'El campo rate no puede ser vacío.'
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El campo rate debe ser un valor númerico.'
			),
			 'range' => array(
                'rule'    => array('range', -1, 6),
                'message' => 'El campo rate debe tener un valor entre 0 y 5'
            )
		),
		'complaint' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El campo complaint debe ser un valor numérico.'
			)
		),
		// 'Category' => array(
		// 	'multiple' => array(
		// 		'rule' => array(
		// 			'multiple', array(
		// 				'min' => 1,
		// 				'max' => 3
		// 			)
		// 		),
		// 	'message' => 'Es necesario seleccionar al menos una categoría. Máximo 3.',
		// 	'required' => true
		// 	)
		// )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Place' => array(
			'className' => 'Place',
			'foreignKey' => 'place_id',
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
	
	public $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'categories_events',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'category_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
	);
	
	public $hasMany = array(
		'Rate' => array(
			'className' => 'Rate',
			'foreignKey' => 'event_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave($options = array()){
		foreach (array_keys($this->hasAndBelongsToMany) as $model) {
			if(isset($this->data[$this->name][$model])) {
				$this->data[$model] = $this->data[$this->name][$model];
				unset($this->data[$this->name][$model]);
			}
		}
		return true;
	}
	

/*
 * Validación de Fechas. La fecha de fin debe ser superior a la fecha de inicio.
 * 
 */
	public function dateStartSmallThanDateEnd($date_end, $date_start) {
		return ($this->data[$this->alias]['date_start'] <
		$this->data[$this->alias]['date_end']) ? true : false;  	
   }

	public function isOwnedBy($eventId, $userId) {
		return $this->field('id', array('id' => $eventId, 'user_id' => $userId)) === $eventId;
	}

	public function rate($id = null, $rate = null) {
		if($id && $rate && $rate > 0) {
			// $rateOld = $this->field('rate', array('id' => $id));
			$rateSum = $this->query("SELECT SUM(rate) as rateOld FROM rates WHERE event_id = '$id' GROUP BY event_id");
			$rateSum = (Integer) $rateSum[0][0]['rateOld'];
			
			// $count = $this->Rate->find('count', array('conditions' => array('Rate.event_id' => $id)));
// 			
			// $rateNew = ceil($rateSum / $count);
			
			$this->id = $id;
			$this->saveField('rate', $rateSum);
			return $rateSum;
		}
	}

}
