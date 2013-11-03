<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Event $Event
 */
class Category extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
        		'rule' => 'isUnique',
        	),
		),
		'icon' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sort' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	// public $hasMany = array(
		// 'Event' => array(
			// 'className' => 'Event',
			// 'foreignKey' => 'category_id',
			// 'dependent' => false,
			// 'conditions' => '',
			// 'fields' => '',
			// 'order' => '',
			// 'limit' => '',
			// 'offset' => '',
			// 'exclusive' => '',
			// 'finderQuery' => '',
			// 'counterQuery' => ''
		// )
	// );
	
	public $hasAndBelongsToMany = array(
		'Event' => array(
			'className' => 'Event',
			'joinTable' => 'categories_events',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'event_id',
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
		'Place' => array(
			'className' => 'Place',
			'joinTable' => 'classifications_places',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'place_id',
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

}
