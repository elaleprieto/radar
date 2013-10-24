<?php
App::uses('CategoriesPlace', 'Model');

/**
 * CategoriesPlace Test Case
 *
 */
class CategoriesPlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.categories_place',
		'app.category',
		'app.event',
		'app.place',
		'app.categories_event'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CategoriesPlace = ClassRegistry::init('CategoriesPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CategoriesPlace);

		parent::tearDown();
	}

}
