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
 	
 	//public $useDbConfig = 'test';
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false,  'length' => 36, 'key' => 'primary'),
		//'id' => array('type' => 'string', 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		//'title' => array('type' => 'string'),		
		'address' => array('type' => 'string', 'null' => false,  'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		//'address' => array('type' => 'string'),
		'description' => array('type' => 'text'),
		//'description' => array('type' => 'text'),
		'lat' => array('type' => 'float', 'null' => false),
		'long' => array('type' => 'float', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		//'status' => array('type' => 'integer'),
		'date_start' => array('type' => 'datetime', 'null' => false),
		'date_end' => array('type' => 'datetime', 'null' => false),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		//'website' => array('type' => 'string'),
		'cost' => array('type' => 'float', 'null' => true, 'default' => null),
		//'cost' => array('type' => 'float'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		//'active' => array('type' => 'integer'),
		'verified' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		//'verified' => array('type' => 'integer'),
		'rate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		//'rate' => array('type' => 'integer'),
		'complaint' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		//'complaint' => array('type' => 'integer'),
		'created' => array('type' => 'datetime', 'null' => false),
		//'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime', 'null' => false),
		//'modified' => array('type' => 'datetime'),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		//'category_id' => array('type' => 'integer'),
		'place_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36),
		//'place_id' => array('type' => 'string'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36),
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
			//'id' => '1',
			'id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
			'title' => 'Fiesta Electrónica',
			'address' => 'Francia 3380, Santa Fe, Argentina',
			'description' => 'Lotus Club Rosario, como todos los años,  tiene bien acostumbrada a la ciudad en lo que 
								refiere a la escena electrónica local por la innovación constante en su artística 
								internacional, nacional y local.La fiesta electronica',
			'lat' => '-34.6076',
			'long' => '-58.4126',
			'status' => '1',
			'date_start' => '2013-06-26 19:52:00',
			'date_end' => '2013-06-26 20:52:00',
			'website' => 'www.lafiesta.com',
			'cost' => '23',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-03 19:52:57',
			'modified' => '2013-03-03 19:52:57',
			//'Category' => array(array('Category' => array('id' => '11'))),
			'category_id' => '11',
			'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
		),
		array(
			'id' => '2',
			'title' => 'Muestra de talleres UNL',
			'address' => 'Bulevard Pellegrini 2750, Santa Fe, Argentina',
			'description' => 'En la muestra anual de todos los talleres de la UNL se presentan los trabajos 
								desarrollados por los alumnos de todas las especialidades.',
			'lat' => '-34.5944',
			'long' => '-58.3719',
			'status' => '0',
			'date_start' => '2013-06-27 22:08:00',
			'date_end' => '2013-06-27 22:08:00',
			'website' => '',
			'cost' => '',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-03 22:09:02',
			'modified' => '2013-03-03 22:09:02',
			//'Category' => array(array('Category' => array('id' => '2', 'id'=>'7'))),
			'category_id' => '2',
			'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
		),
		array(
			'id' => '3',
			'title' => 'Feria de artesanias',
			'address' => 'Bulevar 1600, Santa Fe, Argentina',
			'description' => 'La feria de artesanos del sol y la luna, se prepara para todos los domingos de Noviembre.',
			'lat' => '-31.6384',
			'long' => '-60.6932',
			'status' => '0',
			'date_start' => '2013-11-24 17:44:00',
			'date_end' => '2013-11-24 17:44:00',
			'website' => 'https://www.facebook.com/pages/Feria-del-Sol-y-de-la-Luna-Santa-Fe/166813746690246',
			'cost' => 'gratis',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-03-10 19:08:55',
			'modified' => '2013-03-10 19:08:55',
			//'Category' => array(array('Category' => array('id' => '8'))),
			'category_id' => '8',
			'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
		),
		array(
			'id' => '4',
			'title' => 'Recital de Puebla',
			'address' => '25 de Mayo 3301, Santa Fe, Argentina',
			'description' => 'La banda de rock Puebla se presenta por 4ta vez en el mítico bar',
			'lat' => '-31.6554',
			'long' => '-60.7187',
			'status' => '0',
			'date_start' => '2013-06-29 02:26:00',
			'date_end' => '2013-06-29 04:26:00',
			'website' => 'pueblaesrock.com.ar',
			'cost' => '$10',
			'active' => '1',
			'verified' => '1',
			'rate' => '0',
			'complaint' => '0',
			'created' => '2013-06-29 21:27:14',
			'modified' => '2013-03-10 21:27:14',
			//'Category' => array(array('Category' => array('id' => '11', 'id' => '9'))),
			'category_id' => '9',
			'place_id' => '0'
		),
	);

}
