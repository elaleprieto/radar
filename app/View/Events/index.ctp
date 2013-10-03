<?php
	echo $this -> Html -> css(array(
		'inicio',
		'events/index'
	), '', array('inline' => false));
	echo $this -> Html -> script(array(
		'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true',
		'angular/filters',
		'events/index_an'
	), array('inline' => false));
?>

<?php //debug($this->request->clientIp()) ?>
<?php
	# User Location
	if (AuthComponent::user('location')) {
		$userLocation = AuthComponent::user('location');
	} else {
		$ip = '190.183.62.72';
		// $ip = $this->request->clientIp();
		$ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

		if ($ipData && $ipData -> geoplugin_countryName != null) {
			$userLocation = $ipData -> geoplugin_city . ', ' . $ipData -> geoplugin_countryName;

			# Se guarda el userLocation
			if ($userId = AuthComponent::user('id')) {
				// $this->requestAction(array('controller' => 'users', 'action' => 'setLocation')
				// , array('pass' => array($userId, $userLocation))
				// );
				$this -> requestAction("/users/setLocation/$userId/$userLocation");
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

	<!-- EAST -->
	<div id="east" ng-cloak>

		<!-- CATEGORÍAS -->
		<div ng-controller="CategoriaController">
			<div class="row" ng-init='categorias=<?php echo json_encode($categorias) ?>'>
				<div class="col-sm-12">

					<div class="background-white display-inline" ng-show="displayCategories">
						<p class="text-center"><?php echo __('Categories'); ?></p>
						<div class="row categoriaLink" ng-class="{highlight:categoria.highlight}" 
							ng-model="categoria" ng-repeat="categoria in categorias" ng-click="show(categoria)">
							<div class="col-sm-3">
								<img class="icono-categoria" 
									ng-src="<?php echo IMAGES_URL ?>categorias/{{categoria.Category.icon}}" />
							</div>
							<div class="col-sm-9 item-categoria" ng-bind="categoria.Category.name"></div>
						</div>
					</div>
					
					<!-- Button to Display or Hide Categories -->
					<div class="display-inline" ng-click="displayCategories = !displayCategories">
						<span class="btn btn-primary" ng-show="displayCategories">
							<i class="glyphicon glyphicon-chevron-left"></i>
						</span>
						<span class="btn btn-primary" ng-hide="displayCategories">
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
				<div class="display-inline" ng-click="displaySponsors = !displaySponsors">
					<span class="btn btn-primary" ng-hide="displaySponsors">
						<i class="glyphicon glyphicon-chevron-left"></i>
					</span>
					<span class="btn btn-primary" ng-show="displaySponsors">
						<i class="glyphicon glyphicon-chevron-right"></i>
					</span>
				</div>
				
				<!-- Sponsors	 -->
				<div class="background-white display-inline" ng-show="displaySponsors">
					<div class="col-sm-12">
						<a href="#"><?=$this -> Html -> image('sponsor/santafedisenia.jpg'); ?></a>
					</div>
					<div class="col-sm-12">
						<a href="#"><?=$this -> Html -> image('sponsor/tallercandombe.jpg'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south">

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
				<span class="btn btn-primary" ng-click="setMapType(ROADMAP)"><?php echo __('Map'); ?></span>
				<span class="btn btn-primary" ng-click="setMapType(SATELLITE)"><?php echo __('Satellite'); ?></span>
			</div>
		</div>


	    <!-- Events List -->
	    <div class="row">
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
    
	
	<div id="map_row">
	   	<div id="map"></div>
	</div>
</div>
