<?php
App::uses('CategoriesController', 'Controller');

/**
 * CategoriesController Test Case
 *
 */
class CategoriesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category',
		'app.categories_event',
		'app.event',
		'app.place',
		'app.rate',
		'app.user',
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$result = $this->testAction('/events/index', array('return' => 'vars'));
    	debug($result);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$result = $this->testAction('events/view/527592a7-b718-41f9-a140-0fe8d18c1824');
 		debug($result);		
	}

/**
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
		/*
		$result = $this->testAction('/categories/admin_index', array('return' => 'vars'));
    	debug($result);
		*/
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
		/*$result = $this->testAction('/categories/admin_view/1', array('return' => 'vars'));
 		debug($result);	
		*/
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
		/*
		$result = $this->testAction('/categories/admin_add', array('return' => 'vars'));
    	debug($result);
		
		$data = array(
        	'Category' => array(
            	'id' => '23',
            	'name' => 'Tecnologia',
				'icon' => 'tecnologia.png',
				'sort' => '0',
				'created' => '2013-03-03 19:51:17',
				'modified' => '2013-03-03 19:51:17'
        	)
    	);
    	$this->testAction('/categories/admin_add', array('data' => $data));
		debug($result);
    	*/

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
}
