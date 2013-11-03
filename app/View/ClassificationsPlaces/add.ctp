<div class="classificationsPlaces form">
<?php echo $this->Form->create('ClassificationsPlace'); ?>
	<fieldset>
		<legend><?php echo __('Add Classifications Place'); ?></legend>
	<?php
		echo $this->Form->input('classifications_id');
		echo $this->Form->input('place_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Classifications Places'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('controller' => 'classifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classifications'), array('controller' => 'classifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
