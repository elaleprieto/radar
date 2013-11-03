<div class="classifications form">
<?php echo $this->Form->create('Classification'); ?>
	<fieldset>
		<legend><?php echo __('Add Classification'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('color');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Classifications'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
