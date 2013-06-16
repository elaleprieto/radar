<?php echo $this->Html->css(array('vendors/timePicker', 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css', 'events/add'), '', array('inline'=>false)) ?>
<?php echo $this->Html->script(array('vendors/jquery.timePicker', 'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'http://code.jquery.com/ui/1.10.2/jquery-ui.js', 'vendors/jquery.ui.datepicker-es', 'events/add'), array('inline'=>false)) ?>

<div class="alert alert-error" id="alertMessage">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>¡Cuidado!</strong><span id="alertMessageString"> Los eventos no pueden pertenecer a más de 3 (tres) categorías.</span>
</div>
<h1><?php echo __('Add Event'); ?></h1>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span6">
				<div class="row-fluid">
					<div class="span12">
						<?php echo $this->Form->create('Event'); ?>
							<?php echo $this->Form->hidden('lat', array('id'=>'EventLat', 'class'=>'textbox')) ?>
							<?php echo $this->Form->hidden('long', array('id'=>'EventLong', 'class'=>'textbox')) ?>
							<?php echo $this->Form->input('title', array('class'=>'textbox', 'label'=>__('Title'))) ?>
							<div class="row-fluid">
								<div class="span1">
									<p>De:</p>
								</div>
								<div class="span3">
									<?php //echo $this->Form->input('date_start', array('class'=>'dateField', 'dateFormat'=>'DMY', 'label'=>FALSE, 'selected'=>date("Y-m-d H:i:s"), 'type'=>'date')) ?>
									<?php echo $this->Form->input('date_from', array('class'=>'textbox', 'id'=>'from', 'label'=>FALSE, 'required'=>'required')) ?>
								</div>
								<div class="span2">
									<?php echo $this->Form->input('time3', array('class'=>'textbox', 'id'=>'time3', 'label'=>FALSE, 'required'=>'required', 'size'=>10, 'value'=>'08:00')) ?>
								</div>
								<div class="span1">
									<p>hasta</p>
								</div>
								<div class="span3">
									<?php //echo $this->Form->input('date_end', array('class'=>'dateField', 'dateFormat'=>'DMY', 'label'=>FALSE, 'selected'=>date("Y-m-d H:i:s"), 'type'=>'date')) ?>
									<?php echo $this->Form->input('date_to', array('class'=>'textbox', 'id'=>'to', 'label'=>FALSE, 'required'=>'required')) ?>
								</div>
								<div class="span2">
									<?php echo $this->Form->input('time4', array('class'=>'textbox', 'div'=>'control-group', 'id'=>'time4', 'label'=>FALSE, 'required'=>'required', 'size'=>10, 'value'=>'09:00')) ?>
								</div>
							</div>
							<!-- <div class="row-fluid">
								<div class="span6"><?php //echo $this->Form->input('category_id', array('class'=>'textbox')) ?></div>
								<div class="span6"><?php //echo $this->Form->input('place_id', array('class'=>'textbox')) ?></div>
							</div> -->
							<div id="categoriesSelect">
								 <fieldset>
							        <legend><?php __('Categories');?></legend>
							        <?php
							 
							        // output all the checkboxes at once
							        echo $this->Form->input('Category',array(
							        	// 'class' => 'categories',
							            'label' => __('Categories',true),
							            'multiple' => 'checkbox',
							            'options' => $categories,
							            'selected' => $this->Html->value('Category.Category'),
							            'type' => 'select',
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
							</div>
							<div>
								<!-- <input type="text" id="from" name="from" /> -->
								<!-- <input type="text" id="to" name="to" /> -->
							</div>
						<?php echo $this->Form->end(__('Submit')); ?>
					</div>
				</div>
			</div>
			
			
			<!-- Mapa -->
			<div class="span6">
				<div>Selecciona el lugar:</div>
				<div id="map"></div>
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