<?php
echo $this->Html->css(array(
	'vendors/bootstrap-datepicker',
	'vendors/bootstrap-timepicker',
	'inicio',
	'events/add'
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
	// $ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	// if ($ipData && $ipData->geoplugin_countryName != null) {
		// // $userLocation = $ipData->geoplugin_city . ', ' . $ipData->geoplugin_countryName;
		// $userLocation = $ipData->geoplugin_countryName;
		// $userLocationZoom = 4;
// 
		// # No se guardar el userLocation, a menos que se haga clic en el botón explícitamente
		// // # Se guarda el userLocation
		// // if ($userId = AuthComponent::user('id')) {
			// // $this->requestAction("/users/setLocation/$userId/$userLocation");
		// // }
	// } else {
		// $userLocation = null;
	// }
// }
?>

<div x-ng-controller="EventsController" x-ng-init="user.location='<?php echo $userLocation; ?>'">

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
    	       <form name="eventForm" x-ng-submit="submit()">
        			<div class="col-sm-4">
        				<div class="row">
        					<div class="col-sm-12">
        					    <div class="row">
                                    <h4>Información básica</h4>
                                </div>
        							
        						<!-- Title -->
        						<div class="row form-group">
                                	<label for="EventTitle"><?php echo __('Title');?></label>
                                    <input autofocus="true" class="textbox form-control" id="EventTitle" maxlength="255" 
                                        x-ng-model="evento.title" required="required" type="text">
        						</div>
        							
        						<!-- Address -->
        						<div class="row">
        							<div class="form-group">
										<!-- <input class="span2" id="appendedInputButton" type="text"> -->
	                                    <label for="EventAddress"><?php echo __('Address');?></label>
	                            		<div class="input-group input-group-sm">
	                            			<input class="textbox col-sm-11 form-control" id="EventAddress" maxlength="255" 
	                                            x-ng-model="evento.address" required="required" type="text">
											<span class="input-group-btn">
												<button class="btn btn-default" x-ng-click="setAddress()" type="button">
													 <span class="glyphicon glyphicon-map-marker"></span>
												</button>	
											</span>
	                            		</div>
									</div>
        						</div>
        							
        						<!-- Description -->
        						<div class="row form-group">
                                	<label for="EventDescription">
                                		<?php echo __('Description');?> 
                                		<span x-ng-cloak>
                                			({{descriptionSize - evento.description.length}})
                                		</span>
                                	</label>
                                    <textarea class="textarea col-sm-12 form-control" cols="30" id="EventDescription" 
                                        x-ng-model="evento.description" required="required" rows="4" 
                                        x-ng-change="checkDescriptionSize($event, evento)">
                                    </textarea>
        						</div>
    
    							<!-- Categorías -->
        						<div class="row">
        							<p>¿De qué se trata?</p>
                                    <div x-ng-controller="CategoriesController">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div 
                                                    	class="row categoriaLink"
                                                    	x-ng-class="{highlight:categoria.highlight}"
                                                    	x-ng-model="categoria"
                                                    	x-ng-repeat="categoria in categorias | orderBy:'Category.name'"
                                                    	x-ng-click="categoryToogle(categoria)">
                                                        <div class="col-sm-1">
                                                            <img class="icono-categoria" 
                                                            	x-ng-src="/img/categorias/{{categoria.Category.icon}}" />
                                                        </div>
                                                        <div class="col-sm-10" x-ng-bind="categoria.Category.name"></div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
        						</div>
        					</div>
        				</div>
        			</div>
    			
        			<!-- FECHAS Y MAPA -->
        			<div class="col-sm-4">
                        <div class="row">
                	       <div class="col-sm-12">
                	           <div class="row">
                                    <h4>Fecha</h4>
                                </div>
        		                <div class="row form-group">

                                	<!-- FECHA DE INICIO -->
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
                                                x-ng-model="evento.date_from" 
                                                required="required" 
                                              	today-btn="true" 
                                                type="text" 
                                            />
                                           <span class="input-group-btn" data-toggle="datepicker">
                                            	<button type="button" class="btn btn-default">
                                                	<span class="glyphicon glyphicon-calendar"></span>
                                            	</button>	
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- HORA DE INICIO -->
                                    <div class="col-sm-5">
                                        <div class="control-group input-group input-group-sm">
                                            <input 
                                               	bs-timepicker 
                                               	class="col-sm-10 form-control" 
                                               	data-show-meridian="false"
                                                id="time_from" 
                                              	x-ng-disabled="!evento.date_from" 
                                                x-ng-model="evento.time_from" 
                                                required="required" 
                                                type="text" 
                                            />
                                            <span class="input-group-btn" data-toggle="timepicker">
                                            	<button type="button" class="btn btn-default">
                                                	<span class="glyphicon glyphicon-time"></span> 
                                            	</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    
                                    <!-- FECHA DE FINALIZACIÓN -->
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
                                               	x-ng-disabled="!evento.date_from" 
                                               	x-ng-model="evento.date_to" 
                                               	required="required" 
                                               	today-btn="true" 
                                               	type="text" 
                                            />
                                            <span class="input-group-btn" data-toggle="datepicker">
                                            	<button type="button" class="btn btn-default">
                                                	<span class="glyphicon glyphicon-calendar"></span> 
                                            	</button>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- HORA DE FINALIZACIÓN -->
                                    <div class="col-sm-5">
                                        <div class="control-group input-group input-group-sm">
                                            <input 
                                              	bs-timepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-show-meridian="false"
                                               	x-ng-disabled="!evento.date_from && !evento.time_from" 
                                                x-ng-model="evento.time_to" 
                                                required="required" 
                                                type="text" 
                                            />
                                            <span class="input-group-btn" data-toggle="timepicker">
                                            	<button type="button" class="btn btn-default">
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
                                    <div class="col-sm-4" x-ng-init="hasCost=0">
                                        <label class="radio-inline">
                                            <input x-ng-checked="hasCost" x-ng-click="hasCost=1" x-ng-model="evento.hasCost" 
                                            	type="radio" />
                                            si
                                        </label>
                                        <label class="radio-inline">
                                            <input x-ng-checked="!hasCost" x-ng-click="hasCost=0; evento.cost=null" 
                                            	x-ng-model="evento.hasCost" type="radio" />
                                            no
                                        </label>
                                    </div>   
									<div class="input text form-control" x-ng-show="hasCost" x-ng-cloak>
										<input class="textbox col-sm-4 inline" name="cost" x-ng-disabled="!hasCost" x-ng-model="evento.cost" 
											placeholder="<?php __('Cost') ?>" type="number" />
										<span class="alert-danger" x-ng-show="!eventForm.cost.$valid">
        									<?php echo __('invalid') ?>
        								</span>
									</div>
                                </div>
                                <div class="row form-group">
                                    <?php //echo $this->Form->input('website', array('class'=>'textbox', 'label'=>__('web'))) ?>
                                    <div class="input text">
                                    	<label for="web">web</label>
                                    	<input class="textbox form-control" x-ng-model="evento.website" type="text" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('video', array('class'=>'textbox form-control', 'label'=>__('Video'))) ?>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('noticia'
                                    	, array('class'=>'textbox form-control'
                                    		, 'label'=>__('News source')
											)
										)
									?>
                                </div>
                                <div class="row form-group">
                                    <?php echo $this->Form->input('foto', array('class'=>'textbox form-control', 'label'=>__('Photo'))) ?>
                                </div>
                           </div>
                        </div>
                        <div class="row">
							<input type="submit" value="Enviar" class="btn btn-verde pull-right">
						</div>
                        <div class="row" x-ng-show='cargando'>
                        	<div class="alert alert-info span12">
								<span x-ng-bind='cargando'></span>
                        	</div>
						</div>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
</div>
