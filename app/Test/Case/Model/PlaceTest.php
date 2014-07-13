<?php
App::uses('Place', 'Model');

/**
 * Category Test Case
 *
 */
class PlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.place',
		'app.event',		
		'app.categories_event',
		'app.classification',
		'app.classifications_place'	
		
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Place = ClassRegistry::init('Place');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Place);

		parent::tearDown();
	}
	
	/*
	 * Se prueba guardar un place con datos correctos.
	 * Si se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceOk(){
		
		$data = array(
			'Place' => array(
				'id' => '53333-c2f0-43b8-b851-1e104a46329a',
				'name' => 'Molino',
				'sort' => '0',
				'lat' => '-31.6547',
				'long' => '-60.7238',
				'created' => '2013-10-21 18:16:03',
				'modified' => '2013-10-21 18:16:03',
				'description' => 'El birri',
				'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
				'phone' => NULL,
				'email' => 'celeweidmann@hotmail.com',
				'website' => NULL,
				'image' => NULL,
				'accessibility_parking' => '1',
				'accessibility_ramp' => '0',
				'accessibility_equipment' => '0',
				'accessibility_signage' => '0',
				'accessibility_braile' => '0',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			)
		);
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array(
											'id' => '53333-c2f0-43b8-b851-1e104a46329a',
										)));
		$this->assertEquals($resultado, 1);
	}	
	
	/*
	 * Se prueba guardar un place con el campo name vacío.
	 * No se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceNameEmtpy(){
		$data = array(
			'Place' => array(
			'id' => '53333-c2f0-43b8-b851-1e104a46329a',
			'name' => '',
			'sort' => '0',
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => 'El birri',
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => 'celeweidmann@hotmail.com',
			'website' => NULL,
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		));
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array('id' => '53333-c2f0-43b8-b851-1e104a46329a')));
		$this->assertEquals($resultado, 0);
	}
	
	/*
	 * Se prueba guardar un place con el campo email válido.
	 * Si se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceValidEmail(){
		$data = array(
			'Place' => array(
			'id' => '5222-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Molino',
			'sort' => '0',
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => 'El birri',
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => 'birri@gmail.com',
			'website' => NULL,
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		));
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array('id' => '5222-c2f0-43b8-b851-1e104a46329a')));
		$this->assertEquals($resultado, 1);
	}
	
	/*
	 * Se prueba guardar un place con el campo email inválido.
	 * No se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceInvalidEmail(){
		$data = array(
			'Place' => array(
			'id' => '5222-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Molino',
			'sort' => '0',
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => 'El birri',
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => 'birri123',
			'website' => NULL,
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		));
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array('id' => '5222-c2f0-43b8-b851-1e104a46329a')));
		$this->assertEquals($resultado, 0);
	}
	
	/*
	 * Se prueba guardar un place con el campo website válido.
	 * Si se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceValidUrl(){
		$data = array(
			'Place' => array(
			'id' => '1212-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Molino',
			'sort' => '0',
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => 'El birri',
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => NULL,
			'website' => 'elmolino.com',
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		));
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array('id' => '1212-c2f0-43b8-b851-1e104a46329a')));
		$this->assertEquals($resultado, 1);
	}
	
	/*
	 * Se prueba guardar un place con el campo website inválido.
	 * No se debería guardar ese registro.
	 * 
	 */
	public function testNewPlaceInvalidUrl(){
		$data = array(
			'Place' => array(
			'id' => '1212-c2f0-43b8-b851-1e104a46329a',
			'name' => 'El Molino',
			'sort' => '0',
			'lat' => '-31.6547',
			'long' => '-60.7238',
			'created' => '2013-10-21 18:16:03',
			'modified' => '2013-10-21 18:16:03',
			'description' => 'El birri',
			'address' => 'Gral Lopez 3650, Santa Fe, Argentina',
			'phone' => NULL,
			'email' => NULL,
			'website' => 'elmolino',
			'image' => NULL,
			'accessibility_parking' => '1',
			'accessibility_ramp' => '0',
			'accessibility_equipment' => '0',
			'accessibility_signage' => '0',
			'accessibility_braile' => '0',
			'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
		));
		
		$result = $this->Place->save($data);
		$resultado = $this->Place->find('count', array(
										'conditions' => array('id' => '1212-c2f0-43b8-b851-1e104a46329a')));
		$this->assertEquals($resultado, 0);
	}
	
}
