<?php
App::uses('Rol', 'Model');

/**
 * Rol Test Case
 *
 */
class RolTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.rol',
		'app.user',
		'app.event',
		'app.place',
		'app.classification',
		'app.classifications_place',
		'app.rate',
		'app.category',
		'app.categories_event'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rol = ClassRegistry::init('Rol');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rol);

		parent::tearDown();
	}

}
