<?php
/**
 * RateFixture
 *
 */
class RateFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rate' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'event_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => '52123993-c2f0-43b8-b851-1e104a46329a',
			'rate' => '2',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		),
		array(
			'id' => '52123123-c5f0-48b8-b851-1e104a46329a',
			'rate' => '2',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		),	
	);
}