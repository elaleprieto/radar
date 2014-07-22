<?php
App::uses('Compliant', 'Model');

/**
 * Compliant Test Case
 *
 */
class CompliantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.compliant',
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
		$this->Compliant = ClassRegistry::init('Compliant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Compliant);

		parent::tearDown();
	}

	/**
 	 * Se prueba la búsqueda de una Compliant existente en la Base de Datos.
 	 */
	public function testExistingCompliant(){
		$resultado = $this->Compliant->find('count', array(
										'conditions' => array(
											'Compliant.id' => '222643f3-d468-4fc7-85d6-22334a46329a',
										)));
		$this->assertEquals($resultado, 1);
	}
	
	/**
 	 * Se prueba guardar un Compliant con datos correctos.
  	 * Si se debería guardar ese registro.
 	 * 
	 */
	public function testNewCompliantOk(){	
		$data = array(
			'Compliant' => array(
				'id' => '222643f3-d468-4fc7-85d6-22334a46111a',
				'title' => 'b',
				'description' => 'b',
				'created' => '2013-11-03 09:39:15',
				'modified' => '2013-11-03 09:39:15',
				'event_id' => '527592a7-b718-41f9-a140-0fe8d18c1824',
				'user_id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
			));
		$result = $this->Compliant->save($data);
		$resultado = $this->Compliant->find('count', array(
										'conditions' => array(
											'Compliant.id' => '222643f3-d468-4fc7-85d6-22334a46111a')));
		$this->assertEquals($resultado, 1);
	}
	
}
