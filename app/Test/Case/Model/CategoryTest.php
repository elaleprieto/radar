<?php
App::uses('Category', 'Model');

/**
 * Category Test Case
 *
 */
class CategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category',
		'app.place',
		'app.event',		
		'app.categories_event',
		'app.classifications_place'	
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Category = ClassRegistry::init('Category');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);

		parent::tearDown();
	}
	
	/*
	 * Prueba save de Categoría ok.
	 * 
	 */
	public function testNewCategoryOk(){
		
		$data = array(
			'Category' => array(
				'id' => '12',
				'name' => 'Tecnologia',
				'icon' => 'tecnologia.png',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Category->save($data);
		$resultado = $this->Category->find('count', array(
										'conditions' => array(
											'name' => 'Tecnologia',
										)));
		$this->assertEquals($resultado, 1);
	}	
	
	/*
	 * Guardar una Categoría con valor name empty debería ser falso.
	 * 
	 */
	public function testNewCategoryNameEmtpy(){
		$data = array(
			'Category' => array(
				'id' => '21',
				'name' => '',
				'icon' => 'tecnologia.png',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Category->save($data);
		$resultado = $this->Category->find('count', array(
										'conditions' => array('id' => '21')));
		$this->assertEquals($resultado, 0);
	}
	
	/*
	 * Guardar una Categoría con valor sort no numérico debería ser falso.
	 * 
	 */
	public function testNewCategorySortNotNumeric(){
		$data = array(
			'Category' => array(
				'id' => '21',
				'name' => 'Tecnologia',
				'icon' => 'tecnologia.png',
				'sort' => 'aaa',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Category->save($data);
		$resultado = $this->Category->find('count', array(
										'conditions' => array('name' => 'Tecnologia')));
		$this->assertEquals($resultado, 0);
	}
	
	/*
	 * Se prueba que no se permite guardar una Categoría con valor icon vacío.
	 * 
	 */
	public function testNewCategoryIconEmpty(){
		$data = array(
			'Category' => array(
				'id' => '21',
				'name' => 'Tecnologia',
				'icon' => '',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Category->save($data);
		$resultado = $this->Category->find('count', array(
										'conditions' => array('id' => '21')));
		$this->assertEquals($resultado, 0);
	}
	
	/*
	 * Se prueba que se permite guardar una Categoría, si valor name es único.
	 * 
	 */
	public function testNewCategoryNameIsUnique(){
		$data = array(
			'Category' => array(
				'id' => '21',
				'name' => 'Cine',
				'icon' => 'cine.png',
				'sort' => '0',
				'created' => '2013-10-03 19:51:17',
				'modified' => '2013-10-03 19:51:17'
		));
		
		$result = $this->Category->save($data);
		$resultado = $this->Category->find('count', array(
										'conditions' => array('id' => '21')));
		$this->assertEquals($resultado, 0);
	}
}
