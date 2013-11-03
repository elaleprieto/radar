<?php
App::uses('Compliant', 'Model');

/**
 * Compliant Test Case
 *
 */
class CompliantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.compliant',
		'app.event',
		'app.place',
		'app.category',
		'app.categories_event',
		'app.categories_place',
		'app.rate',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Compliant = ClassRegistry::init('Compliant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Compliant);

		parent::tearDown();
	}

}
