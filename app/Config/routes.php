<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
 	Router::mapResources('categories');
 	Router::mapResources('classifications');
 	Router::mapResources('compliants');
 	Router::mapResources('events');
 	Router::mapResources('places');
 	Router::mapResources('rates');
 	Router::mapResources('users');
	Router::parseExtensions('json');
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('controller' => 'events', 'action' => 'index'));
	Router::connect('/about', array('controller'=>'pages', 'action'=>'display', 'about'));
	// Router::connect('/contacto', array('controller'=>'pages', 'action'=>'display', 'contacto'));
	Router::connect(__('/contact'), array('controller'=>'pages', 'action'=>'display', 'contacto'));
	
	# Events
	// Router::connect('/eventos', array('controller'=>'events', 'action'=>'index'));
	Router::connect(__('/events'), array('controller'=>'events', 'action'=>'index'));
	Router::connect(__('/events') . __('/add'), array('controller'=>'events', 'action'=>'add'));
	Router::connect(__('/events') . __('/resume'), array('controller'=>'events', 'action'=>'resume'));
	Router::connect(__('/admin') . __('/events') . __('/add'), array('admin'=>TRUE, 'controller'=>'events', 'action'=>'resume'));
	Router::connect(__('/admin') . __('/events') . __('/resume'), array('admin'=>TRUE, 'controller'=>'events', 'action'=>'resume'));
	Router::connect(__('/admin') . __('/events') . __('/index'), array('admin'=>TRUE, 'controller'=>'events', 'action'=>'resume'));

	# Places
	Router::connect(__('/places'), array('controller'=>'places', 'action'=>'index'));
	Router::connect(__('/admin') . __('/places') . __('/add'), array('admin'=>TRUE, 'controller'=>'places', 'action'=>'add'));
	Router::connect(__('/admin') . __('/places') . __('/index'), array('admin'=>TRUE, 'controller'=>'places', 'action'=>'index'));
	
	# Users
	Router::connect(__('/users'), array('controller'=>'users', 'action'=>'index'));
	Router::connect(__('/users') . __('/add'), array('controller'=>'users', 'action'=>'add'));
	
	Router::connect('/login', array('controller'=>'users', 'action'=>'login'));
	Router::connect('/confirm/*', array('controller'=>'users', 'action'=>'confirm'));
	// Router::connect('/radariza', array('controller'=>'pages', 'action'=>'display', 'radariza'));
	Router::connect(__('/emailconfirm'), array('controller'=>'pages', 'action'=>'display', 'emailconfirm'));
	// Router::connect('/registrate', array('controller'=>'users', 'action'=>'add'));
	Router::connect(__('/singup'), array('controller'=>'users', 'action'=>'add'));
    
	# Compliants
	
	Router::connect(__('/admin') . __('/compliants') , array('admin'=>TRUE, 'controller'=>'compliants', 'action'=>'index'));
	
	// # Locale routing for Places
	// $places = array('en' => 'places', 'de' => 'schlagzeilen', 'es'=>'espacios');
	// foreach ($places as $lang => $place) {
	// 	Router::connect("/$place", array('controller' => 'places', 'lang' => $lang));
	// }

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
