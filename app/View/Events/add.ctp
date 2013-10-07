<?php
echo $this->Html->css(array(
	'vendors/bootstrap-datepicker',
	'vendors/bootstrap-timepicker',
	'inicio',
	'events/add'
), '', array('inline' => false));

// echo $this->Html->script(array(
	// 'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true',
	// 'vendors/angular-strap.min',
	// 'app',
	// 'controllers/categories_controller',
	// 'controllers/events_controller',
	// 'vendors/bootstrap-datepicker',
	// 'vendors/bootstrap-timepicker',
	// 'filters',
	// 'vendors/jquery.cookie',
// ), array('inline' => false));

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

<div ng-controller="EventsController" ng-init="user.location='<?php echo $userLocation; ?>'">

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
        <h2><?php echo __('Add Event'); ?></h2>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<div class="row">
    		    <!-- FORMULARIO BÁSICO -->
    	       <form name="eventForm" ng-submit="submit()">
        			<div class="col-sm-4">
        				<div class="row">
        					<div class="col-sm-12">
        					    <div class="row">
                                    <h4>Información básica</h4>
                                </div>
        							
        						<!-- Título -->
        						<div class="row form-group">
                                	<label for="EventTitle">Título</label>
                                    <input autofocus="true" class="textbox form-control" id="EventTitle" maxlength="255" 
                                        ng-model="event.title" required="required" type="text">
        						</div>
        							
        						<!-- Dirección -->
        						<div class="row">
        							<div class="form-group">
										<!-- <input class="span2" id="appendedInputButton" type="text"> -->
	                                    <label for="EventAddress">Dirección</label>
	                            		<div class="input-group input-group-sm">
	                            			<input class="textbox col-sm-11 form-control" id="EventAddress" maxlength="255" 
	                                            ng-model="event.address" required="required" type="text">
											<span class="input-group-btn">
												<button class="btn btn-default" ng-click="setAddress()" type="button">
													 <span class="glyphicon glyphicon-map-marker"></span>
												</button>	
											</span>
	                            		</div>
									</div>
        						</div>
        							
        						<!-- Descripción -->
        						<div class="row form-group">
                                	<label for="EventDescripción">Descripción</label>
                                    <textarea class="textarea col-sm-12 form-control" cols="30" id="EventDescripción" 
                                        ng-model="event.description" required="required" rows="4">
                                    </textarea>
        						</div>
    
    							<!-- Categorías -->
        						<div class="row">
        							<p>¿De qué se trata?</p>
                                    <div ng-controller="CategoriesController">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div 
                                                    	class="row categoriaLink"
                                                    	ng-class="{highlight:categoria.highlight}"
                                                    	ng-model="categoria"
                                                    	ng-repeat="categoria in categorias"
                                                    	ng-click="addCategoryToEvent(categoria)">
                                                        <div class="col-sm-1">
                                                            <img class="icono-categoria" 
                                                            	ng-src="/img/categorias/{{categoria.Category.icon}}" />
                                                        </div>
                                                        <div class="col-sm-10" ng-bind="categoria.Category.name"></div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
        						</div>
        					</div>
        				</div>
        			</div>
    			
        			<!-- MAPA -->
        			<div class="col-sm-4">
                        <div class="row">
                	       <div class="col-sm-12">
                	           <div class="row">
                                    <h4>Fecha</h4>
                                </div>
        		                <div class="row form-group">

                                	<!-- Fecha inicio -->
                                    <div class="col-sm-12">
                                    	<label>Fecha y hora de inicio:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="control-group input-group input-group-sm">
                                            <input 
                                              	autoclose = "true"
                                               	bs-datepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-date-format="dd/mm/yyyy"
                                               	data-start-date="-1d" 
                                                id="date_from" 
                                                ng-model="event.date_from" 
                                                required="required" 
                                              	today-btn="true" 
                                                type="text" 
                                            />
                                           <span class="input-group-btn ">
                                            	<button type="button" class="btn btn-default" data-toggle="datepicker">
                                                	<span class="glyphicon glyphicon-calendar"></span>
                                            	</button>	
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Hora inicio -->
                                    <div class="col-sm-5">
                                        <div class="control-group input-group input-group-sm">
                                            <input 
                                               	bs-timepicker 
                                               	class="col-sm-10 form-control" 
                                               	data-show-meridian="false"
                                                id="time_from" 
                                              	ng-disabled="!event.date_from" 
                                                ng-model="event.time_from" 
                                                required="required" 
                                                type="text" 
                                            />
                                            <span class="input-group-btn">
                                            	<button type="button" class="btn btn-default" data-toggle="timepicker">
                                                	<span class="glyphicon glyphicon-time"></span> 
                                            	</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <!-- Fecha fin -->
                                    <div class="col-sm-12">
                                    	<label>Fecha y hora de fin:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="control-group input-group input-group-sm">
                                            <input
                                              	autoclose = "true" 
                                               	bs-datepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-end-date="12/07/2013" 
                                               	id="date_to" 
                                               	data-date-format="dd/mm/yyyy" 
                                               	ng-disabled="!event.date_from" 
                                               	ng-model="event.date_to" 
                                               	required="required" 
                                               	today-btn="true" 
                                               	type="text" 
                                            />
                                            <span class="input-group-btn">
                                            	<button type="button" class="btn btn-default" data-toggle="datepicker">
                                                	<span class="glyphicon glyphicon-calendar"></span> 
                                            	</button>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Hora fin -->
                                    <div class="col-sm-5">
                                        <div class="control-group input-group input-group-sm">
                                            <input 
                                              	bs-timepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-show-meridian="false"
                                               	ng-disabled="!event.date_from && !event.time_from" 
                                                ng-model="event.time_to" 
                                                required="required" 
                                                type="text" 
                                            />
                                            <span class="input-group-btn ">
                                            	<button type="button" class="btn btn-default" data-toggle="timepicker">
                                                	<span class="glyphicon glyphicon-time"></span> 
                                            	</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
        			        </div>
        			    	<div class="col-sm-12">
                           		<div id="map"></div>
        			    	</div>
        			    </div>
        			</div>
    			
        			<!-- ACCESIBILIDAD-->
        			<div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <h4>Accesibilidad</h4>
                                </div>
                                <div class="row form-group">
                                   <p>¿El espacio donde se desarrolla la actividad está adaptado para personas 
                                        con alguna discapacidad física o sensorial?</p>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        Plazas de aparcamiento reservadas para personas con discapacidad
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        Escaleras, rampas o ascensores accesibles para vehículos de personas con movilidad reducida                            
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        Equipos electrónicos, informáticos y audiovisuales adaptados                            
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        Señales y paneles informativos claramente perceptibles y comprensibles                            
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        Información táctil: Braille                            
                                    </label>   
                                </div>
                           </div>
                           <div class="col-sm-12">
                                <div class="row">
                                    <h4>Información adicional</h4>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <p>venta de entradas</p>
                                    </div>
                                    <div class="col-sm-4" ng-init="hasCost=0">
                                        <label class="radio-inline">
                                            <input ng-checked="hasCost" ng-click="hasCost=1" ng-model="event.hasCost" 
                                            	type="radio" />
                                            si
                                        </label>
                                        <label class="radio-inline">
                                            <input ng-checked="!hasCost" ng-click="hasCost=0; event.cost=null" 
                                            	ng-model="event.hasCost" type="radio" />
                                            no
                                        </label>
                                    </div>   
									<div class="input text form-control" ng-show="hasCost" ng-cloak>
										<input class="textbox col-sm-4 inline" name="cost" ng-disabled="!hasCost" ng-model="event.cost" 
											placeholder="<?php __('Cost') ?>" type="number" />
										<span class="alert-danger" ng-show="!eventForm.cost.$valid">
        									<?php echo __('invalid') ?>
        								</span>
									</div>
                                </div>
                                <div class="row form-group">
                                    <?php //echo $this->Form->input('website', array('class'=>'textbox', 'label'=>__('web'))) ?>
                                    <div class="input text">
                                    	<label for="web">web</label>
                                    	<input class="textbox form-control" ng-model="event.website" type="text" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('video', array('class'=>'textbox form-control', 'label'=>__('video'))) ?>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('noticia'
                                    	, array('class'=>'textbox form-control'
                                    		, 'label'=>__('fuente de noticias')
											)
										)
									?>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('foto', array('class'=>'textbox form-control', 'label'=>__('foto'))) ?>
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
