<?php
/**
 * CategoryFixture
 *
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'icon' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'name' => 'Arquitectura/Diseño',
			'icon' => 'arquitecturadisenio.png',
			'sort' => '0',
			'created' => '2013-03-03 19:47:31',
			'modified' => '2013-03-03 19:47:31'
		),
		array(
			'id' => '2',
			'name' => 'Artes Plásticas',
			'icon' => 'artesplasticas.png',
			'sort' => '0',
			'created' => '2013-03-03 19:49:31',
			'modified' => '2013-03-03 19:49:31'
		),
		array(
			'id' => '3',
			'name' => 'Cine',
			'icon' => 'cine.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:00',
			'modified' => '2013-03-03 19:50:00'
		),
		array(
			'id' => '4',
			'name' => 'Cuarteto',
			'icon' => 'cuarteto.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:13',
			'modified' => '2013-03-03 19:50:13'
		),
		array(
			'id' => '5',
			'name' => 'Danza',
			'icon' => 'danza.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:23',
			'modified' => '2013-03-03 19:50:23'
		),
		array(
			'id' => '6',
			'name' => 'Deportes',
			'icon' => 'deportes.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:37',
			'modified' => '2013-03-03 19:50:37'
		),
		array(
			'id' => '7',
			'name' => 'Escultura',
			'icon' => 'escultura.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:44',
			'modified' => '2013-03-03 19:50:44'
		),
		array(
			'id' => '8',
			'name' => 'Ferias',
			'icon' => 'ferias.png',
			'sort' => '0',
			'created' => '2013-03-03 19:50:58',
			'modified' => '2013-03-03 19:50:58'
		),
		array(
			'id' => '9',
			'name' => 'Fotografía',
			'icon' => 'fotografia.png',
			'sort' => '0',
			'created' => '2013-03-03 19:51:05',
			'modified' => '2013-03-03 19:51:05'
		),
		array(
			'id' => '10',
			'name' => 'Literatura',
			'icon' => 'literatura.png',
			'sort' => '0',
			'created' => '2013-03-03 19:51:17',
			'modified' => '2013-03-03 19:51:17'
		),
	);

}
