<?php //debug($event, $showHtml = null, $showFrom = true) ?>
<?php
	echo $this->Html->css(array(
		'vendors/bootstrap-datepicker',
		'vendors/bootstrap-timepicker',
		'vendors/typeahead.js-bootstrap',
		'inicio',
		'events/add'
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

<div data-ng-controller="EventsController" 
	data-ng-init="user.id='<?php echo AuthComponent::user('id'); ?>'
		; evento.id='<?php echo $event['Event']['id'] ?>'">

    <!-- BARRA PROGRESO -->
    <div class="row">
        <div class="progress">
            <div class="progress-bar progress-bar-success" style="width: 33%;"><?php echo __('Basic information')?></div>
            <div class="progress-bar progress-bar-warning" style="width: 34%;"><?php echo __('Location')?></div>
            <div class="progress-bar progress-bar-danger" style="width: 33%;"><?php echo __('Accessibility')?></div>     
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
        <h2><?php echo __('Edit Event'); ?></h2>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<div class="row">
    		   
                <!-- FORMULARIO BÁSICO -->
                <!-- <form name="eventForm" data-ng-submit="submit()"> -->
                <?php echo $this->Form->create('Event', array('type' => 'file')); ?>
                    <?php echo $this->Form->input('id') ?>
                    <?php echo $this->Form->hidden('lat', array('value' => '{{evento.lat}}')) ?>
                    <?php echo $this->Form->hidden('long', array('value' => '{{evento.long}}')) ?>
        			<div class="col-sm-4">
        				<div class="row">
        					<div class="col-sm-12">
        					    <div class="row">
                                    <h4><?php echo __('Basic information')?></h4>
                                </div>
        							
        						<!-- Title -->
        						<div class="row form-group">
                                	<!-- <label for="EventTitle"><?php echo __('Title'); ?></label>
                                    <input autofocus="true" class="capitalize form-control textbox" id="EventTitle" 
                                    	maxlength="255" required="required" type="text"
                                    	data-ng-model="evento.title" /> -->
                                    <?php echo $this->Form->input('title', array('autofocus' => true
                                        , 'class' => 'capitalize form-control textbox'
                                        , 'maxlength' => 255
                                        , 'required' => 'required'
                                        , 'data-ng-model' => 'evento.title'
                                        )
                                    )
                                    ?>
        						</div>
        							
        						<!-- Address -->
        						<div class="row form-group">
                                    <!-- <label for="EventAddress"><?php echo __('Address'); ?></label>
                                    <div>
	                        			<input class="capitalize col-sm-11 form-control textbox typeahead" 
	                        				id="EventAddress" 
	                        				maxlength="255" required="required" type="text" 
	                        				ui-keypress="{13:'$event.preventDefault()'}"
	                        				value="<?php echo $event['Event']['address'] ?>" />
                                    </div> -->
                                    <?php echo $this->Form->input('address', array(
                                        'class' => 'capitalize col-sm-11 form-control textbox typeahead'
                                        , 'maxlength' => 255
                                        , 'required' => 'required'
                                        , 'ui-keypress' => '{13:\'$event.preventDefault()\'}'
                                        )
                                    )
                                    ?>
        						</div>
        							
        						<!-- Description -->
        						<div class="row form-group">
                                	<label for="EventDescription">
                                		<?php echo __('Description'); ?> 
                                		<span data-ng-cloak>
                                			<small>({{descriptionSize - evento.description.length}} <?php echo __('characters')?>)</small>
                                		</span>
                                	</label>
                                    <!-- <textarea class="textarea col-sm-12 form-control" cols="30" id="EventDescription" 
                                        data-ng-model="evento.description" required="required" rows="4" 
                                        data-ng-change="checkDescriptionSize($event, evento)">
                                    </textarea> -->
                                    <?php echo $this->Form->input('description', array(
                                        'class' => 'textarea col-sm-12 form-control'
                                        , 'cols' => 30
                                        , 'label' => false
                                        , 'required' => 'required'
                                        , 'rows' => 4
                                        , 'type' => 'textarea'
                                        , 'data-ng-model' => 'evento.description'
                                        , 'data-ng-change' => 'checkDescriptionSize($event, evento)'
                                        )
                                    )
                                    ?>
        						</div>
    
    							<!-- Categorías -->
        						<div class="row">
        							<p><?php echo __('What is it?') ?></p>
                                    <div data-ng-controller="CategoriesController">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div 
                                                	class="row categoriaLink"
                                                	data-ng-class="{highlight:categoria.highlight}"
                                                	data-ng-model="categoria"
                                                	data-ng-repeat="categoria in categorias | orderBy:'Category.name'"
                                                	data-ng-click="categoryToogle(categoria)">
                                                        <div class="col-sm-1">
                                                            <img class="icono-categoria" 
                                                            	data-ng-src="/img/categorias/{{categoria.Category.icon}}" />
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <label class="category" data-ng-bind="categoria.Category.name"></label>
                                                            <input class="checkbox" type="checkbox" 
                                                                data-ng-model="categoria.checkbox" 
                                                                name="data[Event][Category][]"
                                                                value="{{categoria.Category.id}}">
                                                        </div>
                                                        <!-- <div class="col-sm-10" data-ng-bind="categoria.Category.name"></div> -->
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
                        <div class="row-fluid">
                	       <div class="col-sm-12">
                	           <div class="row">
                                    <h4><?php echo __('Date')?></h4>
                                </div>
        		                <div class="row form-group">

                                	<!-- FECHA DE INICIO -->
                                    <div class="col-sm-12">
                                    	<label><?php echo __('Start Date and Time')?>:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="control-group input-group input-group-sm">
                                            <?php echo $this->Form->input('date_from', array('autoclose' => true
                                                , 'bs-datepicker' 
                                                , 'class' => 'col-sm-9 form-control'
                                                , 'data-date-format' => 'dd/mm/yyyy'
                                                , 'data-start-date' => '-0d'
                                                , 'id' => 'date_from'
                                                , 'data-ng-model' => 'evento.date_from'
                                                , 'div' => false
                                                , 'label' => false
                                                , 'required' => 'required'
                                                , 'today-btn' => true
                                                )
                                            )
                                            ?>
                                            <!-- <input 
                                              	autoclose = "true"
                                               	bs-datepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-date-format="dd/mm/yyyy"
                                               	data-start-date="-0d"
                                                id="date_from" 
                                                data-ng-model="evento.date_from"
                                                required="required" 
                                              	today-btn="true" 
                                                type="text" 
                                            /> -->
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
                                            <!-- <input 
                                               	bs-timepicker 
                                               	class="col-sm-10 form-control" 
                                               	data-show-meridian="false"
                                               	data-time-format="H:m"
                                                id="time_from" 
                                              	data-ng-disabled="!evento.date_from" 
                                                data-ng-model="evento.time_from"
                                                required="required" 
                                                type="text" 
                                            /> -->
                                            <?php echo $this->Form->input('time_from', array('autoclose' => true
                                                , 'bs-timepicker' 
                                                , 'class' => 'col-sm-10 form-control'
                                                , 'data-show-meridian' => 'false'
                                                , 'id' => 'time_from'
                                                , 'data-ng-model' => 'evento.time_from'
                                                , 'data-ng-disabled' => '!evento.date_from' 
                                                , 'div' => false
                                                , 'label' => false
                                                , 'required' => 'required'
                                                )
                                            )
                                            ?>
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
                                    	<label><?php echo __('End Date and Time')?>:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="control-group input-group input-group-sm">
                                            <!-- <input
                                              	autoclose = "true" 
                                               	bs-datepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-end-date="12/07/2013" 
                                               	id="date_to" 
                                               	data-date-format="dd/mm/yyyy" 
                                               	data-ng-disabled="!evento.date_from" 
                                               	data-ng-model="evento.date_to" 
                                               	required="required" 
                                               	today-btn="true" 
                                               	type="text" 
                                            /> -->
                                            <?php echo $this->Form->input('date_to', array('autoclose' => true
                                                , 'bs-datepicker' 
                                                , 'class' => 'col-sm-9 form-control'
                                                , 'data-date-format' => 'dd/mm/yyyy'
                                                , 'data-end-date' => '01/01/2014'
                                                , 'id' => 'date_to'
                                                , 'data-ng-disabled' => '!evento.date_from'
                                                , 'data-ng-model' => 'evento.date_to'
                                                , 'div' => false
                                                , 'label' => false
                                                , 'required' => 'required'
                                                , 'today-btn' => true
                                                )
                                            )
                                            ?>
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
                                           <!--  <input 
                                              	bs-timepicker 
                                               	class="col-sm-9 form-control" 
                                               	data-show-meridian="false"
                                               	data-ng-disabled="!evento.date_from && !evento.time_from" 
                                                data-ng-model="evento.time_to" 
                                                required="required" 
                                                type="text" 
                                            /> -->
                                            <?php echo $this->Form->input('time_to', array('autoclose' => true
                                                , 'bs-timepicker' 
                                                , 'class' => 'col-sm-10 form-control'
                                                , 'data-show-meridian' => 'false'
                                                , 'data-ng-model' => 'evento.time_to'
                                                , 'data-ng-disabled' => '!evento.date_from && !evento.time_from' 
                                                , 'div' => false
                                                , 'label' => false
                                                , 'required' => 'required'
                                                )
                                            )
                                            ?>
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
                                    <h4><?php echo __('Accessibility'); ?></h4>
                                </div>
                                <div class="row form-group">
                                   <p><?php echo __('Is space adapted for people with physical or sensory disabilities?')?></p>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        <?php echo __('Parking spaces reserved for people with disabilities')?>
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        <?php echo __('Stairs, ramps or elevators accessible wheelchair')?>                            
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        <?php echo __('Electronic equipment and audiovisual adapted')?>                            
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                       	<?php echo __('Signs and information boards clearly perceived and understood')?>                         
                                    </label>
                                    <label class="checkbox" id="label_simple">
                                        <input type="checkbox" value="">
                                        <?php echo __('Tactile information: Braille')?>                            
                                    </label>   
                                </div>
                           </div>

                           <!-- Información Adicional -->
                           <div class="col-sm-12">
                                <div class="row">
                                    <h4><?php echo __('Additional information')?></h4>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <p><?php echo __('Ticket sales')?></p>
                                    </div>
                                    <div class="col-sm-4" data-ng-init="hasCost=0">
                                        <label class="radio-inline">
                                            <input data-ng-checked="hasCost" data-ng-click="hasCost=1" data-ng-model="evento.hasCost" 
                                            	type="radio" />
                                            <?php echo __('yes')?>
                                        </label>
                                        <label class="radio-inline">
                                            <input data-ng-checked="!hasCost" data-ng-click="hasCost=0; evento.cost=null" 
                                            	data-ng-model="evento.hasCost" type="radio" />
                                            <?php echo __('no')?>
                                        </label>
                                    </div>   
									<div class="input text form-control" data-ng-show="hasCost" data-ng-cloak>
										<input class="textbox col-sm-4 inline" name="cost" data-ng-disabled="!hasCost" data-ng-model="evento.cost" 
											placeholder="<?php __('Cost') ?>" type="number" />
										<span class="alert-danger" data-ng-show="!eventForm.cost.$valid">
        									<?php echo __('invalid') ?>
        								</span>
									</div>
                                </div>

                                <!-- Website -->
                                <div class="row form-group">
                                    <div class="input text">
                                        <?php echo $this->Form->input('website'
                                            , array('class'=>'textbox form-control'
                                                , 'placeholder' => 'www.radarcultural.org'
                                                , 'data-ng-model' => 'evento.website'
                                            )
                                        )
                                        ?>
                                    	<!-- <label for="web"><?php echo __('Website') ?></label>
                                    	<input class="textbox form-control" data-ng-model="evento.website" type="text" placeholder="www.radarcultural.org"/> -->
                                    </div>
                                </div>

                                <!-- Video -->
                                <!-- <div class="row form-group">
                                    <?php //echo $this->Form->input('video', array('class'=>'textbox form-control', 'label'=>__('Video'))) ?>
                                </div> -->

                                <!-- Noticia -->
                                <!-- <div class="row form-group">
                                    <?php //echo $this->Form->input('noticia', array('class'=>'textbox form-control', 'label'=>__('News source')))?>
                                </div> -->
                               
                                <!-- Foto -->
                                <div class="row form-group">
                                    <?php if($event['Event']['foto']) echo $this->Html->image('fotos/'.$event['Event']['foto'], array('class'=>'img-responsive')); ?>
                                    <?php echo $this->Form->input('archivo', array('class'=>'', 'label'=>__('Change photo'), 'type'=>'file')) ?>
                                </div>
                           </div>
                        </div>
                        <div class="row">
							<input type="submit" value="Enviar" class="btn btn-verde pull-right">
						</div>
                        <div class="row" data-ng-show='cargando'>
                        	<div class="alert alert-info span12">
								<span data-ng-bind='cargando'></span>
                        	</div>
						</div>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
</div>
