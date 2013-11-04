<?php
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.place',
		'app.category',
		'app.categories_event',
		'app.user'	
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);
		parent::tearDown();
	}

/*
 * Se prueba que existan eventos en la base de datos cargados por el fixture.
 * Debería devolver un array con elementos.
 * 
 */
	public function testEventAll(){
		$events = $this->Event->find('all');
    	$this->assertTrue(!empty($events));	
	}

/*
 * Se prueba que exista el evento en la base de datos cargados por el fixture: Recital de Puebla.
 * Debería devolver un array con elementos.
 * 
 */	
	public function testEventFindTitle(){
		$events = $this->Event->find('first', array(
													'conditions' => array(
														'title' => 'Recital de Puebla')));
    	$this->assertTrue(!empty($events));	
	}

/*
 * Se prueba guardar un nueve Evento con todos los datos necesarios.
 * Debería devolver un array con un elemento.
 * 
 */	
	public function testNewEventOk(){	
		$data = array(
			'Event' => array(
				'id' => '5',
				'title' => 'Evento datos correctos',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento datos correctos.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$this->Event->create();
		$result = $this->Event->save($data);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento datos correctos',
									)));
									
		$this->assertEquals($resultado, 1);
	}
		
/*
 * Se prueba guardar un nueve Evento con el campo title vacío.
 * Al intentar guardarlo, debería devolver false.
 *  
 */
	public function testNewEventWithOutTitle(){
		$data = array(
			'Event' => array(
				'id' => '6',
				'title' => '',
				'address' => 'Francia 3380, Santa Fe',
				'description' => 'Evento con título vacío.',
				'lat' => '-34.5944',
				'long' => '-58.3719',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 22:09:02',
				'modified' => '2013-03-03 22:09:02',
				//'Category' => array(array('Category' => array('id' => '1'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '0'
			)
		);

		$result = $this->Event->save($data);
		
		$this->assertFalse($result);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo address vacío.
 * Al intentar guardarlo, debería devolver false.
 *  
 */
	public function testNewEventWithOutAddress(){
		$data = array(
			'Event' => array(
				'id' => '7',
				'title' => 'Evento sin dirección',
				'address' => '',
				'description' => 'Evento sin dirección',
				'lat' => '-34.5944',
				'long' => '-58.3719',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => NULL,
				'cost' => NULL,
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 22:09:02',
				'modified' => '2013-03-03 22:09:02',
				//'Category' => array(array('Category' => array('id' => '8'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '8'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);

		$this->assertFalse($result);
	}

/*
 * Se prueba guardar un nueve Evento con el campo description vacío.
 * Al intentar guardarlo, debería devolver false.
 *  
 */
	public function testNewEventWithOutDescription(){
		$data = array(
			'Event' => array(
				'id' => '8',
				'title' => 'Evento sin descripcion',
				'address' => '9 de Julio 2050, Santa Fe, Argentina',
				'description' => '',
				'lat' => '-34.5944',
				'long' => '-58.3719',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => NULL,
				'cost' => NULL,
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 22:09:02',
				'modified' => '2013-03-03 22:09:02',
				//'Category' => array(array('Category' => array('id' => '8'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '8'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);

		$this->assertFalse($result);
	}

/*
 * Se prueba guardar un nueve Evento con el campo website con una url válida.
 * Al guardarlo, debería devolver true.
 *  
 */
	public function testNewEventWithWebsiteValid(){
		$data = array(
			'Event' => array(
				'id' => '9',
				'title' => 'Fotografia',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'La fiesta',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => 'https://www.facebook.com/fotoclubsf',
				'cost' => '23',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				//'Category' => array(array('Category' => array('id' => '9'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '9'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Fotografia',
									)));
									
		$this->assertEquals($resultado, 1);
	}


/*
 * Se prueba guardar un nueve Evento con el campo website con una url no válida.
 * Al intentar guardarlo, debería devolver false.
 *  
 */
	public function testNewEventWithWebsiteInvalid(){
		$data = array(
			'Event' => array(
				'id' => '10',
				'title' => 'Muestra de Danza',
				'address' => '9 de Julio 2150, Santa Fe, Argentina',
				'description' => 'La fiesta',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => 'muestradanza',
				'cost' => '0',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				//'Category' => array(array('Category' => array('id' => '5'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '5'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		
		$this->assertFalse($result);
	}

/*
 * Se prueba guardar un nueve Evento sin categoría.
 * Debería ser falso.
 *  
 */
	public function testNewEventWithOutCategory(){
		$data = array(
			'Event' => array(
				'id' => '11',
				'title' => 'Evento Cine y Fotografía',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'La fiesta',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => 'www.cineyfoto.com',
				'cost' => '0',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array(),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);
		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento Cine y Fotografía',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con dos categorìas.
 * Debería guardarlo, y al buscarlo en la BD encontrarlo.
 *  
 */
	public function testNewEventWithTwoCategory(){
		$data = array(
			'Event' => array(
				'id' => '12',
				'title' => 'Evento Cine y Fotografía',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'La fiesta',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => 'www.cineyfoto.com',
				'cost' => '0',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				/*'Category' => array(
								array('Category' => array(
											'id' => '3'), 
									 	'Category' => array( 
											'id' => '9'))),
				*/							
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '9')),
								(int) 1 => array('Category' => array('id' => '3'))
				),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		//debug($result);
		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento Cine y Fotografía',
									)));
									
		$this->assertEquals($resultado, 1);
	}
	
/*
 * Se prueba guardar un nueve Evento con tres categorìas.
 * Debería guardarlo, y al buscarlo en la BD encontrarlo.
 *  
 */
	public function testNewEventWithThreeCategory(){
		$data = array(
			'Event' => array(
				'id' => '13',
				'title' => 'Evento Cine, Danza y Fotografía',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Muestra de Cine, Danza y Fotografía',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '0',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				//'Category' => array(array('Category' => array('id' => '3', 'id' => '5', 'id' => '9'))),
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '3')),
								(int) 1 => array('Category' => array('id' => '5')),
								(int) 2 => array('Category' => array('id' => '9'))
				),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$this->Event->save($data);
		//debug($this->Event->validationErrors);
		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento Cine, Danza y Fotografía',
									)));
									
		$this->assertEquals($resultado, 1);
	}
	
