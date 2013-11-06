<?php
# Styles
echo $this->Html->css(array(
	'inicio',
	'events/index',
	'//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css',
	// '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css'
), '', array('inline' => false));

# User Location
if (AuthComponent::user('location')) {
	$userLocation = AuthComponent::user('location');
} else {
	$ip = $this->request->clientIp();
	if ($ip == '127.0.0.1')
		$ip = '190.183.62.72';
	$ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	if ($ipData && $ipData->geoplugin_countryName != null) {
		$userLocation = $ipData->geoplugin_city . ', ' . $ipData->geoplugin_countryName;

		# Se guarda el userLocation
		if ($userId = AuthComponent::user('id')) {
			$this->requestAction("/users/setLocation/$userId/$userLocation");
		}
	} else {
		$userLocation = null;
	}
}
?>

<link href='//api.tiles.mapbox.com/mapbox.js/v1.4.0/mapbox.css' rel='stylesheet' />
<script src='//api.tiles.mapbox.com/mapbox.js/v1.4.0/mapbox.js'></script>

<div  ng-init="user.locationAux='<?php echo $userLocation; ?>'; user.id='<?php echo AuthComponent::user('id'); ?>'">

	<!-- LOGO -->
	<div id="logo">
		<?php
		echo $this->Html->link($this->Html->image("logo_blanco.png", array('alt' => 'logo')), '/', array('escape' => false));
 		?>
	</div>

	<!-- NORTH -->
	<!-- <div id="north" ng-cloak>-->
	<div ng-cloak>
	
		<!-- Button to Display or Hide North Menu -->
		<!--
		<div class="arrow-sponsor" ng-click="hideNorth = !hideNorth">
			<span class="arrow btn btn-xs" ng-show="hideNorth">
				<i class="glyphicon glyphicon-chevron-left"></i>
			</span>
			<span class="arrow btn btn-xs" ng-hide="hideNorth">
				<i class="glyphicon glyphicon-chevron-right"></i>
			</span>
		</div>
		-->
		
		<!--
		<div class="display-inline" ng-hide="hideNorth">
			 <span class="menu">
				<?php echo $this->Html->link('Espacios', '/espacios'); ?>
			</span>
			<span class="menu">
				<?php echo $this->Html->link('Eventos', '/'); ?>
			</span> -->
		<!--	
		<div class="display-inline">
			<span id="contactAndAbout">
				<span class="menu">
					<a href="/about"><i class="icon-info-sign icon-large"></i></a>
				</span>
				<span class="menu">
					<a href="/contacto"><i class="icon-envelope-alt icon-large"></i></a>
				</span>
			</span>
			
			<span id="social">
				<span class="menu">
					<a href="https://twitter.com/radardecultura"><i class="icon-twitter-sign icon-large"></i></a>
				</span>
				<span class="menu">
					<a href="#"><i class="icon-facebook-sign icon-large"></i></a>
				</span>
			</span>
			-->
			
			<!-- Logged In User -->
			<!--			
			<?php if ($this->Session->read('Auth.User.name') != ''): ?>
				<span>
					<a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
						<span><?php echo AuthComponent::user('name') ?></span>
					</a>
				</span>
				 | 
				<span>
			-->
			<!--<?php 
					// echo $this->Html->link('Salir', array('controller'=>'users'
					//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
				?>-->
				<!-- Logout de facebook -->
				<!--
				<?php 
				//		echo $this->Facebook->logout(array(
				//			'label' => 'Salir',
				//			'redirect' => array(
				//				'controller' => 'users',
				//				'action' => 'logout'
				//			),
				//	));
	 				?>
				</span>
			<?php //else: ?>
				<span>
					<?php
				//		echo $this->Html->link('Ingresar', array(
				//		'controller' => 'users',
				//		'action' => 'login'
				//	), array('id' => 'menu_superior_derecha_verde'));
					?>
				</span>
				<span>
					<?php 
						//echo $this->Html->link('¡Registrate!', '/registrate', array('class' => 'menu_superior_derecha')); 
					?>
				</span>
			<?php endif; ?>
		
		</div>
		-->		
		<!-- North -->
		<!-- Rampa irregular del logo -->
		<div id="rampa"></div>
		<!-- Menú Superior -->
		<nav class="navbar navbar-inverse" role="navigation">
			<!-- Vista para dispositivos sm y xs -->
			<div class="visible-sm visible-xs hidden-md hidden-lg">
				<div class="navbar-collapse collapse col-xs-12">
		    		<ul class="nav navbar-nav menu-centro">
		    			<li class="active"><a href="/"><span class="glyphicon glyphicon-calendar"></span></a></li>
						<li><a href="/places"><span class="glyphicon glyphicon-map-marker"></span></a></li>
						<li><a href="/events/add" ng-click="add()"><button class="btn btn-warning btn-xs pull-right">RADEA!</button></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
		      			<li><a href="/about"><i class="icon-info-sign icon-large"></i></a></li>
		      			<li><a href="/contacto"><i class="icon-envelope icon-large"></i></a></li> 
		      			<li><a href="https://twitter.com/radardecultura" target="_blank"><i class="icon-twitter-sign icon-large"></i></a></li>
		      			<li><a href="https://www.facebook.com/RadarDeCultura" target="_blank"><i class="icon-facebook-sign icon-large"></i></a></li>
		      			<?php if ($this->Session->read('Auth.User.name') != ''): ?>
							<li><a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
								<span><?php echo AuthComponent::user('name') ?> </span>
							</a></li>
				 		 
						<!--<?php 
							// echo $this->Html->link('Salir', array('controller'=>'users'
							//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
						?>-->
						<!-- Logout de facebook -->
						<li>
							<?php echo $this->Facebook->logout(array(
								'label' => 'Salir',
								'redirect' => array(
									'controller' => 'users',
									'action' => 'logout'
								),
							));
	 						?>
	 					</li>
						<?php else: ?>
						<li>
							<?php
							echo $this->Html->link('Ingresar', array(
								'controller' => 'users',
								'action' => 'login'
							), array('id' => 'menu_superior_derecha_verde'));
							?>
						</li>
						<li>
							<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class' => 'menu_superior_derecha')); ?>
						</li>
						<?php endif; ?>
		      		</ul>
				</div>
			</div>
		
		<!-- Brand and toggle get grouped for better mobile display -->
		<!--<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-radar-collapse">
      				<span class="sr-only">Toggle navigation</span>
      				<span class="icon-bar"></span>
      				<span class="icon-bar"></span>
      				<span class="icon-bar"></span>
    			</button>
		</div>-->
	
			<!-- Vista para dispositivos md y lg -->
			<div class="navbar-collapse collapse navbar-radar-collapse visible-md visible-lg hidden-sm hidden-xs">
		    	<ul class="nav navbar-nav menu-centro">
		    		<li class="active">
			    		<a href="/"><span class="glyphicon glyphicon-calendar"></span>
			    			<?php echo __('Event'); ?> 
			    		</a>
		    			<!--<?php //echo $this->Html->link('Eventos', '/'); ?>-->
		    		</li>
					<li>
						<a href="/places"><span class="glyphicon glyphicon-map-marker"></span>
							<?php echo __('Places'); ?>	
						</a>
					</li>
					<li>	
						<a href="/events/add" id="btn-radea" ng-click="add()"><button class="btn btn-warning pull-right">¡RADEAR MIS EVENTOS!</button></a>
					</li>
		      	<!--<li>
		      		<a href="#"><span class="glyphicon"><img src="img/glyphicons/espacios.png"/></span> espacios</a>
				</li>-->
		    	</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/about"><i class="icon-info-sign icon-large"></i></a></li>
					<li><a href="/contacto"><i class="icon-envelope icon-large"></i></a></li>
					<li><a>|</a></li>
					<li><a href="https://twitter.com/radardecultura" target="_blank"><i class="icon-twitter-sign icon-large"></i></a></li>
					<li><a href="https://www.facebook.com/RadarDeCultura" target="_blank"><i class="icon-facebook-sign icon-large"></i></a></li>
		      
		      		<?php if ($this->Session->read('Auth.User.name') != ''): ?>
						<li><a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
							<span><?php echo AuthComponent::user('name') ?> </span>
							</a>
						</li>
				 		 
				<!--<?php 
						// echo $this->Html->link('Salir', array('controller'=>'users'
						//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
					?>-->
						<!-- Logout de facebook -->
						<li>
							<?php echo $this->Facebook->logout(array(
								'label' => 'Salir',
								'redirect' => array(
									'controller' => 'users',
									'action' => 'logout'
								),
							));
	 						?>
	 					</li>
						<?php else: ?>
						<li>
							<?php
							echo $this->Html->link('Ingresar', array(
								'controller' => 'users',
								'action' => 'login'
							), array('id' => 'menu_superior_derecha_verde'));
							?>
						</li>
						<li>
							<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class' => 'menu_superior_derecha')); ?>
						</li>
						<?php endif; ?>
		      
			    		<!--
						<div class="display-inline">
				  			<span id="contactAndAbout">
								<span class="menu">
									<a href="/about"><i class="icon-info-sign icon-large"></i></a>
								</span>
								<span class="menu">
									<a href="/contacto"><i class="icon-envelope-alt icon-large"></i></a>
								</span>
							</span>
			
							<span id="social">
								<span class="menu">
									<a href="https://twitter.com/radardecultura"><i class="icon-twitter-sign icon-large"></i></a>
								</span>
								<span class="menu">
									<a href="#"><i class="icon-facebook-sign icon-large"></i></a>
								</span>
							</span>
	 						-->		
							<!-- Logged In User -->
							<!--
							<?php //if ($this->Session->read('Auth.User.name') != ''): ?>
							<span>
								<a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
									<span><?php echo AuthComponent::user('name') ?></span>
								</a>
							</span>
				 			| 
							<span>
							-->			
							<!--
							<?php 
								// echo $this->Html->link('Salir', array('controller'=>'users'
								//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
							?>-->
							<!-- Logout de facebook -->
							<!--
								<?php //echo $this->Facebook->logout(array(
					  				//	'label' => 'Salir',
					  				//			'redirect' => array(
									//			'controller' => 'users',
									//			'action' => 'logout'
									//		),
									//	));
	 							?>
							</span>
							<?php //else: ?>
							<span>
							<?php
								//echo $this->Html->link('Ingresar', array(
								//		'controller' => 'users',
								//			'action' => 'login'
								//	), array('id' => 'menu_superior_derecha_verde'));
							?>
							</span>
							<span>
								<?php //echo $this->Html->link('¡Registrate!', '/registrate', array('class' => 'menu_superior_derecha')); ?>
							</span>
							<?php //endif; ?>
			
						</div>
						-->
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>

	<!-- 
	<div id="north" class="row" ng-cloak> -->
		
		<!-- NAV LARGE -->
		<!-- 
		<nav class="navbar navbar-fixed-top" id="nav-large" ng-hide="hideNavLarge" role="navigation">
			<div class="container"> -->
				<!-- 
				<ul class="nav navbar-nav">
					<li>
						<?php echo $this->Html->link($this->Html->image("logo_radar_blanco.png", array('alt' => 'logo')), '/', array(
							'class' => 'menu_icono',
							'style' => 'padding-top: 8px',
							'escape' => false
						));
 						?>
					</li>
				</ul> -->
				<!-- 
				<ul class="nav navbar-nav" id="menu_superior">
					<li class="menu"><?php echo $this->Html->link('Espacios', '/espacios') ?></li>
					<li class="menu"><?php echo $this->Html->link('Eventos', '/') ?></li>
					<li class="menu"><?php echo $this->Html->link('Sobre radar', '/about') ?></li>
					<li class="menu"><?php echo $this->Html->link('Contacto', '/contacto') ?></li>
					<li class="menu">
						<span ng-click="hideNavLarge = !hideNavLarge">
							<i class="glyphicon glyphicon-minus-sign icon-minus" title="Mostrar Menos"></i>
						</span>
					</li>
				</ul>
				<ul id="menu_superior_derecha" class="nav navbar-nav navbar-right">
					<?php if ($this->Session->read('Auth.User.name') != ''): ?>
					<li>
						<a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
							<span><?php echo AuthComponent::user('name') ?></span>
						</a>
					</li>
					<li> 
					-->
				<!--<?php 
						// echo $this->Html->link('Salir', array('controller'=>'users'
						//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
					?>-->
					<!-- Logout de facebook -->
					<?php
					// echo $this->Facebook->logout(array(
					// 'label' => 'Salir',
					// 'redirect' => array(
					// 'controller' => 'users',
					// 'action' => 'logout'
					// ),
					// ));
					 ?>
					<!-- 
					</li>
					<?php else: ?>
					<li>
						<?php
							//echo $this->Html->link('Ingresar', array('controller'=>'users'
							//	, 'action'=>'login'),  array('id'=>'menu_superior_derecha_verde'))
						?>
					</li>
					<li>
						<?php //echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'menu_superior_derecha'))?>
					</li>
					<?php endif ?>
				</ul>
			</div>
		</nav> 
	</div> -->

	<!-- EAST -->
	<div id="east" ng-cloak>
		<!-- Location Shortcuts -->
		<!-- 
		<div>
			<div id="locationShortcuts" class="btn-group" data-toggle="buttons-radio">
				<button class="btn btn-verde" data-toggle="button" ng-click="centerMap()">
					<?php echo __('Region'); ?>
				</button>
				<button class="btn btn-verde" data-toggle="button" ng-click="centerMap('cordoba')">Córdoba</button>
				<button class="btn btn-verde" data-toggle="button" ng-click="centerMap('santafe')">Santa Fe</button>
				<button class="btn btn-warning" data-toggle="button" ng-click="setLocation()">
					<?php echo __('My Location'); ?>
				</button>
			</div>
		</div> 
		-->
			
		<!-- Location Advertise -->
		<div ng-cloak>
			<!-- 
			<div class="background-white alert alert-dismissable" ng-hide="showSearchLocationBar">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong ng-bind='user.location'></strong>
				<br />
				<?php echo __('Is not your current location?'); ?>
				<a href="#" ng-click="showSearchLocationBar = !showSearchLocationBar">
					<?php echo __('Change'); ?>
				</a> 
			</div>
			<div ng-show="showSearchLocationBar">
				<div class="input-group">
					<input class="form-control" ng-model="locationSearched" 
						placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
						ui-keypress="{13:'searchLocation(locationSearched)'}" />
					<span class="input-group-addon" ng-click="searchLocation(locationSearched)"
						title="<?php echo __('Search'); ?>">
						<i class="glyphicon glyphicon-search"></i>
					</span>
					
					<span class="input-group-addon" ng-click="showSearchLocationBar = !showSearchLocationBar" 
							title="<?php echo __('Hide'); ?>">
						<i class="glyphicon glyphicon-eye-close"></i>
					</span>
				</div>
			</div> 
			-->
			
			<!-- Rampa east para el Buscador del mapa. Se oculta para los dispositivos xs-->
			<div id="rampa-east" class="hidden-xs"> </div>
			<div class="background-black locationBar input-group">
				<input class="form-control" ng-model="locationSearched" ng-init="locationSearched=user.location"
					placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}" />
				<span class="input-group-addon" ng-click="searchLocation(locationSearched)"
					title="<?php echo __('Search'); ?>">
					<i class="glyphicon glyphicon-search"></i>
				</span>
			</div>
		</div>

		<br/>
		<!-- CATEGORIES -->
		<div >
			<div id="categoriesContainer" class="background-black color-white" ng-hide="hideCategories">
				
				<!-- Titulo -->
				<!-- 
				<button type="button" class="close" ng-click="hideCategories = !hideCategories" 
					ng-hide="hideCategories">
					<i class="icon-collapse-alt"></i>
				</button> -->
				<p class="text-center"><?php echo __('Categories'); ?></p>
				
				<!-- Scroll -->
				<div id="categoryScroll">
					<div class="row categoriaLink" ng-class="{highlight:categoria.highlight}" 
						ng-model="categoria" ng-repeat="categoria in categorias | orderBy:'Category.name'" ng-click="show(categoria)">
						<div class="col-sm-3 category-icon">
							<img class="icono-categoria" 
								ng-src="/img/categorias/{{categoria.Category.icon}}" />
						</div>
						<div class="col-sm-9 item-categoria" ng-bind="categoria.Category.name"></div>
					</div>
				</div>
			</div>
				
			<!-- Button to Display or Hide Categories -->
			<div class="arrow-category" ng-click="hideCategories = !hideCategories">
				<span class="arrow btn btn-xs" ng-hide="hideCategories">
					<i class="glyphicon glyphicon-chevron-left"></i>
				</span>
				<span class="arrow btn btn-xs" ng-show="hideCategories">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</span>
			</div>
		</div>
	</div>
	
	<!-- WEAST -->
	<div id="west" ng-cloak>
		
		<!-- SPONSOR -->
		<!-- Button to Display or Hide Sponsors -->
		<div class="arrow-sponsor background-black" ng-click="hideSponsors = !hideSponsors">
			<span class="arrow btn btn-xs" ng-show="hideSponsors">
				<i class="glyphicon glyphicon-chevron-left"></i>
			</span>
			<span class="arrow btn btn-xs" ng-hide="hideSponsors">
				<i class="glyphicon glyphicon-chevron-right"></i>
			</span>
		</div>
		
		<!-- Sponsors -->
		<div id="sponsorContainer" class="background-black" ng-hide="hideSponsors">
			
			<!-- Titulo -->
			<!-- 
			<button type="button" class="close sponsor" ng-click="hideSponsors = !hideSponsors" 
				ng-hide="hideSponsors">
				<i class="icon-collapse-alt"></i>
			</button>
			<p class="text-center"><?php echo __('Sponsors'); ?></p> -->
			
			<div class="col-sm-12">
				<a href="#"><?=$this->Html->image('sponsor/santafedisenia.jpg'); ?></a>
			</div>
			<br />
			<div class="col-sm-12">
				<a href="#"><?=$this->Html->image('sponsor/tallercandombe.jpg'); ?></a>
			</div>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south" ng-cloak>
		
		<!-- Button to Display or Hide South Menu -->
		<!--
		<div class="arrow-south background-black" ng-click="hideSouthMenu = !hideSouthMenu">
		-->
		<div class="row arrow-south pull-right" ng-click="hideSouthMenu = !hideSouthMenu">
			<span class="arrow btn btn-xs" ng-hide="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-down"></i>
			</span>
			<span class="arrow btn btn-xs" ng-show="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-up"></i>
			</span>
		</div>
		
		<!--<div class="background-black color-white">-->
		<div class="row color-white">
			<div class="row menu-south">
	
				<!-- Event Interval -->
				<!--		
				<div class="col-sm-8">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group" data-toggle="buttons">
						<button type="radio" data-toggle="button" class="btn disabled">
							<?php echo __('What to do?'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde " ng-click="setEventInterval(1)">
							<?php echo __('Today'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde"  ng-click="setEventInterval(2)">
							<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde" ng-click="setEventInterval(7)">
							<?php echo __('This Week'); ?>
						</button>
					</div>
					<div id="eventInterval" class="control-group btn-group pull-right">
						<?php
						// echo $this->Html->link(__('Add Event')
						// , array('controller'=>'events', 'action'=>'add')
						// , array('class'=>'btn btn-warning pull-right'))
						?>
						<a href="/events/add" class="btn btn-warning pull-right" ng-click="add()">Agregar Evento</a>
					</div>
				</div>
				-->	
				<!-- Map Types -->
				<!--
				<div class="col-sm-4 text-right">
					<span class="btn btn-primary" ng-click="setMapType(ROADMAP)"><?php echo __('Map'); ?></span>
					<span class="btn btn-primary" ng-click="setMapType(SATELLITE)"><?php echo __('Satellite'); ?></span>
				</div>
				-->			
								
				<div class="col-sm-8 col-xs-10 background-black" id="btn-south">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group" data-toggle="buttons">
						<button type="radio" data-toggle="button" class="btn btn-verde-simple " ng-click="setEventInterval(1)">
							<?php echo __('Today'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde-simple"  ng-click="setEventInterval(2)">
							<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde-simple" ng-click="setEventInterval(7)">
							<?php echo __('This Week'); ?>
						</button>
					</div>
					<div id="eventInterval" class="control-group btn-group pull-right">
						<?php
						// echo $this->Html->link(__('Add Event')
						// , array('controller'=>'events', 'action'=>'add')
						// , array('class'=>'btn btn-warning pull-right'))
						?>
						<!--				
						<a href="#/events/add" class="btn btn-warning pull-right" ng-click="add()">Agregar Evento</a>
						-->
					</div>
				</div>
				<!-- Rampa inferior, se oculta para dispositivos xs -->
				<div class="col-sm-1 hidden-xs" id="rampa-south"> </div>
			</div>
	
			<!-- Events List -->
			<div class="row background-black" ng-hide="hideSouthMenu">
				<div class="col-sm-12">
					<table id="eventsList" class="table table-striped">
						<thead>
							<tr>
								<th><?php echo __('Date Start'); ?></th>
								<th><?php echo __('Date End'); ?></th>
								<th><?php echo __('Event'); ?></th>
								<th><?php echo __('Address'); ?></th>
								<th><?php echo __('Rate'); ?></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="evento in eventos | orderBy:'Event.date_start'">
								<td ng-bind="evento.Event.date_start | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td ng-bind="evento.Event.date_end | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td ng-bind="evento.Event.title"></td>
								<td ng-bind="evento.Event.address"></td>
								<td>
									<div x-fundoo-rating x-max="max" on-rating-selected="saveRatingToServer(evento, newRating)"
										x-rating-value="evento.Event.rate" x-readonly="false" x-user-id="user.id" x-user-voted="evento.Rate.user_id"></div>
								</td>
								<td>
									<a href="#" x-ng-click="openCompliantModal(evento)" x-ng-hide="evento.Compliant.user_id != null">
										<?php echo __('Denounce'); ?>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="compliantViewModal" tabindex="-1" role="dialog" aria-labelledby="compliant" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title"><?php echo __('Denounce'); ?></h4> 
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputCompliantTitle" class="col-sm-2 control-label">
								<?php echo __('Title'); ?>
							</label>
							<div class="col-sm-10">
								<input class="form-control" id="inputCompliantTitle" 
									placeholder="<?php echo __('Title'); ?>" required="required" type="text" 
									x-ng-model="evento.Compliant.title" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputCompliantDescription" class="col-sm-2 control-label">
								<?php echo __('Description'); ?>
							</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="inputCompliantDescription" placeholder="<?php echo __('Description'); ?>"
									x-ng-model="evento.Compliant.description" />
								</textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<?php echo __('Close'); ?>
					</button>
					<button type="button" class="btn btn-primary" x-ng-click="denounce(evento)">
						<?php echo __('Denounce!'); ?>
					</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div>
		<div class="modal fade" id="eventViewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<!-- 
						<h4 class="modal-title">Modal title</h4> 
						-->
					</div>
					<div ng-include src="modalURL" class="modal-body">
					</div>
					<!-- 
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary">
							Save changes
						</button>
					</div> -->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	
	<div id="map"></div>
	<script type='text/javascript'>
		var map = L.mapbox.map('map', 'elaleprieto.g79k5cbm').setView([-31.64799, -60.71360], 15);
		// var map = L.mapbox.map('map', 'http://a.tile.openstreetmap.org/${z}/${x}/${y}.png').setView([40, -74.50], 9);

		// var map = L.mapbox.map('map');
		// var stamenLayer = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', {
		// attribution : 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY SA</a>.'
		// }).addTo(map);
		// var OSMLayer = L.tileLayer('http://a.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		// var OSMLayer = L.tileLayer('http://otile1.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png', {
		// var OSMLayer = L.tileLayer('http://otile1.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png', {
		// attribution : 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY SA</a>.'
		// }).addTo(map);
		// map.setView([-31.64799, -60.71360], 17);
		map.markerLayer.on('click', function(e) {
			map.panTo(e.layer.getLatLng());
		});

		// The GeoJSON representing the two point features
		var geoJson = {
			type : 'FeatureCollection',
			features : [{
				type : 'Feature',
				properties : {
					title : 'Washington, D.C.',
					'marker-color' : '#f00',
					'marker-size' : 'large',
					url : 'http://en.wikipedia.org/wiki/Washington,_D.C.'
				},
				geometry : {
					type : 'Point',
					coordinates : [-31.638, -60.7035]
				}
			}, {
				type : 'Feature',
				properties : {
					title : 'Baltimore, MD',
					'marker-color' : '#f00',
					'marker-size' : 'large',
					url : 'http://en.wikipedia.org/wiki/Baltimore'
				},
				geometry : {
					type : 'Point',
					coordinates : [-60.7085, -31.6523]
				}
			}]
		};

		// // Pass features and a custom factory function to the map
		// map.markerLayer.setGeoJSON(geoJson);

		L.mapbox.markerLayer(geoJson).addTo(map);

		L.mapbox.markerLayer({
			// this feature is in the GeoJSON format: see geojson.org
			// for the full specification
			type : 'Feature',
			geometry : {
				type : 'Point',
				// coordinates here are in longitude, latitude order because
				// x, y is the standard for GeoJSON and many formats
				coordinates : [-60.7085, -31.6523]
			},
			properties : {
				title : 'A Single Marker',
				description : 'Just one of me',
				// one can customize markers by adding simplestyle properties
				// http://mapbox.com/developers/simplestyle/
				'marker-size' : 'large',
				'marker-color' : '#f0a'
			}
		}).addTo(map);

		</script>
</div>
