<div class="compliants view">
<h2><?php  echo __('Compliant'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($compliant['Compliant']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($compliant['Compliant']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($compliant['Compliant']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($compliant['Compliant']['description']); ?>
			&nbsp;
		</dd>
		<!--
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($compliant['Compliant']['modified']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($compliant['Event']['title'], array('controller' => 'events', 'action' => 'view', $compliant['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($compliant['User']['name'], array('controller' => 'users', 'action' => 'view', $compliant['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Compliant'), array('action' => 'edit', $compliant['Compliant']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Compliant'), array('action' => 'delete', $compliant['Compliant']['id']), null, __('Are you sure you want to delete # %s?', $compliant['Compliant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Compliants'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Compliant'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
