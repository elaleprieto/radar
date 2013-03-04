<?php echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'events/add'), array('inline'=>false)) ?>
<?php echo $this->Html->css(array('events/add'), '', array('inline'=>false)) ?>

<h1><?php echo __('Add Event'); ?></h1>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span6">
				<div class="row-fluid">
					<div class="span12">
						<?php echo $this->Form->create('Event'); ?>
							<?php echo $this->Form->input('title', array('class'=>'textbox')) ?>
							<div class="row-fluid">
								<div class="span6"><?php echo $this->Form->input('lat', array('id'=>'EventLat', 'class'=>'textbox')) ?></div>
								<div class="span6"><?php echo $this->Form->input('long', array('id'=>'EventLong', 'class'=>'textbox')) ?></div>
							</div>
							<?php echo $this->Form->input('date_start', array('class'=>'date', 'dateFormat' => 'DMY', 'timeFormat' => '24', 'selected' => date("Y-m-d H:i:s"))) ?>
							<?php echo $this->Form->input('date_end', array('class'=>'date', 'dateFormat' => 'DMY', 'timeFormat' => '24', 'selected' => date("Y-m-d H:i:s"))) ?>
							<div class="row-fluid">
								<div class="span6"><?php echo $this->Form->input('category_id', array('class'=>'textbox')) ?></div>
								<div class="span6"><?php echo $this->Form->input('place_id', array('class'=>'textbox')) ?></div>
							</div>
						<?php echo $this->Form->end(__('Submit')); ?>
					</div>
				</div>
			</div>
			
			<!-- Mapa -->
			<div class="span6"><div id="map"></div></div>
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
