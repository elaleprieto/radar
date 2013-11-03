<?php
/**
 * ClassificationsPlaceFixture
 *
 */
class ClassificationsPlaceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'classifications_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'place_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '527697f4-2f04-400c-80ba-40764a46329a',
			'classifications_id' => 1,
			'place_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-11-03 15:37:40',
			'modified' => '2013-11-03 15:37:40'
		),
	);

}
