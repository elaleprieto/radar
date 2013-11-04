<?php
/**
 * PlaceFixture
 *
 */
class PlaceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'lat' => array('type' => 'float', 'null' => false, 'default' => null),
		'long' => array('type' => 'float', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'accessibility_parking' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'accessibility_ramp' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'accessibility_equipment' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'accessibility_signage' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'accessibility_braile' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '52659993-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Birri',
			'sort' => 0,
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => NULL,
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => NULL,
			'website' => NULL,
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		),
			array(
			'id' => '52657773-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Molino',
			'sort' => 0,
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => NULL,
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => NULL,
			'website' => NULL,
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		)
	);

}
