<div class="classifications form">
<?php echo $this->Form->create('Classification'); ?>
	<fieldset>
		<legend><?php echo __('Edit Classification'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('color');
		echo $this->Form->input('sort');
		echo $this->Form->input('Place');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Classification.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Classification.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
