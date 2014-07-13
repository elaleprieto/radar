<?php
App::uses('ClassificationsPlace', 'Model');

/**
 * ClassificationPlace Test Case
 *
 */
class ClassificationsPlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.classifications_place',
		'app.place',
		'app.classification'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClassificationsPlace = ClassRegistry::init('ClassificationsPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClassificationsPlace);

		parent::tearDown();
	}
    
	public function testExistingClassificationsPlace(){
		
		$resultado = $this->ClassificationsPlace->find('count', array(
										'conditions' => array(
											'ClassificationsPlace.id' => '52653f5b-ecb8-40d0-a041-31e54146329a',
										)));
		$this->assertEquals($resultado, 1);
	}
	
	/**
	 * Se prueba guardar un Classification Place con datos válidos.
	 * El ClassificationPlace debería guardarse.
	 */
	public function testNewClassificationPlaceOk(){
		$data = array(
			'id' => '22222a2a-ecb8-40d0-a041-31e54146329a',
			'classifications_id' => 1,
			'place_id' => '52657773-c2f0-43b8-b851-1e104a46329a',
			'created' => '2013-10-21 11:51:07',
			'modified' => '2013-10-21 11:51:07'
		);
		$result = $this->ClassificationsPlace->save($data);
		$resultado = $this->ClassificationsPlace->find('count', array(
										'conditions' => array(
											'ClassificationsPlace.id' => '22222a2a-ecb8-40d0-a041-31e54146329a')));
		$this->assertEquals($resultado, 1);
	}

	/**
	 * Se prueba guardar un Classification Place con place_id vacío.
	 * El ClassificationPlace NO debería guardarse.
	 */
	public function testNewClassificationPlaceWithPlaceidNull(){
		$data = array(
			'id' => '22222a3a-ecb8-40d0-a041-31e54146329a',
			'classifications_id' => 1,
			'place_id' => '',
			'created' => '2013-10-21 11:51:07',
			'modified' => '2013-10-21 11:51:07'
		);
		$result = $this->ClassificationsPlace->save($data);
		$resultado = $this->ClassificationsPlace->find('count', array(
										'conditions' => array(
											'ClassificationsPlace.id' => '22222a3a-ecb8-40d0-a041-31e54146329a')));
		$this->assertEquals($resultado, 0);
	}

	/**
	 * Se prueba guardar un Classification Place con place_id no existente.
	 * El ClassificationPlace NO debería guardarse.
	 */
	public function testNewClassificationPlaceWithClassificationidNull(){
		$data = array(
			'id' => '22222a4a-ecb8-40d0-a041-31e54146329a',
			'classifications_id' => NULL,
			'place_id' => '52657773-c2f0-43b8-b851-1e104a46329a',
			'created' => '2013-10-21 11:51:07',
			'modified' => '2013-10-21 11:51:07'
		);
		$result = $this->ClassificationsPlace->save($data);
		$resultado = $this->ClassificationsPlace->find('count', array(
										'conditions' => array(
											'ClassificationsPlace.id' => '22222a4a-ecb8-40d0-a041-31e54146329a')));
		$this->assertEquals($resultado, 0);
	}
}
