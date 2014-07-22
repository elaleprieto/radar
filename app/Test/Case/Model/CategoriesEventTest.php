<?php
App::uses('CategoriesEvent', 'Model');

/**
 * CategoriesEvent Test Case
 *
 */
class CategoriesEventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.categories_event',
		'app.category',
		'app.event',
		'app.place'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CategoriesEvent = ClassRegistry::init('CategoriesEvent');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CategoriesEvent);

		parent::tearDown();
	}

}
