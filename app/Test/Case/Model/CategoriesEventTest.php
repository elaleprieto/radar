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
    
    // public function testFecha() {
        // $jsDate = "Sat Jul 06 2013 00:00:00 GMT-0300 (ART)"; 
        // $jsDateTS = strtotime($jsDate);
        // $this->assertTrue($jsDateTS !== false);
// 
        // $fecha = date('Y-m-d', $jsDateTS );
        // $this->assertEquals('2013-07-06', $fecha);
    // }

}
