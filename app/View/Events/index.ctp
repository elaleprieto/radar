<?php
echo $this->Html->css(array('inicio', 'events/index'), '', array('inline' => false));
echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'angular/filters', 'events/index_an'), array('inline' => false));
?>

<?php //debug($this->request->clientIp()) ?>
<?php
# User Location
if (AuthComponent::user('location')) {
	$userLocation = AuthComponent::user('location');
} else {
	
	$ip = $this->request->clientIp();
	
	if($ip == '127.0.0.1')
		$ip = '190.183.62.72';
	
	$ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

	if ($ipData && $ipData->geoplugin_countryName != null) {
		$userLocation = $ipData->geoplugin_city . ', ' . $ipData->geoplugin_countryName;

		# Se guarda el userLocation
		if ($userId = AuthComponent::user('id')) {
			// $this->requestAction(array('controller' => 'users', 'action' => 'setLocation')
			// , array('pass' => array($userId, $userLocation))
			// );
			$this->requestAction("/users/setLocation/$userId/$userLocation");
		}
	} else {
		$userLocation = null;
	}
}
?>

<div ng-controller="EventoController" ng-init="user.location='<?php echo $userLocation; ?>'">
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
						<?php echo $this->Html->link($this->Html->image("logoBeta.png", array('alt' => 'logo')), '/', array('class' => 'menu_icono', 'style' => 'padding-top: 8px', 'escape' => false)); ?>
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
							<a> 
								<span><?php echo $this->Session->read('Auth.User.name') ?></span>
							</a>
						</li>
						<li>
							<!--<?php 
								// echo $this->Html->link('Salir', array('controller'=>'users'
								//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
							?>-->
							<!-- Logout de facebook -->
							<?php echo $this->Facebook->logout(array('label' => 'Salir', 'redirect' => array('controller' => 'users', 'action' => 'logout'), )); ?>
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

		<!-- CATEGORIES -->
		<div ng-controller="CategoriaController">
			<div class="row" ng-init='categorias=<?php echo json_encode($categorias) ?>'>
				<div class="col-sm-12">

					<div class="background-white display-inline" ng-hide="hideCategories">
						<p class="text-center"><?php echo __('Categories'); ?></p>
						<div id="categoryScroll">
							<div class="row categoriaLink" ng-class="{highlight:categoria.highlight}" 
								ng-model="categoria" ng-repeat="categoria in categorias" ng-click="show(categoria)">
								<div class="col-sm-3">
									<img class="icono-categoria" 
										ng-src="<?php echo IMAGES_URL ?>categorias/{{categoria.Category.icon}}" />
								</div>
								<div class="col-sm-9 item-categoria" ng-bind="categoria.Category.name"></div>
							</div>
						</div>
					</div>
					
					<!-- Button to Display or Hide Categories -->
					<div class="display-inline" ng-click="hideCategories = !hideCategories">
						<span class="btn btn-primary" ng-hide="hideCategories">
							<i class="glyphicon glyphicon-chevron-left"></i>
						</span>
						<span class="btn btn-primary" ng-show="hideCategories">
							<i class="glyphicon glyphicon-chevron-right"></i>
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
					<span class="btn btn-primary" ng-show="hideSponsors">
						<i class="glyphicon glyphicon-chevron-left"></i>
					</span>
					<span class="btn btn-primary" ng-hide="hideSponsors">
						<i class="glyphicon glyphicon-chevron-right"></i>
					</span>
				</div>
				
				<!-- Sponsors	 -->
				<div class="background-white display-inline" ng-hide="hideSponsors">
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

	<!-- SOUTH -->
	<div id="south" ng-cloak>
		
		<div class="background-white">
			<div class="row">
	
				<!-- Location Shortcuts -->
				<div class="col-sm-4">
					<div id="locationShortcuts" class="btn-group" data-toggle="buttons-radio">
						<button class="btn btn-verde" data-toggle="button" ng-click="centerMap()">Región</button>
						<button class="btn btn-verde" data-toggle="button" ng-click="centerMap('cordoba')">Córdoba</button>
						<button class="btn btn-verde" data-toggle="button" ng-click="centerMap('santafe')">Santa Fe</button>
						<button class="btn btn-warning" data-toggle="button" ng-click="setLocation()">Mi Ubicación</button>
					</div>
				</div>
	
				<!-- Event Interval -->
				<div class="col-sm-4">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group" data-toggle="buttons">
						<button type="radio" data-toggle="button" class="btn disabled">qué hacer...</button>
						<button type="radio" data-toggle="button" class="btn btn-verde " ng-click="setEventInterval(1)">Hoy</button>
						<button type="radio" data-toggle="button" class="btn btn-verde"  ng-click="setEventInterval(2)">Mañana</button>
						<button type="radio" data-toggle="button" class="btn btn-verde" ng-click="setEventInterval(7)">Próximos 7 días</button>
					</div>
					<div id="eventInterval" class="control-group btn-group pull-right">
						<?php echo $this->Html->link('Agregar evento'
							, array('controller'=>'events', 'action'=>'add')
							, array('class'=>'btn btn-warning pull-right'))
						?>
					</div>
				</div>
	
				<!-- Map Types -->
				<div class="col-sm-4 text-right">
					
					<!-- Button to Display or Hide South Menu -->
					<span ng-click="hideSouthMenu = !hideSouthMenu">
						<span class="btn btn-primary" ng-hide="hideSouthMenu">
							<i class="glyphicon glyphicon-chevron-down"></i>
						</span>
						<span class="btn btn-primary" ng-show="hideSouthMenu">
							<i class="glyphicon glyphicon-chevron-up"></i>
						</span>
					</span>
					
					<span class="btn btn-primary" ng-click="setMapType(ROADMAP)"><?php echo __('Map'); ?></span>
					<span class="btn btn-primary" ng-click="setMapType(SATELLITE)"><?php echo __('Satellite'); ?></span>
				</div>
			</div>
	
	
		    <!-- Events List -->
		    <div class="row" ng-hide="hideSouthMenu">
		    	<div class="col-sm-12">
		    		<table id="eventsList" class="table table-striped">
		    			<thead>
		    				<tr>
		    					<th>Fecha Inicio</th>
		    					<th>Fecha Fin</th>
		    					<th>Evento</th>
		    					<th>Dirección</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    			    <tr ng-repeat="evento in eventos | orderBy:'Event.date_start'">
		    			        <td ng-bind="evento.Event.date_start | isodate | date:'dd/MM/yyyy HH:mm'"></td>
		    			        <td ng-bind="evento.Event.date_end | isodate | date:'dd/MM/yyyy HH:mm'"></td>
		    			        <td ng-bind="evento.Event.title"></td>
		    			        <td ng-bind="evento.Event.address"></td>
		    			    </tr>
		    			</tbody>
		    		</table>
		    	</div>
		    </div>
		</div>
    </div>
    
   	<div id="map"></div>
</div>
