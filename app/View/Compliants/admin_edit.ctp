<div class="compliants form col-sm-6">
<?php echo $this->Form->create('Compliant'); ?>
	<fieldset>
		<legend><?php echo __('Edit Compliant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo '<div class="form-group">'.$this->Form->input('title', array('class'=>'form-control')).'</div>';
		echo '<div class="form-group">'.$this->Form->input('description', array('class'=>'form-control')).'</div>';
		echo '<div class="form-group">'.$this->Form->input('event_id', array('class'=>'form-control', 'disabled' => 'disabled')).'</div>';
		echo '<div class="form-group">'.$this->Form->input('user_id', array('class'=>'form-control', 'disabled' => 'disabled')).'</div>';
	?>
	</fieldset>
	<br>
<?php echo $this->Form->end( array('class'=>'btn btn-verde'),__('Submit')); ?>
</div>
<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Compliant.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Compliant.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Compliants'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->