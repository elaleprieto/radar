<?php
echo $this->Html->css(array('vendors/bootstrap-datepicker'
		, 'vendors/bootstrap-timepicker'
		, 'inicio'
		,'events/add'
	)
	, ''
	, array('inline'=>false)
);

echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true'
	    , 'vendors/angular-strap.min'
	    , 'vendors/bootstrap-datepicker'
	    , 'vendors/bootstrap-timepicker'
	    , 'events/add_an'
	)
	, array('inline'=>false)
);
?>

<div ng-controller="EventController">

    <!-- BARRA PROGRESO -->
    <div class="row">
        <div class="progress">
            <div class="bar bar-success" style="width: 33%;">Info básica</div>
            <div class="bar bar-warning" style="width: 34%;">ubicación</div>
            <div class="bar bar-danger" style="width: 33%;">accesibilidad</div>     
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
    	<div class="span12">
    		<div class="row">
    		    <!-- FORMULARIO BÁSICO -->
    	       <form name="eventForm" ng-submit="submit()">
        			<div class="span4">
        				<div class="row-fluid">
        					<div class="span12">
        					    <div class="row-fluid">
                                    <h4>Información básica</h4>
                                </div>
        							
        							<!-- Título -->
        							<div class="row-fluid">
                                        <label for="EventTitle">Título</label>
                                        <input autofocus="true" class="textbox" id="EventTitle" maxlength="255" 
                                            ng-model="event.title" required="required" type="text">
        							</div>
        							
        							<!-- Dirección -->
        							<div class="row-fluid">
                                        <label for="EventAddress">Dirección</label>
                                        <input class="textbox" id="EventAddress" maxlength="255" 
                                            ng-model="event.address" required="required" type="text">
        							</div>
        							
        							<!-- Descripción -->
        							<div class="row-fluid">
                                        <label for="EventDescripción">Descripción</label>
                                        <textarea class="textarea span12" cols="30" id="EventDescripción" 
                                            ng-model="event.description" required="required" rows="4">
                                        </textarea>
        							</div>
    
    							    <!-- Categorías -->
        							<div class="row-fluid">
        							    <p>¿De qué se trata?</p>
                                        <div ng-controller="CategoriaController">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div 
                                                    	class="row-fluid categoriaLink"
                                                    	ng-class="{highlight:categoria.highlight}"
                                                    	ng-model="categoria"
                                                    	ng-repeat="categoria in categorias"
                                                    	ng-click="show(categoria)">
                                                        <div class="span1">
                                                            <img class="icono-categoria" 
                                                            	ng-src="/img/categorias/{{categoria.Category.icon}}" />
                                                        </div>
                                                        <div class="span10" ng-bind="categoria.Category.name"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        							</div>
        					</div>
        				</div>
        			</div>
    			
        			<!-- MAPA -->
        			<div class="span4">
                        <div class="row-fluid">
                	       <div class="span12">
                	           <div class="row-fluid">
                                    <h4>Ubicación</h4>
                                </div>
        		                    <div class="row-fluid">

                                        <!-- Fecha inicio -->
                                        <label>Fecha y hora de inicio:</label>
                                        <div class="span6">
                                            <div class="control-group input-append">
                                                <input 
                                                	autoclose = "true"
                                                	bs-datepicker 
                                                	class="span9" 
                                                	data-date-format="dd/mm/yyyy"
                                                	data-start-date="-1d" 
                                                    id="date_from" 
                                                    ng-model="event.date_from" 
                                                    required="required" 
                                                	today-btn="true" 
                                                    type="text" 
                                                />
                                                <button type="button" class="btn" data-toggle="datepicker">
                                                    <i class="icon-calendar"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hora inicio -->
                                        <div class="span4">
                                            <div class="control-group input-append">
                                                <input 
                                                	bs-timepicker 
                                                	class="span9" 
                                                	data-show-meridian="false"
                                                    id="time_from" 
                                                	ng-disabled="!event.date_from" 
                                                    ng-model="event.time_from" 
                                                    required="required" 
                                                    type="text" 
                                                />
                                                <button type="button" class="btn" data-toggle="timepicker">
                                                    <i class="icon-time"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">

                                        <!-- Fecha fin -->
                                        <label>Fecha y hora de fin:</label>
                                        <div class="span6">
                                            <div class="control-group input-append">
                                                <input
                                                	autoclose = "true" 
                                                	bs-datepicker 
                                                	class="span9" 
                                                	data-end-date="12/07/2013" 
                                                	id="date_to" 
                                                	data-date-format="dd/mm/yyyy" 
                                                	ng-disabled="!event.date_from" 
                                                	ng-model="event.date_to" 
                                                	required="required" 
                                                	today-btn="true" 
                                                	type="text" 
                                                />
                                                <button type="button" class="btn" data-toggle="datepicker">
                                                    <i class="icon-calendar"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hora fin -->
                                        <div class="span4">
                                            <div class="control-group input-append">
                                                <input 
                                                	bs-timepicker 
                                                	class="span9" 
                                                	data-show-meridian="false"
                                                	ng-disabled="!event.date_from && !event.time_from" 
                                                    ng-model="event.time_to" 
                                                    required="required" 
                                                    type="text" 
                                                />
                                                <button type="button" class="btn" data-toggle="timepicker">
                                                    <i class="icon-time"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
        			             </div>
        			    <div class="row-fluid">
        			        <div>Selecciona el lugar:</div>
                            <div id="map"></div>
        			    </div>
        			    </div>
        			</div>
    			
        			<!-- ACCESIBILIDAD-->
        			<div class="span4">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="row-fluid">
                                    <h4>Accesibilidad</h4>
                                </div>
                                <div class="row-fluid">
                                    <label>
                                        ¿El espacio donde se desarrolla la actividad está adaptado para personas 
                                        con alguna discapacidad física o sensorial?
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="">
                                        Plazas de aparcamiento reservadas para personas con discapacidad
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="">
                                        Escaleras, rampas o ascensores accesibles para vehículos de personas con movilidad reducida                            
                                    </label>
                                    <label cclass="checkbox">
                                        <input type="checkbox" value="">
                                        Equipos electrónicos, informáticos y audiovisuales adaptados                            
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="">
                                        Señales y paneles informativos claramente perceptibles y comprensibles                            
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="">
                                        Información táctil: Braille                            
                                    </label>   
                                </div>
                           </div>
                           <div class="span12">
                                <div class="row-fluid">
                                    <h4>Información adicional</h4>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <p>venta de entradas</p>
                                    </div>
                                    <div class="span4">
                                        <label class="radio inline">
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                            si
                                        </label>
                                        <label class="radio inline">
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                            no
                                        </label>
                                    </div>   
                                    <?php echo $this->Form->input('precio'
                                    	, array('class'=>'textbox span4 inline'
                                    		, 'label'=>FALSE, 'placeholder'=>'precio'
											)
										) 
									?>
                                </div>
                                <div class="row-fluid">
                                    <?php echo $this->Form->input('web', array('class'=>'textbox', 'label'=>__('web'))) ?>
                                </div>
                                <div class="row-fluid">
                                    <?php echo $this->Form->input('video', array('class'=>'textbox', 'label'=>__('video'))) ?>
                                </div>
                                <div class="row-fluid">
                                    <?php echo $this->Form->input('noticia'
                                    	, array('class'=>'textbox'
                                    		, 'label'=>__('fuente de noticias')
											)
										)
									?>
                                </div>
                                <div class="row-fluid">
                                    <?php echo $this->Form->input('foto', array('class'=>'textbox', 'label'=>__('foto'))) ?>
                                </div>
                           </div>
                        </div>
                        <div class="row-fluid">
							<input type="submit" value="Enviar">
						</div>
                        <div class="row-fluid" ng-show='cargando'>
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
