<?php
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.place',
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
		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}
    
    public function testFecha() {
        $jsDate = "Sat Jul 06 2013 00:00:00 GMT-0300 (ART)"; 
        $jsDateTS = strtotime($jsDate);
        $this->assertTrue($jsDateTS !== false);

        $fecha = date('Y-m-d', $jsDateTS );
        $this->assertEquals('2013-07-06', $fecha);
    }

}
