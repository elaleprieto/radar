<?php
App::uses('CategoriesPlace', 'Model');

/**
 * CategoriesPlace Test Case
 *
 */
class CategoriesPlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.categories_place',
		'app.category',
		'app.place'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CategoriesPlace = ClassRegistry::init('CategoriesPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CategoriesPlace);

		parent::tearDown();
	}
	
	public function testCategoriesPlaceAll(){
		$categories_place = $this->CategoriesPlace->find('all');
    	$this->assertTrue(!empty($categories_place));	
	}

/*
 * Se prueba guardar un Category_place donde el Place y la Category existan.
 * Si se debería guardar ese registro.
 * 
 */
	public function testNewCategoriesPlaceWhereCategoyAndPlaceExists(){
		
		$data = array(
			'CategoriesPlace' => array(
				'id' => '52223f5b-ecb8-40d0-a041-31e54146329a',
				'category_id' => '1',
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a',
				'created' => '2013-10-21 11:51:07',
				'modified' => '2013-10-21 11:51:07'
			)
		);
		
		$result = $this->CategoriesPlace->save($data);
		
		$categories_place = $this->CategoriesPlace->find('count', array(
															'conditions' => array(
																'CategoriesPlace.id' => '52223f5b-ecb8-40d0-a041-31e54146329a')));
    	$this->assertEquals($categories_place, 1);	
	}

/*
 * Se prueba guardar un Category_place donde el Place exista y la Category no exista.
 * No se debería guardar ese registro.
 * 
 */
	public function testNewCategoriesPlaceWhereCategoyNoExistAndPlaceExist(){
		
		$data = array(
			'CategoriesPlace' => array(
				'id' => '52223f5b-ecb8-40d0-a011-11e14146329a',
				'category_id' => '100',
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a',
				'created' => '2013-10-21 11:51:07',
				'modified' => '2013-10-21 11:51:07'
			)
		);
		
		$result = $this->CategoriesPlace->save($data);
		
		$categories_place = $this->CategoriesPlace->find('first', array(
															'conditions' => array(
																'CategoriesPlace.id' => '52223f5b-ecb8-40d0-a011-11e14146329a')));
    	$this->assertEquals($categories_place, 0);	
	}

/*
 * Se prueba guardar un Category_place donde el Place exista y la Category no exista.
 * No se debería guardar ese registro.
 * 
 */
	public function testNewCategoriesPlaceWhereCategoyExistAndPlaceNoExist(){
		
		$data = array(
			'CategoriesPlace' => array(
				'id' => '52223f5b-ecb8-40d0-a011-11e14146329a',
				'category_id' => '1',
				'place_id' => '52651113-c2f0-43b8-b851-1e104a46329a',
				'created' => '2013-10-21 11:51:07',
				'modified' => '2013-10-21 11:51:07'
			)
		);
		
		$result = $this->CategoriesPlace->save($data);
		
		$categories_place = $this->CategoriesPlace->find('count', array(
															'conditions' => array(
																'CategoriesPlace.id' => '52223f5b-ecb8-40d0-a011-11e14146329a')));
    	$this->assertEquals($categories_place, 0);	
	}
}
