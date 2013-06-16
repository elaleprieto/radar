<?php echo $this->Html->css(array('vendors/timePicker', 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css', 'inicio','events/add'), '', array('inline'=>false)) ?>
<?php echo $this->Html->script(array('vendors/jquery.timePicker', 'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'http://code.jquery.com/ui/1.10.2/jquery-ui.js', 'vendors/jquery.ui.datepicker-es', 'events/add'), array('inline'=>false)) ?>
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
        <strong>¡Cuidado!</strong><span id="alertMessageString"> Los eventos no pueden pertenecer a más de 3 (tres) categorías.</span>
    </div>    
</div>
<div class="row">
    <h2><?php echo __('Add Event'); ?></h2>
</div>
<div class="row">
	<div class="span12">
		<div class="row">
		    <!-- FORMULARIO BÁSICO -->
			<div class="span4">
				<div class="row-fluid">
					<div class="span12">
					    <div class="row-fluid">
                            <h4>Información básica</h4>
                        </div>
					    <?php echo $this->Form->create('Event'); ?>
							<?php echo $this->Form->hidden('lat', array('id'=>'EventLat', 'class'=>'textbox')) ?>
							<?php echo $this->Form->hidden('long', array('id'=>'EventLong', 'class'=>'textbox')) ?>
							<div class="row-fluid">
                                <?php echo $this->Form->input('title', array('class'=>'textbox', 'label'=>__('Title'))) ?>
							</div>
							<div class="row-fluid">
                                <?php echo $this->Form->input('descripción', array('class'=>'textarea span12','rows' =>'4','label'=>__('Description'))) ?>
							</div>
							<div class="row-fluid">
							    <p>¿De qué se trata?</p>
                                <?php foreach ($categories as $categoria): ?>
                                    <div class="categoria active span5">
                                        <?php
                                            $cat=str_replace("á","a",$categoria);
                                            $cat=str_replace("é","e",$cat);
                                            $cat=str_replace("í","i",$cat);
                                            $cat=str_replace("ó","o",$cat);
                                            $cat=str_replace("ú","u",$cat);
                                            $cat=str_replace("ñ","ni",$cat);
                                            echo $this->Html->image('categorias/'.strtolower(preg_replace("/[^A-z]/","",$cat)).'.png', array('class'=>'icono-categoria'));
                                            echo $categoria;
                                        ?>
                                    </div>
                                <?php endforeach ?>
							</div>
							<!--
							<div id="categoriesSelect">
								 <fieldset>
							        <legend><?php __('Categories');?></legend>
							        <?php
							        $i = 0;
							        // output all the checkboxes at once
							        echo $this->Form->input('Category',array(
							        	// 'class' => 'categories',
							            'label' => __('Categories',true),
							            'multiple' => 'checkbox',
							            'options' => $categories,
							            'selected' => $this->Html->value('Category.Category'),
							            'type' => 'select',
							            'submit' => 'Category.logo',
							            'class' => 'checkbox',
							            //'class' => 'checkboxFour',
							        ));
							        /*
							        // output all the checkboxes individually
							        $checked = $form->value('Category.Category');
							        echo $form->label(__('Categories',true));
							        foreach ($categories as $id=>$label) {
							            echo $form->input("Category.checkbox.$id", array(
							                'label'=>$label,
							                'type'=>'checkbox',
							                'checked'=>(isset($checked[$id])?'checked':false),
							            ));
							        }
							        */
							        ?>
							    </fieldset>
							</div>-->
						<!--<?php echo $this->Form->end(__('Submit')); ?>-->
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
                                    <label>Fecha y hora de inicio:</label>
                                <div class="span8">
                                    <?php echo $this->Form->input('date_from', array('class'=>'textbox', 'id'=>'from', 'label'=>FALSE, 'required'=>'required')) ?>
                                </div>
                                <div class="span3">
                                     <?php echo $this->Form->input('time3', array('class'=>'textbox', 'id'=>'time3', 'label'=>FALSE, 'required'=>'required', 'size'=>10, 'value'=>'08:00')) ?>
                                </div>
                            </div>
                            <div class="row-fluid">
                                    <label>Fecha y hora de fin:</label>
                                <div class="span8">
                                    <?php echo $this->Form->input('date_to', array('class'=>'textbox', 'id'=>'to', 'label'=>FALSE, 'required'=>'required')) ?>
                                </div>
                                <div class="span3">
                                    <?php echo $this->Form->input('time4', array('class'=>'textbox', 'div'=>'control-group', 'id'=>'time4', 'label'=>FALSE, 'required'=>'required', 'size'=>10, 'value'=>'09:00')) ?>
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
                            <?php echo $this->Form->input('precio', array('class'=>'textbox span4 inline', 'label'=>FALSE, 'placeholder'=>'precio')) ?>
                        </div>
                        <div class="row-fluid">
                            <?php echo $this->Form->input('web', array('class'=>'textbox', 'label'=>__('web'))) ?>
                        </div>
                        <div class="row-fluid">
                            <?php echo $this->Form->input('video', array('class'=>'textbox', 'label'=>__('video'))) ?>
                        </div>
                        <div class="row-fluid">
                            <?php echo $this->Form->input('noticia', array('class'=>'textbox', 'label'=>__('fuente de noticias'))) ?>
                        </div>
                        <div class="row-fluid">
                            <?php echo $this->Form->input('foto', array('class'=>'textbox', 'label'=>__('foto'))) ?>
                        </div>
                   </div>
                </div>
                
                 <?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>

	</div>
</div>

<!-- Acciones -->
<!-- <div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div> -->
