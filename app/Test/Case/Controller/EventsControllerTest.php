<?php
App::uses('EventsController', 'Controller');

/**
 * EventsController Test Case
 *
 */
class EventsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.place',
		'app.category',
		'app.categories_event',
		//'app.classification',
		//'app.classifications_place',
		'app.user',
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	//	$result = $this->testAction('/events/index');
		$result = $this->testAction('/events/index', array('return' => 'vars'));
      // debug($result);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$data = array(
        	'Event' => array(
				'id' => '527592a7-b555-41f9-a140-0fe8d18c1824',
				'title' => 'Fiesta',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'La fiesta',
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
				'category_id' => '1',
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
            )
        );
        $result = $this->testAction(
           			 	'/events/add',
            			array('data' => $data)
        );
        debug($result);
		
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$results = $this->testAction('events/edit/527592a7-b718-41f9-a140-0fe8d18c1824', array('return' => 'vars'));
 		debug($results);
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$results = $this->testAction('events/delete/527592a7-b718-41f9-a140-0fe8d18c1824');
 		debug($results);
	}

/**
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
	}

/**
 * testAdminDelete method
 *
 * @return void
 */
	public function testAdminDelete() {

	}

/**
 * getTest
 * 
 */
	public function testGet(){
		//$result = $this->Event->get();
		
	}


}
