<?php
App::uses('Classification', 'Model');

/**
 * Category Test Case
 *
 */
class ClassificationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.classification',
		'app.place',
		'app.classifications_place'	
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Classification = ClassRegistry::init('Classification');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Classification);

		parent::tearDown();
	}
	
	/**
	 * Se prueba la búsqueda de un Rate existente en la Base de Datos.
	 */
	public function testExistingClassification(){
		$resultado = $this->Classification->find('count', array(
										'conditions' => array(
											'Classification.id' => 1,
										)));
		$this->assertEquals($resultado, 1);
	}
	
	
	/**
	 * Prueba save de Classification ok.
	 * 
	 */
	public function testNewClassificationOk(){
		
		$data = array(
			'Classification' => array(
				'id' => 2,
				'name' => 'Biblioteca',
				'color' => '#2c5aa0',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Classification->save($data);
		$resultado = $this->Classification->find('count', array(
										'conditions' => array(
											'id' => 2
										)));
		$this->assertEquals($resultado, 1);
	}
	
	/**
	 * Prueba de Classification con Name Null
	 */	
	 public function testNewClassificationNameNull(){
	 	$data = array(
			'Classification' => array(
				'id' => 3,
				'name' => '',
				'color' => '#2c5fa0',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Classification->save($data);
		$resultado = $this->Classification->find('count', array(
										'conditions' => array(
											'id' => 3,
										)));
		$this->assertEquals($resultado, 0);
	 }
	 
	/**
	 * Prueba de Classification con Color Null
	 */	
	 public function testNewClassificationColorNull(){
	 	$data = array(
			'Classification' => array(
				'id' => 4,
				'name' => 'Cine',
				'color' => '',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Classification->save($data);
		$resultado = $this->Classification->find('count', array(
										'conditions' => array(
											'id' => 4,
										)));
		$this->assertEquals($resultado, 0);
	 }
	 
	/*
	 * Se prueba que se permite guardar una Categoría, si valor name es único.
	 * 
	 */
	public function testNewClassificationNameIsUnique(){
		$data = array(
			'Classification' => array(
				'id' => 5,
				'name' => 'Bar',
				'color' => '#2c5fb0',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Classification->save($data);
		$resultado = $this->Classification->find('count', array(
										'conditions' => array('id' => 5)));
		$this->assertEquals($resultado, 0);
	}
}
