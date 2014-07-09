<?php
	# Styles
	echo $this->Html->css(array(
		'//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
		'vendors/typeahead.js-bootstrap',
		'events/index',
	), '', array('inline' => false));

	# User Location
	if (isset($userData['User']['location'])) {
		$userLocation = $userData['User']['location'];
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

<div data-ng-controller="EventsController" data-ng-init="user.locationAux='<?php echo $userLocation; ?>'; user.id='<?php echo AuthComponent::user('id'); ?>'">

	<!-- NORTH -->
	<!-- Navbar -->
	
	<!-- EAST -->
	<div id="east" data-ng-cloak>
			
		<!-- Location Advertise -->
		<div data-ng-cloak>
			
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
								<a href="#" data-ng-click="map.setZoom(map.getZoom() + 1)">
									<span class="fa fa-search-plus fa zoom-mas"></span>
								</a>
							</li>
							<li class="zoom-button">
								<a href="#" data-ng-click="map.setZoom(map.getZoom() - 1)">
									<span class="fa fa-search-minus zoom-menos"></span>
								</a>
							</li>
						</ul>
					<?php endif; ?>			
				</div>	
			</div>
			
			<div class="background-black locationBar input-group input-group-sm">
				
				<!-- <input class="form-control" 
					placeholder="<?php echo __('City: Rome, Italy'); ?>" 
					type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}" 
					data-ng-init="locationSearched=user.location"
					data-ng-model="locationSearched" /> -->
				
				<input autocomplete="off" 
					class="capitalize col-sm-11 form-control textbox typeahead" 
					placeholder="<?php echo __('Search Your City'); ?>" 
					type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}"
					<?php echo $userLocation ? 'value="'.$userLocation.'"' : ''; ?>
					data-ng-model="locationSearched" 
					data-ng-init="locationSearched=user.location" />
				
				<div class="input-group-btn">
					<button class="btn btn-default" tabindex="-1" title="<?php echo __('Search'); ?>" type="button" 
						data-ng-click="searchLocation(locationSearched)">
							<i class="glyphicon glyphicon-search"></i>
					</button>
					<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul role="menu" class="dropdown-menu pull-right">
						<li>
							<a href="#" data-ng-click="saveUserLocationPreferences()">
								<?php echo __('Save Location Preferences'); ?>
							</a>
						</li>
					</ul>
				</div>
				
			</div>
		</div>

		<br/>

		<!-- CATEGORIES -->
		<div data-ng-controller="CategoriesController">
			<div id="categoriesContainer" class="background-black color-white" data-ng-hide="hideCategories">
				
				<!-- Titulo -->
				<header class="row text-left">
					<div class="col-sm-5">
						<?php echo __('Categories'); ?>:
					</div>
					<div class="col-sm-7">
						<!-- Todas las categorías -->
						<span class="col-sm-6 pointer" data-ng-click="showAllCategories()">
							<?php echo __('All'); ?>
						</span>
						
						<!-- Ninguna -->
						<span class="col-sm-6 pointer" data-ng-click="hideAllCategories()">
							<?php echo __('None'); ?>
						</span>
					</div>
					
				</header>
				
				<!-- Scroll de Categorías -->
				<div id="categoryScroll">
					<div class="row categoriaLink" 
						data-ng-class="{highlight:categoria.highlight}" 
						data-ng-click="show(categoria)" 
						data-ng-model="categoria" 
						data-ng-repeat="categoria in categorias | orderBy:'Category.name'" >
	
							<!-- Icono de Categoría -->
							<div class="col-sm-3 col-xs-2 category-icon">
								<img class="icono-categoria" 
									data-ng-src="/img/categorias/{{categoria.Category.icon}}" />
							</div>

							<!-- Nombre de Categoría -->
							<div class="col-sm-8 item-categoria" data-ng-bind="categoria.Category.name"></div>
							
							<!-- Icono Select -->
							<div class="col-sm-1 item-categoria" data-ng-show="categoria.highlight">
								<i class="fa fa-check-square-o"></i>
							</div>

							<!-- Icono Deselect -->
							<div class="col-sm-1 item-categoria" data-ng-hide="categoria.highlight">
								<i class="fa fa-square-o"></i>
							</div>
					</div>
				</div>
			</div>
				
			<!-- Button to Display or Hide Categories -->
			<div class="arrow-category" data-ng-click="hideCategories = !hideCategories">
				<span class="arrow btn btn-xs" data-ng-hide="hideCategories">
					<i class="glyphicon glyphicon-chevron-left"></i>
				</span>
				<span class="arrow btn btn-xs" data-ng-show="hideCategories">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</span>
			</div>
		</div>
	</div>
	
	<!-- WEAST -->
	<div id="west" data-ng-cloak>
		
		<!-- SPONSOR -->
		<!-- Button to Display or Hide Sponsors -->
		<div class="arrow-sponsor background-black" data-ng-click="hideSponsors = !hideSponsors">
			<span class="arrow btn btn-xs" data-ng-show="hideSponsors">
				<i class="glyphicon glyphicon-chevron-left"></i>
			</span>
			<span class="arrow btn btn-xs" data-ng-hide="hideSponsors">
				<i class="glyphicon glyphicon-chevron-right"></i>
			</span>
		</div>
		
		<!-- Sponsors -->
		<div id="sponsorContainer" class="background-black text-center" data-ng-hide="hideSponsors">
			<?php echo $this->element('sponsors'); ?>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south" data-ng-cloak>
		
		<!-- Button to Display or Hide South Menu -->
		<!--
		<div class="arrow-south background-black" data-ng-click="hideSouthMenu = !hideSouthMenu">
		-->
		<div class="row arrow-south pull-right" data-ng-click="hideSouthMenu = !hideSouthMenu">
			<span class="arrow btn btn-xs" data-ng-hide="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-down"></i>
			</span>
			<span class="arrow btn btn-xs" data-ng-show="hideSouthMenu">
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
						<button type="radio" data-toggle="button" class="btn btn-verde " data-ng-click="setEventInterval(1)">
							<?php echo __('Today'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde"  data-ng-click="setEventInterval(2)">
							<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" data-toggle="button" class="btn btn-verde" data-ng-click="setEventInterval(7)">
							<?php echo __('This Week'); ?>
						</button>
					</div>
					<div id="eventInterval" class="control-group btn-group pull-right">
						<?php
						// echo $this->Html->link(__('Add Event')
						// , array('controller'=>'events', 'action'=>'add')
						// , array('class'=>'btn btn-warning pull-right'))
						?>
						<a href="/events/add" class="btn btn-warning pull-right" data-ng-click="add()">Agregar Evento</a>
					</div>
				</div>
				-->	
				<!-- Map Types -->
				<!--
				<div class="col-sm-4 text-right">
					<span class="btn btn-primary" data-ng-click="setMapType(ROADMAP)"><?php echo __('Map'); ?></span>
					<span class="btn btn-primary" data-ng-click="setMapType(SATELLITE)"><?php echo __('Satellite'); ?></span>
				</div>
				-->			

				<div class="col-sm-8 col-xs-10 background-black" id="btn-south">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group">
						<button type="radio" class="btn btn-verde-simple " 
							data-ng-class="{'active': eventInterval == 1}" data-ng-click="setEventInterval(1)">
								<?php echo __('Today'); ?>
						</button>
						<button type="radio" class="btn btn-verde-simple" 
							data-ng-class="{'active': eventInterval == 2}" data-ng-click="setEventInterval(2)">
								<?php echo __('Tomorrow'); ?>
						</button>
						<button type="radio" class="btn btn-verde-simple" 
							data-ng-class="{'active': eventInterval == 7}" data-ng-click="setEventInterval(7)">
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
							<a href="#" data-ng-click="map.setZoom(map.getZoom() + 1)">
								<span class="fa fa-search-plus fa zoom"></span>
							</a>
						</li>
						<li class="zoom-button">
							<a href="#" data-ng-click="map.setZoom(map.getZoom() - 1)">
								<span class="fa fa-search-minus zoom"></span>
							</a>
						</li>
					</ul>
				<?php endif; ?>			
				</div>
	-->			
			</div>

			<!-- Events List -->
			<div id="southList" class="row background-black color-white" 
				data-ng-class="{'southListEmpty': eventos.length == 0}"
				data-ng-hide="hideSouthMenu || !eventos">
				<div class="col-sm-12">
					<!-- Mensaje para cuando no hay categoría seleccionada -->
					<p data-ng-show="categoriesSelected.length == 0">
						<?php echo __('There is no Category selected.') ?>
					</p>
					<!-- Mensaje para cuando no hay espacios en la categoría -->
					<p data-ng-show="places && places.length == 0 && categoriesSelected.length > 0">
						<?php echo __('There is no Places for this category. Please contact us to add yours.') ?>
					</p>
					<p data-ng-show="eventos && eventos.length == 0 && categoriesSelected.length > 0">
						<?php echo __('There is no Events for this category.') ?>
						<a href="<?php echo __('/events').__('/add'); ?>">
							<?php echo __('Radear my events!') ?>
						</a>
					</p>
					<table class="table" data-ng-show="eventos.length > 0">
						<thead>
							<tr>
							<!--	<td class="text-center"><?php echo __('Category'); ?></td>-->
							<!--	<th><?php echo __('Date Start'); ?></th>
								<th><?php echo __('Date End'); ?></th>
								<th><?php echo __('Event'); ?></th>
								<th><?php echo __('Address'); ?></th>
								<th class="text-center"><?php echo __('Like'); ?></th>-->
								<!-- <th><?php echo __('Rate'); ?></th> -->
								<td>&nbsp;</td>
								<td class="text-center"><?php echo __('Start'); ?></td>
								<td class="text-center"><?php echo __('End'); ?></td>
								<td class="text-center"><?php echo __('Event'); ?></td>
								<td class="text-center"><?php echo __('Address'); ?></td>
								<!--<td class="text-center"><?php echo __('Like'); ?></td>-->
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-12" id="eventScroll">
					<table id="eventsList" class="table table-striped">
						<tbody>
							<tr data-ng-repeat="evento in eventos | orderBy:'Event.date_start'">
								<td>
									<div class="col-sm-3 category-icon">
										<img class="icono-categoria" 
											data-ng-src="/img/categorias/{{evento.Category.icon}}" />
									</div>
								</td>
								<td data-ng-bind="evento.Event.date_start | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td data-ng-bind="evento.Event.date_end | isodate | date:'dd/MM/yyyy HH:mm'"></td>
								<td data-ng-bind="evento.Event.title"></td>
								<td data-ng-bind="evento.Event.address"></td>
								<td class="pointer text-center" data-ng-cloak>
									<i class="fa fa-thumbs-o-up" data-ng-click="saveRatingToServer(evento, 1)" data-ng-hide="evento.Rate.user_id"></i>
									<i class="fa fa-thumbs-up" data-ng-click="saveRatingToServer(evento, -1)" data-ng-show="evento.Rate.user_id"></i>
									<span data-ng-bind="evento.Event.rate"></span>
								</td>
								<!-- <td>
									<div x-fundoo-rating x-max="max" on-rating-selected="saveRatingToServer(evento, newRating)"
										x-rating-value="evento.Event.rate" x-readonly="false" x-user-id="user.id" x-user-voted="evento.Rate.user_id"></div>
								</td> -->
								<td>
									<span class="pointer" data-ng-click="openCompliantModal(evento)" 
										data-ng-hide="evento.Compliant.user_id != null">
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
	
	<!-- Zoom vista-xs -->
	<div class="zoom-xs visible-xs">
		<?php
			# Si el usuario se encuenta en events/index ó en places/index se habilitan los botones de zoom 
			if(($this->request->controller == 'events' && $this->request->action == 'index') 
				|| ($this->request->controller == 'places' && $this->request->action == 'index')):
		?>
		<ul class="list-inline">
			<li>
				<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
					<span class="fa fa-search-plus fa"></span>
				</a>
			</li>
			<li>
				<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
					<span class="fa fa-search-minus"></span>
				</a>
			</li>
		</ul>
		<?php endif; ?>			
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
									data-ng-model="evento.Compliant.title" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputCompliantDescription" class="col-sm-2 control-label">
								<?php echo __('Description'); ?>
							</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="inputCompliantDescription" placeholder="<?php echo __('Description'); ?>"
									data-ng-model="evento.Compliant.description" />
								</textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<?php echo __('Close'); ?>
					</button>
					<button type="button" class="btn btn-primary" data-ng-click="denounce(evento)">
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
					<div data-ng-include src="modalURL" class="modal-body">
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

