<?php
App::uses('Rate', 'Model');

/**
 * Rate Test Case
 *
 */
class RateTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.rate',
		'app.event',
		'app.place',
		'app.category',
		'app.categories_event',
		'app.classifications_places',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rate = ClassRegistry::init('Rate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rate);

		parent::tearDown();
	}	
	
/*
 * Se prueba guardar un Rate con datos correctos.
 * Si se debería guardar ese registro.
 * 
 */
	public function testNewRateOk(){
		
		$data = array(
			'Rate' => array(
				'id' => '52123993-c2f0-43b8-b851-1e104a45529a',
				'rate' => '1',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'event_id' => '4',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			)
		);
		
		$result = $this->Rate->save($data);
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'id' => '52123993-c2f0-43b8-b851-1e104a45529a',
										)));
		$this->assertEquals($resultado, 1);
	}	
	
}
