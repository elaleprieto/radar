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
			'id' => '52653f5b-ecb8-40d0-a041-31e54146329a',
			'classifications_id' => 1,
			'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a',
			'created' => '2013-10-21 11:51:07',
			'modified' => '2013-10-21 11:51:07'
		),
	);

}