/*
 * Se prueba guardar un nueve Evento con tres categorìas.
 * Debería devolver false, al tener más de 3 categorías.
 *  
 */
	public function testNewEventWithFourCategory(){
		$data = array(
			'Event' => array(
				'id' => '14',
				'title' => 'Evento Cine, Danza, Literatura y Fotografía',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Muestra de Cine, Danza, Literatura y Fotografía',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '0',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array(
								(int) 0 => array('Category' => array('id' => '3')),
								(int) 1 => array('Category' => array('id' => '5')),
								(int) 2 => array('Category' => array('id' => '9')),
								(int) 3 => array('Category' => array('id' => '10'))
				),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);
		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento Cine, Danza, Literatura y Fotografía',
									)));
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start vacío.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartEmpty(){	
		$data = array(
			'Event' => array(
				'id' => '15',
				'title' => 'Evento sin fecha de inicio',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento sin fecha de inicio',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '',
				'date_end' => '2013-06-26 20:52:00',
				'website' => 'www.lafiesta.com',
				'cost' => '23',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento sin fecha de inicio',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start inválido.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartInvalid(){	
		$data = array(
			'Event' => array(
				'id' => '16',
				'title' => 'Evento fecha de inicio inválida',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Prueba de evento con fecha de inicio inválida.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '5 de mayo de 2013',
				'date_end' => '2013-06-26 20:52:00',
				'website' => 'www.lafiesta.com',
				'cost' => '23',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento fecha de inicio inválida',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_end vacío.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateEndEmpty(){	
		$data = array(
			'Event' => array(
				'id' => '17',
				'title' => 'Evento sin fecha de fin',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Prueba de Evento sin fecha de fin.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-26 20:00:00',
				'date_end' => '',
				'website' => 'www.lafiesta.com',
				'cost' => '23',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento sin fecha de fin',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_end inválido.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateEndInvalid(){	
		$data = array(
			'Event' => array(
				'id' => '18',
				'title' => 'Evento fecha de fin inválida',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Prueba de Evento con fecha de fin inválida.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-26 20:00:00',
				'date_end' => '25 de Abril',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento fecha de fin inválida',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo lat vacío.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithLatEmpty(){	
		$data = array(
			'Event' => array(
				'id' => '19',
				'title' => 'Evento lat vacío',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento lat vacío.',
				'lat' => '',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento lat vacío',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo lat inválido, tipo texto.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithLatInvalidLikeText(){	
		$data = array(
			'Event' => array(
				'id' => '20',
				'title' => 'Evento lat inválido, tipo text',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento lat inválido, tipo text.',
				'lat' => 'latitud',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento lat inválido, tipo text',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo long vacío.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithLongEmpty(){	
		$data = array(
			'Event' => array(
				'id' => '21',
				'title' => 'Evento long vacío',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento long vacío.',
				'lat' => '-34.6076',
				'long' => '',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento long vacío',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo long inválido, tipo texto.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithLongInvalidLikeText(){	
		$data = array(
			'Event' => array(
				'id' => '22',
				'title' => 'Evento long inválido, tipo text',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento long inválido, tipo text.',
				'lat' => '-34.6076',
				'long' => 'longitud',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento long inválido, tipo text',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo rate nulo.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithRateNull(){	
		$data = array(
			'Event' => array(
				'id' => '23',
				'title' => 'Evento rate null',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento rate null.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => NULL,
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento rate null',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo rate vacío.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithRateEmpty(){	
		$data = array(
			'Event' => array(
				'id' => '24',
				'title' => 'Evento rate empty',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento rate empty.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => '',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento rate empty',
									)));
									
		$this->assertEquals($resultado, 0);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo rate invalid.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithRateInvalidNotNumeric(){	
		$data = array(
			'Event' => array(
				'id' => '25',
				'title' => 'Evento rate invalid no numeric',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento rate invalid.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => 'cero',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento rate invalid no numeric',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo rate igual a 6 (fuera de rango).
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithRateInvalid6(){	
		$data = array(
			'Event' => array(
				'id' => '26',
				'title' => 'Evento rate invalid 6',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento rate invalid.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' => 6,
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento rate invalid 6',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo rate igual a 5 (dentro de rango).
 * El evento debería guardarse correctamente.
 * 
 */	
	public function testNewEventWithRateValid5(){	
		$data = array(
			'Event' => array(
				'id' => '27',
				'title' => 'Evento rate valid 5',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento rate invalid.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '5',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$this->Event->save($data);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento rate valid 5',
									)));
									
		$this->assertEquals($resultado, 1);
	}
	
/*
 * Se prueba guardar un nueve Evento con el campo complaint not numeric.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithComplaintInvalidNotNumeric(){	
		$data = array(
			'Event' => array(
				'id' => '28',
				'title' => 'Evento complaint not numeric',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento complaint not numeric.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-06 19:00:00',
				'date_end' => '2013-12-08 20:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => 'denunciado',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento complaint not numeric',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartBiggerThanDateEndYear(){	
		$data = array(
			'Event' => array(
				'id' => '29',
				'title' => 'Evento campo date_start mayor a date_end year',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo date_start mayor a date_end.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2014-12-08 19:00:00',
				'date_end' => '2013-12-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo date_start mayor a date_end year',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end Month.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartBiggerThanDateEndMonth(){	
		$data = array(
			'Event' => array(
				'id' => '30',
				'title' => 'Evento campo date_start mayor a date_end month',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo date_start mayor a date_end month.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-12-08 19:00:00',
				'date_end' => '2013-11-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo date_start mayor a date_end month',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end Day.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartBiggerThanDateEndDay(){	
		$data = array(
			'Event' => array(
				'id' => '31',
				'title' => 'Evento campo date_start mayor a date_end day',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo date_start mayor a date_end day.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-11-09 19:00:00',
				'date_end' => '2013-11-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo date_start mayor a date_end day',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end Hour.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartBiggerThanDateEndHour(){	
		$data = array(
			'Event' => array(
				'id' => '32',
				'title' => 'Evento campo date_start mayor a date_end hour',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo date_start mayor a date_end day.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-11-08 20:00:00',
				'date_end' => '2013-11-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo date_start mayor a date_end hour',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end Minute.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
	public function testNewEventWithDateStartBiggerThanDateEndMinute(){	
		$data = array(
			'Event' => array(
				'id' => '33',
				'title' => 'Evento campo date_start mayor a date_end minute',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo date_start mayor a date_end day.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-11-08 19:15:00',
				'date_end' => '2013-11-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '1'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo date_start mayor a date_end minute',
									)));
									
		$this->assertEquals($resultado, 0);
	}

/*
 * Se prueba guardar un nueve Evento con el campo date_start mayor a date_end Minute.
 * Al intentar guardar el evento, debería retornar false.
 * 
 */	
/*	public function testNewEventWithCategoryNotExist(){	
		$data = array(
			'Event' => array(
				'id' => '34',
				'title' => 'Evento campo category not exist',
				'address' => 'Francia 3380, Santa Fe, Argentina',
				'description' => 'Evento campo category not exist.',
				'lat' => '-34.6076',
				'long' => '-58.4126',
				'status' => '1',
				'date_start' => '2013-11-06 19:00:00',
				'date_end' => '2013-11-08 19:00:00',
				'website' => '',
				'cost' => '',
				'active' => '1',
				'verified' => '1',
				'rate' =>  '0',
				'complaint' => '0',
				'created' => '2013-03-03 19:52:57',
				'modified' => '2013-03-03 19:52:57',
				'Category' => array((int) 0 => array('Category' => array('id' => '120'))),
				'place_id' => '52659993-c2f0-43b8-b851-1e104a46329a'
			)
		);

		$result = $this->Event->save($data);
		//$this->assertFalse($result);
		debug($this->Event->validationErrors);

		$resultado = $this->Event->find('count', array(
									'conditions' => array(
										'title' => 'Evento campo category not exist',
									)));
									
		$this->assertEquals($resultado, 0);
	}*/
}