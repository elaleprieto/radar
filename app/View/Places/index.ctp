<?php
	# Styles
	echo $this->Html->css(array(
		'//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
		'vendors/typeahead.js-bootstrap',
		'places/index',
	), '', array('inline' => false));

	# User Location
	if (isset($userData['User']['location'])) {
		$userLocation = $userData['User']['location'];
	} else {
		$userLocation = null;
	}
	// # User Location
	// if ($userData['User']['location']) {
		// $userLocation = $userData['User']['location'];
	// } else {
		// $ip = $this->request->clientIp();
		// if ($ip == '127.0.0.1')
			// $ip = '190.183.62.72';
		// $ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
		// if ($ipData && $ipData->geoplugin_countryName != null) {
			// $userLocation = $ipData->geoplugin_city . ', ' . $ipData->geoplugin_countryName;
// 
			// # Se guarda el userLocation
			// if ($userId = AuthComponent::user('id')) {
				// $this->requestAction("/users/setLocation/$userId/$userLocation");
			// }
		// } else {
			// $userLocation = null;
		// }
	// }
?>

<div data-ng-controller="PlacesController" data-ng-init="user.locationAux='<?php echo $userLocation; ?>'; user.id='<?php echo AuthComponent::user('id'); ?>'">

	<!-- NORTH -->
	<!-- Navbar -->

	<!-- EAST -->
	<div id="east" data-ng-cloak>
		<!-- Location Shortcuts -->
		<!-- 
		<div>
			<div id="locationShortcuts" class="btn-group" data-toggle="buttons-radio">
				<button class="btn btn-verde" data-toggle="button" data-ng-click="centerMap()">
					<?php echo __('Region'); ?>
				</button>
				<button class="btn btn-verde" data-toggle="button" data-ng-click="centerMap('cordoba')">Córdoba</button>
				<button class="btn btn-verde" data-toggle="button" data-ng-click="centerMap('santafe')">Santa Fe</button>
				<button class="btn btn-warning" data-toggle="button" data-ng-click="setLocation()">
					<?php echo __('My Location'); ?>
				</button>
			</div>
		</div> 
		-->
			
		<!-- Location Advertise -->
		<!--	
		<div data-ng-hide="hideLocationAdvertise" data-ng-show="!!user.location" data-ng-cloak>
			<div class="background-white alert alert-dismissable" data-ng-hide="showSearchLocationBar">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong data-ng-bind='user.location'></strong>
				<br />
				<?php echo __('Is not your current location?'); ?>
				<a href="#" data-ng-click="showSearchLocationBar = !showSearchLocationBar">
					<?php echo __('Change'); ?>
				</a> 
			</div>
			<div data-ng-show="showSearchLocationBar">
				<div class="input-group">
					<input class="form-control" data-ng-model="locationSearched" 
						placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
						ui-keypress="{13:'searchLocation(locationSearched)'}" />
					<span class="input-group-addon" data-ng-click="searchLocation(locationSearched)"
						title="<?php echo __('Search'); ?>">
						<i class="glyphicon glyphicon-search"></i>
					</span>
					<span class="input-group-addon" data-ng-click="showSearchLocationBar = !showSearchLocationBar" 
							title="<?php echo __('Hide'); ?>">
						<i class="glyphicon glyphicon-eye-close"></i>
					</span>
				</div>
			</div>
		</div>
		-->
		<div data-ng-cloak>
			<!-- Rama east. No está visible para dispositivos xs -->
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
			
			<!-- Address -->
			<div class="background-black locationBar input-group input-group-sm">
				<!-- <input class="form-control" data-ng-model="locationSearched" data-ng-init="locationSearched=user.location"
					placeholder="<?php echo __('City: Rome, Italy'); ?>" type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}" />
				 -->
				 
				<input autocomplete="off" 
					class="capitalize col-sm-11 form-control textbox typeahead" 
					placeholder="<?php echo __('Search Your City'); ?>" 
					type="text" 
					ui-keypress="{13:'searchLocation(locationSearched)'}"
					<?php echo $userLocation ? 'value="'.$userLocation.'"' : ''; ?>
					data-ng-model="locationSearched" 
					data-ng-init="locationSearched=user.location" />
				
				<!-- 
				<span class="input-group-addon" data-ng-click="searchLocation(locationSearched)"
					title="<?php echo __('Search'); ?>">
					<i class="glyphicon glyphicon-search"></i>
				</span> -->
				
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

		<br />
		
		<!-- CATEGORIES -->
		<div data-ng-controller="ClassificationsController">
			<div id="categoriesContainer" class="background-black color-white" data-ng-hide="hideCategories">
				
				<!-- <p class="text-center"><?php echo __('Categories'); ?></p> -->

				<!-- Titulo -->
				<header class="row text-left">
					<div class="col-sm-5">
						<?php echo __('Categories'); ?>:
					</div>
					<div class="col-sm-7">
						<!-- Todas las categorías -->
						<span class="col-sm-6 pointer" data-ng-click="showAllClassifications()">
							<?php echo __('All'); ?>
						</span>
						
						<!-- Ninguna -->
						<span class="col-sm-6 pointer" data-ng-click="hideAllClassifications()">
							<?php echo __('None'); ?>
						</span>
					</div>
					
				</header>

				<!-- Scroll de Categorías -->
				<div id="categoryScroll">
					<div class="row categoriaLink" 
						data-ng-class="{highlight:classification.highlight}" 
						data-ng-click="show(classification)" 
						data-ng-model="classification" 
						data-ng-repeat="classification in classifications | orderBy:'name'">
							
							<!-- Icono de Categoría -->
							<div class="col-sm-3 category-icon">
								<!-- <div class="classification" 
									data-ng-style="{'background-color':classification.color}">
								</div> -->
								<img class="icono-categoria" 
									data-ng-src="/img/classifications/{{classification.icon}}" />
							</div>

							<!-- Nombre de Categoría -->
							<div class="col-sm-8 item-categoria" data-ng-bind="classification.name"></div>

							<!-- Icono Select -->
							<div class="col-sm-1 item-categoria" data-ng-show="classification.highlight">
								<i class="fa fa-check-square-o"></i>
							</div>

							<!-- Icono Deselect -->
							<div class="col-sm-1 item-categoria" data-ng-hide="classification.highlight">
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

		<!-- Sponsors	 -->
		<div id="sponsorContainer" class="background-black text-center"  data-ng-hide="hideSponsors">
			<?php echo $this->element('sponsors'); ?>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south" data-ng-cloak>
		
		<!-- Button to Display or Hide South Menu -->
		<div class="row arrow-south pull-right" data-ng-click="hideSouthMenu = !hideSouthMenu">
			<span class="arrow btn btn-xs" data-ng-hide="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-down"></i>
			</span>
			<span class="arrow btn btn-xs" data-ng-show="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-up"></i>
			</span>
		</div>
		
		<div class="row color-white">
			<div class="row menu-south">
	
				<div class="col-sm-8 col-xs-10 background-black" id="btn-south">
					<input value="1" name="interval" type="hidden">
					<div id="eventInterval" class="control-group btn-group" data-toggle="buttons">
						<button type="radio" data-toggle="button" class="btn btn-verde-simple">
							<?php echo __('Places'); ?>
						</button>						
					</div>
				</div>
				<div class="col-sm-1 hidden-xs" id="rampa-south"> </div>
				
			</div>
	
			<!-- Places List -->
			<div id="southList" class="row background-black color-white" 
				data-ng-class="{'southListEmpty': places.length == 0}"
				data-ng-hide="hideSouthMenu || !places">
				<div class="col-sm-12">
					<!-- Mensaje para cuando no hay categoría seleccionada -->
					<p data-ng-show="classificationsSelected.length == 0">
						<?php echo __('There is no Category selected.') ?>
					</p>
					<!-- Mensaje para cuando no hay espacios en la categoría -->
					<p data-ng-show="places && places.length == 0 && classificationsSelected.length > 0">
						<?php echo __('There is no Places for this category. ') ?>
						<a href="<?php echo __('/contact'); ?>" class="linkradar">
							<?php echo __('Please contact us to add yours.') ?>
						</a>
					</p>
					<table id="eventsList" class="table table-striped" data-ng-show="places.length > 0">
						<thead>
							<tr>
								<th><?php echo __('Category'); ?></th>
								<th><?php echo __('Name')?></th>
								<th><?php echo __('Address')?></th>
							</tr>
						</thead>
						<tbody>
							<tr data-ng-repeat="place in places | orderBy:'Place.name'">
								<td>
									<div class="col-sm-3 category-icon">
										<img class="icono-categoria" 
											data-ng-src="/img/classifications/{{place.Classification.icon}}" />
									</div>
								</td>
								<td data-ng-bind="place.Place.name"></td>
								<td data-ng-bind="place.Place.address"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div>
		<div class="modal fade" id="placeViewModal" tabindex="-1" role="dialog" aria-labelledby="Places" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content detail">
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
					</div> 
					-->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	
	<div id="map"></div>
</div>