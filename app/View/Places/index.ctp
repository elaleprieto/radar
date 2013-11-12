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
	<!-- LOGO -->
	<div id="logo">
		<?php echo $this->Html->link($this->Html->image("logo_blanco.png", array('alt' => 'logo')), '/', array('escape' => false)); ?>
	</div>

	<!-- NORTH -->
	<div ng-cloak>
		<div id="rampa"></div>
		<nav class="navbar navbar-inverse" role="navigation">
			
			<!-- Vista para dispositivos sm y xs -->
			<div class="visible-sm visible-xs hidden-md hidden-lg">
				<div class="navbar-collapse collapse col-xs-12">
					<ul class="nav navbar-nav menu-centro">
						<li><a href="/"><span class="glyphicon glyphicon-calendar"></span></a></li>
						<li class="active"><a href="/places"><span class="glyphicon glyphicon-map-marker"></span></a></li>
						
						<?php
						# Si el usuario es administrador se habilita el menú. 
						if ($this->Session->read('Auth.User.role') == 'admin'): 
						?>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-caret-down"></i>
									<span class="sr-only">Toggle Dropdown</span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="/admin/places/add">
											<?php echo __('Add Place'); ?>
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
												
						<li>
							<a href="/events/add">
								<button class="btn btn-warning btn-xs pull-right"><?php echo __('RADEA!'); ?></button>
							</a>
						</li>
					</ul>
					
					<!-- Nav right -->
					<ul class="nav navbar-nav navbar-right">
						
						<!-- Zoom -->
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
								<span class="fa fa-search-plus"></span>
							</a>
						</li>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
								<span class="fa fa-search-minus"></span>
							</a>
						</li>
						
						
						<li><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
						<li><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li> 
						<li><a href="https://twitter.com/radardecultura"  target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a></li>
						<li><a href="https://www.facebook.com/RadarDeCultura"  target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a></li>
						
						<?php if ($this->Session->read('Auth.User.name') != ''): ?>
							<li><a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
									<span><?php echo AuthComponent::user('name') ?> </span>
								</a>
							</li>
							<li>
								<?php echo $this->Facebook->logout(array(
									'label' => __('Logout'),
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
									echo $this->Html->link(__('Login'), array(
										'controller' => 'users',
										'action' => 'login'
									), array('id' => 'menu_superior_derecha_verde'));
								?>
							</li>
							<li>
								<?php echo $this->Html->link(__('Sign up!'), '/registrate', array('class' => 'menu_superior_derecha')); ?>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

			<!-- Vista para dispositivos md y lg -->
			<div class="navbar-collapse collapse navbar-radar-collapse visible-md visible-lg hidden-sm hidden-xs">
				<ul class="nav navbar-nav menu-centro">
					<li>
					<a href="/"><span class="glyphicon glyphicon-calendar"></span><?php echo __('Events'); ?></a>
					</li>
					<li class="active">
						<a href="/places"><span class="glyphicon glyphicon-map-marker"></span><?php echo __('Places'); ?></a>
					</li>
					
					<?php
					# Si el usuario es administrador se habilita el menú. 
					if ($this->Session->read('Auth.User.role') == 'admin'): 
					?>
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-caret-down"></i>
								<span class="sr-only">Toggle Dropdown</span>
							</a>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="/admin/places/add">
										<?php echo __('Add Place'); ?>
									</a>
								</li>
							</ul>
						</li>
					<?php endif; ?>
					
					<li>	
						<a href="/events/add" id="btn-radea">
							<button class="btn btn-warning pull-right">¡RADEAR MIS EVENTOS!</button>
						</a>
					</li>
				</ul>
				
				<!-- Nav right -->
				<ul class="nav navbar-nav navbar-right">
					
					<!-- Zoom -->
					<li class="zoom-button">
						<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
							<span class="fa fa-search-plus"></span>
						</a>
					</li>
					<li class="zoom-button">
						<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
							<span class="fa fa-search-minus"></span>
						</a>
					</li>

					<li><a>|</a></li> 
					
					<li><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
					<li><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li> 
					<li><a>|</a></li> 
					<li><a href="https://twitter.com/radardecultura" target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a></li>
					<li><a href="https://www.facebook.com/RadarDeCultura"  target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a></li>

					<?php if ($this->Session->read('Auth.User.name') != ''): ?>
						<li><a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
							<span><?php echo AuthComponent::user('name') ?> </span>
							</a>
						</li>
	
						<!-- Logout de facebook -->
						<li>
							<?php echo $this->Facebook->logout(array(
								'label' => __('Logout'),
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
								echo $this->Html->link(__('Login'), array(
									'controller' => 'users',
									'action' => 'login'
								), array('id' => 'menu_superior_derecha_verde'));
							?>
						</li>
						<li>
							<?php echo $this->Html->link(__('Sign up!'), '/registrate', array('class' => 'menu_superior_derecha')); ?>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</div>

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
						x-ng-repeat="classification in classifications | orderBy:'Classification.name'">
							<div class="col-sm-3 category-icon">
								<div class="classification" 
									x-ng-style="{'background-color':classification.Classification.color}">
								</div>
							</div>
							<div class="col-sm-9 item-categoria" ng-bind="classification.Classification.name"></div>
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
			
			<!-- Titulo -->
			<p>
				<?php
					echo $this->Html->link(__('Advertise here!'), '/contacto', array("class" => "btn btn-default btn-xs"));
				?>
			</p>
			
			
			<!--					
			<button type="button" class="close sponsor" ng-click="hideSponsors = !hideSponsors" 
				ng-hide="hideSponsors">
				<i class="fa fa-collapse-alt"></i>
			</button>
			<p class="text-center"><?php echo __('Sponsors'); ?></p>
			-->					
			<!-- <div class="col-sm-12">
				<a href="#"><?=$this -> Html -> image('sponsor/santafedisenia.jpg'); ?></a>
			</div>
			<div class="col-sm-12">
				<a href="#"><?=$this -> Html -> image('sponsor/tallercandombe.jpg'); ?></a>
			</div> -->
			
			<div class="col-sm-12">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Radar Derecho Vertical -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:160px;height:600px"
				     data-ad-client="ca-pub-1237436927136399"
				     data-ad-slot="9834504613"></ins>
				<script>
					( adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
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
		    					<th>Nombre</th>
		    					<th>Direccion</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    			    <tr ng-repeat="place in places | orderBy:'Place.name'">
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