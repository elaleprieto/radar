<?php
# Styles
echo $this->Html->css(array('events/index'), '', array('inline' => false));

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
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<div ng-controller="PlacesController" ng-init="user.locationAux='<?php echo $userLocation; ?>'">
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<!-- Error Message -->
				<div class="col-sm-4" ng-show="errorLocation" ng-cloak>
					<span class="alert" ng-bind="errorLocation"></span>
				</div>
			</div><br>
		</div>
	</div>

	<!-- NORTH -->
	<div id="north" class="row" ng-cloak>
		
		<!-- NAV SMALL -->
		<nav class="navbar navbar-default navbar-fixed-top" id="nav-small" ng-show="hideNavLarge" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">RADAR</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="menu"><?php echo $this->Html->link('Espacios', '/espacios') ?></li>
						<li class="menu"><?php echo $this->Html->link('Eventos', '/') ?></li>
						<li class="menu"><?php echo $this->Html->link('Sobre radar', '/about') ?></li>
						<li class="menu"><?php echo $this->Html->link('Contacto', '/contacto') ?></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="menu">
							<span ng-click="hideNavLarge = !hideNavLarge" >
								<i class="glyphicon glyphicon-plus-sign icon-plus" title="Mostrar Más"></i>
							</span>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>

		<!-- NAV LARGE -->
		<nav class="navbar navbar-fixed-top" id="nav-large" ng-hide="hideNavLarge" role="navigation">
			<div class="container">
				<ul class="nav navbar-nav">
					<li>
						<?php echo $this->Html->link($this->Html->image("logoBeta.png", array('alt' => 'logo')), '/', array(
							'class' => 'menu_icono',
							'style' => 'padding-top: 8px',
							'escape' => false
						));
 ?>
					</li>
				</ul>
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
							<!--<?php 
								// echo $this->Html->link('Salir', array('controller'=>'users'
								//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
							?>-->
							<!-- Logout de facebook -->
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
							echo $this->Html->link('Ingresar', array('controller'=>'users'
								, 'action'=>'login'),  array('id'=>'menu_superior_derecha_verde'))
							?>
						</li>
						<li>
							<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'menu_superior_derecha'))?>
						</li>
					<?php endif ?>
				</ul>
			</div>
		</nav>
	</div>

	<!-- EAST -->
	<div id="east" ng-cloak>
		
		<!-- Location Shortcuts -->
		<!-- <div>
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
		</div> -->
			
		<!-- Location Advertise -->
		<div ng-hide="hideLocationAdvertise" ng-show="!!user.location" ng-cloak>
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
		</div>

		<br />

		<!-- CATEGORIES -->
		<div ng-controller="CategoriesController">
			<div class="row">
				<div class="col-sm-12">

					<div id="categoriesContainer" class="background-white display-inline" ng-hide="hideCategories">
						
						<!-- Titulo -->
						<button type="button" class="close" ng-click="hideCategories = !hideCategories" 
							ng-hide="hideCategories">
								<i class="icon-collapse-alt"></i>
							</button>
						<p class="text-center"><?php echo __('Categories'); ?></p>
						
						<!-- Scroll -->
						<div id="categoryScroll">
							<div class="row categoriaLink" ng-class="{highlight:categoria.highlight}" 
								ng-model="categoria" ng-repeat="categoria in categorias | orderBy:'Category.name'" ng-click="show(categoria)">
								<div class="col-sm-3">
									<img class="icono-categoria" 
										ng-src="/img/categorias/{{categoria.Category.icon}}" />
								</div>
								<div class="col-sm-9 item-categoria" ng-bind="categoria.Category.name"></div>
							</div>
						</div>
					</div>
					
					<!-- Button to Display or Hide Categories -->
					<div class="display-inline" ng-click="hideCategories = !hideCategories">
						<span class="btn btn-primary btn-xs" ng-show="hideCategories">
							<i class="icon-caret-right"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- WEAST -->
	<div id="west" ng-cloak>
		
		<!-- SPONSOR -->
		<div class="row">
			<div class="col-sm-12">
				
				<!-- Button to Display or Hide Sponsors -->
				<div class="display-inline" ng-click="hideSponsors = !hideSponsors">
					<span class="btn btn-primary btn-xs" ng-show="hideSponsors">
						<i class="icon-caret-left"></i>
					</span>
					<!-- <span class="btn btn-primary" ng-hide="hideSponsors">
						<i class="glyphicon glyphicon-chevron-right"></i>
					</span> -->
				</div>
				
				<!-- Sponsors	 -->
				<div id="sponsorContainer" class="background-white display-inline" ng-hide="hideSponsors">
					
					<!-- Titulo -->
					<button type="button" class="close sponsor" ng-click="hideSponsors = !hideSponsors" 
						ng-hide="hideSponsors">
						<i class="icon-collapse-alt"></i>
					</button>
					<p class="text-center"><?php echo __('Sponsors'); ?></p>
					
					<div class="col-sm-12">
						<a href="#"><?=$this->Html->image('sponsor/santafedisenia.jpg'); ?></a>
					</div>
					<div class="col-sm-12">
						<a href="#"><?=$this->Html->image('sponsor/tallercandombe.jpg'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div>
		<div class="modal fade" id="placeViewModal" tabindex="-1" role="dialog" aria-labelledby="Places" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<!-- <h4 class="modal-title">Modal title</h4> -->
					</div>
					<div ng-include src="modalURL" class="modal-body">
					</div>
					<!-- <div class="modal-footer">
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
</div>
