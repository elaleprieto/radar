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
	
	/**
	 * Se prueba la búsqueda de un Rate existente en la Base de Datos.
	 */
	public function testExistingRate(){
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'Rate.id' => '52123993-c2f0-43b8-b851-1e104a46329a',
										)));
		$this->assertEquals($resultado, 1);
	}
	
	/**
 	 * Se prueba guardar un Rate con datos correctos.
  	 * Si se debería guardar ese registro.
 	 * 
	 */
	public function testNewRateOk(){
		
		$data = array(
			'Rate' => array(
				'id' => '52890431-c2f0-43c8-b851-1e104a45529a',
				'rate' => '1',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			));
		$result = $this->Rate->save($data);
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'Rate.id' => '52890431-c2f0-43c8-b851-1e104a45529a')));
		$this->assertEquals($resultado, 1);
	}
	
	/**
 	 * Se prueba guardar un Rate con datos de rate no numerico.
  	 * Si se debería guardar ese registro.
 	 * 
	 */
	public function testNewRateNotNumeric(){
		
		$data = array(
			'Rate' => array(
				'id' => '52890431-c2f0-43c8-b851-1e104a45444a',
				'rate' => 'A',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			));
		$result = $this->Rate->save($data);
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'Rate.id' => '52890431-c2f0-43c8-b851-1e104a45444a')));
		$this->assertEquals($resultado, 0);
	}

	/**
 	 * Se prueba guardar un Rate con datos de usuario no válido.
  	 * Si se debería guardar ese registro.
 	 * 
	 */
	public function testNewRateUserNotValid(){
		
		$data = array(
			'Rate' => array(
				'id' => '11111111-c2f0-43c8-b851-1e104a45444a',
				'rate' => 'A',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc1111a79',
			));
		$result = $this->Rate->save($data);
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'Rate.id' => '11111111-c2f0-43c8-b851-1e104a45444a')));
		$this->assertEquals($resultado, 0);
	}
	
	/**
 	 * Se prueba guardar un Rate con datos de evento no válido.
  	 * Si se debería guardar ese registro.
 	 * 
	 */
	public function testNewRateEventNotValid(){
		
		$data = array(
			'Rate' => array(
				'id' => '11111112-c2f0-43c8-b851-1e104a45444a',
				'rate' => 'A',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
				'user_id' => '5271039a-aaaa-42ff-917d-065cc1111a79',
			));
		$result = $this->Rate->save($data);
		$resultado = $this->Rate->find('count', array(
										'conditions' => array(
											'Rate.id' => '11111112-c2f0-43c8-b851-1e104a45444a')));
		$this->assertEquals($resultado, 0);
	}
}
