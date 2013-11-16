<?php
	# Styles
	echo $this->Html->css(array(
		'inicio',
		'places/index',
		'//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css'
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

<div ng-controller="PlacesController" ng-init="user.locationAux='<?php echo $userLocation; ?>'">

	<!-- NORTH -->
	<?php echo $this->element('navbar'); ?>

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
		<!--	
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
		-->
		<div ng-cloak>
			<!-- Rama east. No está visible para dispositivos xs -->
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

		<br />
		
		<!-- CATEGORIES -->
		<div ng-controller="ClassificationsController">
			<div id="categoriesContainer" class="background-black color-white" ng-hide="hideCategories">
				<p class="text-center"><?php echo __('Categories'); ?></p>
				<div id="categoryScroll">
					<div class="row categoriaLink" x-ng-class="{highlight:classification.highlight}" 
						x-ng-click="show(classification)" x-ng-model="classification" 
						x-ng-repeat="classification in classifications | orderBy:'name'">
							<div class="col-sm-3 category-icon">
								<div class="classification" 
									x-ng-style="{'background-color':classification.color}">
								</div>
							</div>
							<div class="col-sm-9 item-categoria" ng-bind="classification.name"></div>
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

		<!-- Sponsors	 -->
		<div id="sponsorContainer" class="background-black text-center"  ng-hide="hideSponsors">
			<?php echo $this->element('sponsors'); ?>
		</div>
	</div>

	<!-- SOUTH -->
	<div id="south" ng-cloak>
		
		<!-- Button to Display or Hide South Menu -->
		<div class="row arrow-south pull-right" ng-click="hideSouthMenu = !hideSouthMenu">
			<span class="arrow btn btn-xs" ng-hide="hideSouthMenu">
				<i class="glyphicon glyphicon-chevron-down"></i>
			</span>
			<span class="arrow btn btn-xs" ng-show="hideSouthMenu">
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
		    <div class="row background-black color-white" ng-hide="hideSouthMenu">
		    	<div class="col-sm-12">
		    		<table id="eventsList" class="table table-striped">
		    			<thead>
		    				<tr>
		    					<th><?php echo __('Category'); ?></th>
		    					<th><?php echo __('Name')?></th>
		    					<th><?php echo __('Address')?></th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    			    <tr ng-repeat="place in places | orderBy:'Place.name'">
		    			        <td>
		    			        	<div class="classification" 
										x-ng-style="{'background-color':place.Classification.color}">
									</div>
		    			        </td>
		    			        <td ng-bind="place.Place.name"></td>
		    			        <td ng-bind="place.Place.address"></td>
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
					</div> 
					-->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	
	<div id="map"></div>
</div>