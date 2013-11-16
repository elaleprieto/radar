<?php
	# Styles
	echo $this->Html->css(array(
		'inicio',
		'events/index',
		'//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
		// '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css'
	), '', array('inline' => false));

	# User Location
	if (AuthComponent::user('location')) {
		$userLocation = AuthComponent::user('location');
	} else {
		$userLocation = null;
	}

	# Se elimina la consulta por la IP porque no funciona bien
	// else {
	// $ip = $this->request->clientIp();
	// if ($ip == '127.0.0.1')
	// $ip = '190.183.62.72';
	// $ipData =
	// @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	// if ($ipData && $ipData->geoplugin_countryName != null) {
	// // $userLocation = $ipData->geoplugin_city . ', ' .
	// $ipData->geoplugin_countryName;
	// $userLocation = $ipData->geoplugin_countryName;
	// $userLocationZoom = 4;
	//
	// # No se guardar el userLocation, a menos que se haga clic en el botón
	// explícitamente
	// // # Se guarda el userLocation
	// // if ($userId = AuthComponent::user('id')) {
	// // $this->requestAction("/users/setLocation/$userId/$userLocation");
	// // }
	// } else {
	// $userLocation = null;
	// }
	// }
?>

<div x-ng-controller="EventsController" x-ng-init="user.locationAux='<?php echo $userLocation; ?>'; user.id='<?php echo AuthComponent::user('id'); ?>'">

	<!-- NORTH -->
	<?php echo $this->element('navbar'); ?>


	<!-- EAST -->
	<div id="east" x-ng-cloak>
			
		<!-- Location Advertise -->
		<div x-ng-cloak>
			<!-- 
			<div class="background-white alert alert-dismissable" x-ng-hide="showSearchLocationBar">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong x-ng-bind='user.location'></strong>
				<br />
				<?php echo __('Is not your current location?'); ?>
				<a href="#" x-ng-click="showSearchLocationBar = !showSearchLocationBar">
					<?php echo __('Change'); ?>
				</a> 
			</div>
			<div x-ng-show="showSearchLocationBar">
				<div class="input-group">
					<input class="form-control" x-ng-model="locationSearched" 
						placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
						ui-keypress="{13:'searchLocation(locationSearched)'}" />
					<span class="input-group-addon" x-ng-click="searchLocation(locationSearched)"
						title="<?php echo __('Search'); ?>">
						<i class="glyphicon glyphicon-search"></i>
					</span>
					
					<span class="input-group-addon" x-ng-click="showSearchLocationBar = !showSearchLocationBar" 
							title="<?php echo __('Hide'); ?>">
						<i class="glyphicon glyphicon-eye-close"></i>
					</span>
				</div>
			</div> 
			-->
			
			<!-- Rampa east para el Buscador del mapa. Se oculta para los dispositivos xs-->
			<div id="rampa-east" class="hidden-xs"> 
			
				<div id="rampa-east-menos" class="hidden-xs"></div>
				<div id="rampa-east-mas" class="hidden-xs"></div>
				<div class="text-center">
					<?php
					# Si el usuario se encuenta en events/index ó en places/index se habilitan los botones de zoom 
					if(($this->request->controller == 'events' && $this->request->action == 'index') 
						|| ($this->request->controller == 'places' && $this->request->action == 'index')):
					?>
						<ul class="list-inline zoom-list">
							<li class="zoom-button">
								<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
									<span class="fa fa-search-plus fa zoom-mas"></span>
								</a>
							</li>
							<li class="zoom-button">
								<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
									<span class="fa fa-search-minus zoom-menos"></span>
								</a>
							</li>
						</ul>
					<?php endif; ?>			
				</div>	
			</div>
			
			<div class="background-black locationBar input-group input-group-sm">
				
				<input class="form-control" x-ng-model="locationSearched" x-ng-init="locationSearched=user.location"
					placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}" />
				<!--
				<span class="input-group-addon" x-ng-click="searchLocation(locationSearched)"
					title="<?php echo __('Search'); ?>">
						<i class="glyphicon glyphicon-search"></i>
				</span> -->
				
				<div class="input-group-btn">
					<button class="btn btn-default" tabindex="-1" title="<?php echo __('Search'); ?>" type="button" 
						x-ng-click="searchLocation(locationSearched)">
							<i class="glyphicon glyphicon-search"></i>
					</button>
					<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul role="menu" class="dropdown-menu pull-right">
						<li><a href="#" x-ng-click="saveUserLocationPreferences()"><?php echo __('Save Location Preferences'); ?></a></li>
					</ul>
				</div>
				
			</div>
		</div>

		<br/>
		<!-- CATEGORIES -->
		<div x-ng-controller="CategoriesController">
			<div id="categoriesContainer" class="background-black color-white" x-ng-hide="hideCategories">
				
				<!-- Titulo -->
				<p class="text-left">
					<?php echo __('Categories'); ?>
					
					<!-- Todas las categorías -->
					<span class="label label-primary pointer pull-right" x-ng-click="showAllCategories()">
						<?php echo __('All Categories'); ?>
					</span>
				</p>
				
				<!-- Scroll de Categorías -->
				<div id="categoryScroll">
					<div class="row categoriaLink" 
						x-ng-class="{highlight:categoria.highlight}" 
						x-ng-click="show(categoria)" 
						x-ng-model="categoria" 
						x-ng-repeat="categoria in categorias | orderBy:'Category.name'" >
							
							<div class="col-sm-3 category-icon">
								<img class="icono-categoria" 
									x-ng-src="/img/categorias/{{categoria.Category.icon}}" />
							</div>
							<div class="col-sm-9 item-categoria" x-ng-bind="categoria.Category.name"></div>
					</div>
				</div>
			</div>
				
			<!-- Button to Display or Hide Categories -->
			<div class="arrow-category" x-ng-click="hideCategories = !hideCategories">
				<span class="arrow btn btn-xs" x-ng-hide="hideCategories">
					<i class="glyphicon glyphicon-chevron-left"></i>
				</span>
				<span class="arrow btn btn-xs" x-ng-show="hideCategories">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</span>
			</div>
		</div>
	</div>
	
	<!-- WEAST -->
	<div id="west" x-ng-cloak>
		
		<!-- SPONSOR -->
		<!-- Button to Display or Hide Sponsors -->
		<div class="arrow-sponsor background-black" x-ng-click="hideSponsors = !hideSponsors">
			<span class="arrow btn btn-xs" x-ng-show="hideSponsors">
				<i class="glyphicon glyphicon-chevron-left"></i>
			</span>
			<span class="arrow btn btn-xs" x-ng-hide="hideSponsors">
				<i class="glyphicon glyphicon-chevron-right"></i>
			</span>
		</div>
		
		<!-- Sponsors -->
		<div id="sponsorContainer" class="background-black text-center" x-ng-hide="hideSponsors">
			<?php echo $this->element('sponsors'); ?>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south" x-ng-cloak>
		
		<!-- Button to Display or Hide South Menu -->
		<!--
		<div class="arrow-south background-black" x-ng-click="hideSouthMenu = !hideSouthMenu">
		-->
		<div class="row arrow-south pull-right" x-ng-click="hideSouthMenu = !hideSouthMenu">
			<span class="arrow btn btn-xs" x-ng-hide="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-down"></i>
			</span>
			<span class="arrow btn btn-xs" x-ng-show="hideSouthMenu">
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
						<button type="radio" data-toggle="button" class="btn btn-verde " x-ng-click="setEventInterval(1)">
							<?php echo __('Today'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde"  x-ng-click="setEventInterval(2)">
							<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde" x-ng-click="setEventInterval(7)">
							<?php echo __('This Week'); ?>
						</button>
					</div>
					<div id="eventInterval" class="control-group btn-group pull-right">
						<?php
						// echo $this->Html->link(__('Add Event')
						// , array('controller'=>'events', 'action'=>'add')
						// , array('class'=>'btn btn-warning pull-right'))
						?>
						<a href="/events/add" class="btn btn-warning pull-right" x-ng-click="add()">Agregar Evento</a>
					</div>
				</div>
				-->	
				<!-- Map Types -->
				<!--
				<div class="col-sm-4 text-right">
					<span class="btn btn-primary" x-ng-click="setMapType(ROADMAP)"><?php echo __('Map'); ?></span>
					<span class="btn btn-primary" x-ng-click="setMapType(SATELLITE)"><?php echo __('Satellite'); ?></span>
				</div>
				-->			

				<div class="col-sm-8 col-xs-10 background-black" id="btn-south">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group">
						<button type="radio" class="btn btn-verde-simple " 
							x-ng-class="{'active': eventInterval == 1}" x-ng-click="setEventInterval(1)">
								<?php echo __('Today'); ?>
						</button>
						<button type="radio" class="btn btn-verde-simple" 
							x-ng-class="{'active': eventInterval == 2}" x-ng-click="setEventInterval(2)">
								<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" class="btn btn-verde-simple" 
							x-ng-class="{'active': eventInterval == 7}" x-ng-click="setEventInterval(7)">
								<?php echo __('This Week'); ?>
						</button>
					</div>
				</div>
				
				<!-- Rampa inferior, se oculta para dispositivos xs -->
				<div class="col-sm-1 hidden-xs" id="rampa-south"> </div>
				
				
<!--				<div class="col-sm-2 col-xs-2 text-center">
				<?php
				# Si el usuario se encuenta en events/index ó en places/index se habilitan los botones de zoom 
				if(($this->request->controller == 'events' && $this->request->action == 'index') 
					|| ($this->request->controller == 'places' && $this->request->action == 'index')):
				?>
					<ul class="list-inline zoom-list">
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
								<span class="fa fa-search-plus fa zoom"></span>
							</a>
						</li>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
								<span class="fa fa-search-minus zoom"></span>
							</a>
						</li>
					</ul>
				<?php endif; ?>			
				</div>
	-->			
			</div>

			<!-- Events List -->
			<div class="row background-black color-white" ng-hide="hideSouthMenu">
				<div class="col-sm-12">
					<table class="table">
						<thead>
							<tr>
							<!--	<th><?php echo __('Date Start'); ?></th>
								<th><?php echo __('Date End'); ?></th>
								<th><?php echo __('Event'); ?></th>
								<th><?php echo __('Address'); ?></th>
								<th class="text-center"><?php echo __('Like'); ?></th>-->
								<!-- <th><?php echo __('Rate'); ?></th> -->
								<td class="text-center"><?php echo __('Start'); ?></td>
								<td class="text-center"><?php echo __('End'); ?></td>
								<td class="text-center"><?php echo __('Event'); ?></td>
								<td class="text-center"><?php echo __('Address'); ?></td>
								<td class="text-center"><?php echo __('Like'); ?></td>
								<th>&nbsp;</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-12" id="eventScroll">
					<table id="eventsList" class="table table-striped">
						<tbody>
							<tr x-ng-repeat="evento in eventos | orderBy:'Event.date_start'">
								<td x-ng-bind="evento.Event.date_start | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td x-ng-bind="evento.Event.date_end | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td x-ng-bind="evento.Event.title"></td>
								<td x-ng-bind="evento.Event.address"></td>
								<td class="pointer text-center" x-ng-cloak>
									<i class="fa fa-thumbs-o-up" x-ng-click="saveRatingToServer(evento, 1)" x-ng-hide="evento.Rate.user_id"></i>
									<i class="fa fa-thumbs-up" x-ng-click="saveRatingToServer(evento, -1)" x-ng-show="evento.Rate.user_id"></i>
									<span x-ng-bind="evento.Event.rate"></span>
								</td>
								<!-- <td>
									<div x-fundoo-rating x-max="max" on-rating-selected="saveRatingToServer(evento, newRating)"
										x-rating-value="evento.Event.rate" x-readonly="false" x-user-id="user.id" x-user-voted="evento.Rate.user_id"></div>
								</td> -->
								<td>
									<span class="pointer" x-ng-click="openCompliantModal(evento)" 
										x-ng-hide="evento.Compliant.user_id != null">
											<?php echo __('Denounce'); ?>
									</span>
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
					<div x-ng-include src="modalURL" class="modal-body">
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
</div>
