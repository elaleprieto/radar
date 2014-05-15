<?php
App::uses('User', 'Model');
App::uses('AppController', 'Controller');
/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.event',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);
		parent::tearDown();
	}
  
	public function testUserExists(){
		$resultado = $this->User->find('count', array(
										'conditions' => array(
											'id' => '5271039a-bdd8-42ff-917d-065cc0a80a79',
											)));
		$this->assertEquals($resultado, 1);
	}

	public function testUserExistsFb(){
		$resultado = $this->User->find('count', array(
										'conditions' => array(
											'facebook_id' => '548985783',
											)));
		$this->assertEquals($resultado, 1);
	}
/*
	public function testUserNewOk(){
		$data = array(
			'User' => array(
				'id' => '8889939a-bdd8-42ff-917d-065cc0a80a79',
				'username' => 'pedro',
				'password' => 'pedro',
				'role' => '',
				'name' => 'pedro',
				'email' => 'pedro@gmail.com',
				'active' => '1',
				'gender' => '1',
				'birthday' => '1990-12-30',
				'location' => 'Santa Fe, Argentina',
				'facebook_id' => '',
				'twitter_id' => '',
				'created' => '2013-10-30 10:03:22',
				'modified' => '2013-10-30 10:03:22',
			));
		
		$this->User->create();
		$result = $this->User->save($data);
		//debug($this->User->validationErrors);
		
		$resultado = $this->User->find('count', array(
										'conditions' => array(
											'id' => '8889939a-bdd8-42ff-917d-065cc0a80a79',
										)));
		$this->assertEquals($resultado, 1);
	}	
	*/
}
