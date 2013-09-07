<?php
/**
 * EventFixture
 *
 */
class EventFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lat' => array('type' => 'float', 'null' => false, 'default' => null),
		'long' => array('type' => 'float', 'null' => false, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		'date_start' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'date_end' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		'verified' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'rate' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'complaint' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'place_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'title' => 'Fiesta',
			'lat' => '-34.6076',
			'long' => '-58.4126',
			'status' => '0',
			'date_start' => '2013-06-26 19:52:00',
			'date_end' => '2013-06-26 20:52:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-03 19:52:57',
			'modified' => '2013-03-03 19:52:57',
			'category_id' => '1',
			'place_id' => '0'
		),
		array(
			'id' => '2',
			'title' => 'Pelicula',
			'lat' => '-34.5944',
			'long' => '-58.3719',
			'status' => '0',
			'date_start' => '2013-06-27 22:08:00',
			'date_end' => '2013-06-27 22:08:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-03 22:09:02',
			'modified' => '2013-03-03 22:09:02',
			'category_id' => '1',
			'place_id' => '0'
		),
		array(
			'id' => '3',
			'title' => 'Feria',
			'lat' => '-31.6384',
			'long' => '-60.6932',
			'status' => '0',
			'date_start' => '2013-06-30 17:44:00',
			'date_end' => '2013-06-30 17:44:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-10 19:08:55',
			'modified' => '2013-03-10 19:08:55',
			'category_id' => '1',
			'place_id' => '0'
		),
		array(
			'id' => '4',
			'title' => 'Cumpleaños',
			'lat' => '-31.6394',
			'long' => '-60.7072',
			'status' => '0',
			'date_start' => '2013-11-10 21:02:00',
			'date_end' => '2013-11-10 21:02:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-10 21:03:08',
			'modified' => '2013-03-10 21:03:08',
			'category_id' => '12',
			'place_id' => '0'
		),
		array(
			'id' => '5',
			'title' => 'Fiesta de Disfraces',
			'lat' => '-31.6193',
			'long' => '-60.7029',
			'status' => '0',
			'date_start' => '2013-03-10 01:00:00',
			'date_end' => '2013-03-10 06:30:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-10 21:24:36',
			'modified' => '2013-03-10 21:24:36',
			'category_id' => '12',
			'place_id' => '0'
		),
		array(
			'id' => '6',
			'title' => 'Asamblea en el Birri',
			'lat' => '-31.6554',
			'long' => '-60.7187',
			'status' => '0',
			'date_start' => '2013-06-29 02:26:00',
			'date_end' => '2013-06-29 04:26:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-06-29 21:27:14',
			'modified' => '2013-03-10 21:27:14',
			'category_id' => '1',
			'place_id' => '0'
		),
		array(
			'id' => '7',
			'title' => 'Demo',
			'lat' => '-31.6297',
			'long' => '-60.7069',
			'status' => '0',
			'date_start' => '2013-03-29 18:53:00',
			'date_end' => '2013-03-29 18:53:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-28 18:57:15',
			'modified' => '2013-03-28 18:57:15',
			'category_id' => '15',
			'place_id' => '0'
		),
		array(
			'id' => '8',
			'title' => 'Prórroga',
			'lat' => '-31.6306',
			'long' => '-60.7085',
			'status' => '0',
			'date_start' => '2013-03-28 10:30:00',
			'date_end' => '2013-03-28 11:30:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-28 21:05:24',
			'modified' => '2013-03-28 21:05:24',
			'category_id' => '1',
			'place_id' => '0'
		),
		array(
			'id' => '9',
			'title' => 'Asamblea en el Birri',
			'lat' => '-31.6538',
			'long' => '-60.7222',
			'status' => '0',
			'date_start' => '2013-04-06 12:30:00',
			'date_end' => '2013-04-09 13:30:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-28 21:06:18',
			'modified' => '2013-03-28 21:06:18',
			'category_id' => '18',
			'place_id' => '0'
		),
		array(
			'id' => '10',
			'title' => 'afdaa',
			'lat' => '-31.6271',
			'long' => '-60.7006',
			'status' => '0',
			'date_start' => '2013-03-28 08:00:00',
			'date_end' => '2013-03-28 09:00:00',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-28 21:17:29',
			'modified' => '2013-03-28 21:17:29',
			'category_id' => '1',
			'place_id' => '0'
		),
	);

}
