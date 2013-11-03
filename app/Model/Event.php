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
		'title' => array('notempty' => array('rule' => array('notempty')))
		, 'status' => array('numeric' => array('rule' => array('numeric')))
		, 'date_start' => array('datetime' => array('rule' => array('datetime')))
		, 'date_end' => array('datetime' => array('rule' => array('datetime')))
		, 'place_id' => array('numeric' => array('rule' => array('numeric')))
		, 'Category' => array(
			'multiple' => array('rule' => array('multiple', array('min' => 1))
			, 'message' => 'Es necesario seleccionar al menos una categoría'
			, 'required' => true
			)
		)
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
	
	public function rate($id = null, $rate = null) {
		if($id && $rate && $rate > 0) {
			// $rateOld = $this->field('rate', array('id' => $id));
			$rateSum = $this->query("SELECT SUM(rate) as rateOld FROM rates WHERE event_id = '$id' GROUP BY event_id");			$rateSum = (Integer) $rateSum[0][0]['rateOld'];
			
			$count = $this->Rate->find('count', array('conditions' => array('Rate.event_id' => $id)));
			
			$rateNew = ceil($rateSum / $count);
			
			$this->id = $id;
			$this->saveField('rate', $rateNew);
		}
	}
}
