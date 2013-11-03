<?php
	echo $this -> Html -> css(array(
		'//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css',
		'places/add'
	), '', array('inline' => false));

	# User Location
	if (AuthComponent::user('location')) {
		$userLocation = AuthComponent::user('location');
	} else {
		$ip = $this -> request -> clientIp();
		if ($ip == '127.0.0.1')
			$ip = '190.183.62.72';

		$ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
		if ($ipData && $ipData -> geoplugin_countryName != null) {
			$userLocation = $ipData -> geoplugin_city . ', ' . $ipData -> geoplugin_countryName;

			# Se guarda el userLocation
			if ($userId = AuthComponent::user('id')) {
				$this -> requestAction("/users/setLocation/$userId/$userLocation");
			}
		} else {
			$userLocation = null;
		}
	}
?>

<div ng-controller="PlacesController" ng-init="user.location='<?php echo $userLocation; ?>'">

    <!-- BARRA PROGRESO -->
    <div class="row">
        <div class="progress">
            <div class="progress-bar progress-bar-success" style="width: 33%;">Info básica</div>
            <div class="progress-bar progress-bar-warning" style="width: 34%;">ubicación</div>
            <div class="progress-bar progress-bar-danger" style="width: 33%;">accesibilidad</div>     
        </div>
    </div>
    
    <!-- MENSAJES -->
    <div class="row">
        <div class="alert alert-error" id="alertMessage">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Cuidado!</strong><span id="alertMessageString">
                Los eventos no pueden pertenecer a más de 3 (tres) categorías.
            </span>
        </div>    
    </div>
    <div class="row">
        <h2><?php echo __('Add Place'); ?></h2>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<div class="row">
    		    <!-- FORMULARIO BÁSICO -->
    	       <form name="placeForm" ng-submit="submit()">
        			<div class="col-sm-4">
        				<div class="row">
        					<div class="col-sm-12">
        					    <div class="row">
                                    <h4>Información básica</h4>
                                </div>
        							
        						<!-- Name -->
        						<div class="row form-group">
                                	<label for="PlaceName"><?php echo __('Name'); ?></label>
                                    <input autofocus="true" class="textbox form-control" id="PlaceName" maxlength="255" 
                                        ng-model="place.name" required="required" type="text">
        						</div>
        							
        						<!-- Address -->
        						<div class="row">
        							<div class="form-group">
										<!-- <input class="span2" id="appendedInputButton" type="text"> -->
	                                    <label for="PlaceAddress"><?php echo __('Address'); ?></label>
	                            		<div class="input-group input-group-sm">
	                            			<input class="textbox col-sm-11 form-control" id="PlaceAddress" maxlength="255" 
	                                            ng-model="place.address" required="required" type="text">
											<span class="input-group-btn">
												<button class="btn btn-default" ng-click="setAddress()" type="button">
													 <span class="glyphicon glyphicon-map-marker"></span>
												</button>	
											</span>
	                            		</div>
									</div>
        						</div>
        							
        						<!-- Description -->
        						<div class="row form-group">
                                	<label for="PlaceDescription"><?php echo __('Description'); ?></label>
                                    <textarea class="textarea col-sm-12 form-control" cols="30" id="PlaceDescription" 
                                        ng-model="place.description" rows="4">
                                    </textarea>
        						</div>
        						
        						<!-- Phone -->
        						<div class="row form-group">
                                	<label for="PlacePhone"><?php echo __('Phone'); ?></label>
                                    <input autofocus="true" class="textbox form-control" id="PlacePhone" maxlength="255" 
                                        ng-model="place.phone" type="text">
        						</div>
        						
        						<!-- Email -->
        						<div class="row form-group">
                                	<label for="PlaceEmail"><?php echo __('Email'); ?></label>
                                    <input autofocus="true" class="textbox form-control" id="PlaceEmail" maxlength="255" 
                                        ng-model="place.email" type="text">
        						</div>
        						
        						<!-- Website -->
        						<div class="row form-group">
                                	<label for="PlaceWebsite"><?php echo __('Website'); ?></label>
                                    <input autofocus="true" class="textbox form-control" id="PlaceWebsite" maxlength="255" 
                                        ng-model="place.website" type="text">
        						</div>
        						
        						<!-- Photo -->
        						<div class="row form-group">
                                	<label for="PlacePhoto"><?php echo __('Photo'); ?></label>
                                    <input autofocus="true" class="textbox form-control" id="PlacePhoto" maxlength="255" 
                                        ng-model="place.photo" type="text">
        						</div>
    
								<!-- ACCESIBILIDAD-->
								<div class="row" ng-cloak>
									<div class="col-sm-12">
										<div class="row">
											<h4><?php echo __('Accessibility'); ?></h4>
										</div>
										<div class="row form-group">
											<p>¿El espacio donde se desarrolla la actividad está adaptado para personas con alguna discapacidad física o sensorial?</p>

											<!-- Accesibility Parking -->
											<p>
												<div class="accessibility-checkbox" ng-click="accessibilityParkingToogle()">
													<i class="icon-question" ng-show="place.accessibility_parking == 0"></i>
													<i class="icon-ok" ng-show="place.accessibility_parking == 1"></i>
													<i class="icon-remove" ng-show="place.accessibility_parking == 2"></i>
												</div>
												Plazas de aparcamiento reservadas para personas con discapacidad
											</p>

											<!-- Accesibility Ramp -->
											<p>
												<div class="accessibility-checkbox" ng-click="accessibilityRampToogle()">
													<i class="icon-question" ng-show="place.accessibility_ramp == 0"></i>
													<i class="icon-ok" ng-show="place.accessibility_ramp == 1"></i>
													<i class="icon-remove" ng-show="place.accessibility_ramp == 2"></i>
												</div>
												Escaleras, rampas o ascensores accesibles para vehículos de personas con movilidad reducida
											</p>

											<!-- Accesibility Equipment -->
											<p>
												<div class="accessibility-checkbox" ng-click="accessibilityEquipmentToogle()">
													<i class="icon-question" ng-show="place.accessibility_equipment == 0"></i>
													<i class="icon-ok" ng-show="place.accessibility_equipment == 1"></i>
													<i class="icon-remove" ng-show="place.accessibility_equipment == 2"></i>
												</div>
												Equipos electrónicos, informáticos y audiovisuales adaptados
											</p>

											<!-- Accesibility Signage -->
											<p>
												<div class="accessibility-checkbox" ng-click="accessibilitySignageToogle()">
													<i class="icon-question" ng-show="place.accessibility_signage == 0"></i>
													<i class="icon-ok" ng-show="place.accessibility_signage == 1"></i>
													<i class="icon-remove" ng-show="place.accessibility_signage == 2"></i>
												</div>
												Señales y paneles informativos claramente perceptibles y comprensibles
											</p>

											<!-- Accesibility Braille -->
											<p>
												<div class="accessibility-checkbox" ng-click="accessibilityBrailleToogle()">
													<i class="icon-question" ng-show="place.accessibility_braille == 0"></i>
													<i class="icon-ok" ng-show="place.accessibility_braille == 1"></i>
													<i class="icon-remove" ng-show="place.accessibility_braille == 2"></i>
												</div>
												Información táctil: Braille
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

        			<!-- Map -->
        			<div class="col-sm-4">
                        <div class="row">
        			    	<div class="col-sm-12">
                           		<div id="map"></div>
        			    	</div>
        			    </div>
        			</div>
    			
        			
        			<div class="col-sm-4">
        				<!-- Categorías -->
        						<div class="row">
        							<p>¿De qué se trata?</p>
                                    <div ng-controller="ClassificationsController">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div class="row categoriaLink"
                                                	ng-class="{highlight:classification.highlight}"
                                                	ng-model="classification"
                                                	ng-repeat="classification in classifications | orderBy:'Classification.name'"
                                                	ng-click="classificationToogle(classification)">
                                                        <div class="col-sm-1">
                                                        	<div class="classification" x-ng-style="{'background-color':classification.Classification.color}"></div>
                                                        </div>
                                                        <div class="col-sm-10" x-ng-bind="classification.Classification.name"></div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
        						</div>
                        
                        <div class="row">
							<input type="submit" value="Enviar" class="btn btn-verde pull-right">
						</div>
                        <div class="row" ng-show='cargando'>
                        	<div class="alert alert-info span12">
								<span ng-bind='cargando'></span>
                        	</div>
						</div>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
</div>
