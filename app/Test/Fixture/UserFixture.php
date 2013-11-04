<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
 	
 	public $useDbConfig = 'test';
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null),
		'role' => array('type' => 'string', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null),
		'email' => array('type' => 'string', 'null' => false, 'default' => null),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		'gender' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'birthday' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'location' => array('type' => 'string', 'null' => true, 'default' => null),
		'facebook_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'twitter_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
	
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
			'id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			'username' => 'juana',
			'password' => 'juana',
			'role' => 'admin',
			'name' => 'juana',
			'email' => 'juana@nita',
			'active' => '1',
			'gender' => '1',
			'birthday' => '',
			'location' => 'Santa Fe, Argentina',
			'facebook_id' => '',
			'twitter_id' => '',
			'created' => '2013-10-30 10:03:22',
			'modified' => '2013-10-30 10:03:22',
		),
	);

}
