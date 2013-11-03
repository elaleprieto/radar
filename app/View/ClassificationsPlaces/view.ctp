<div class="classificationsPlaces view">
<h2><?php  echo __('Classifications Place'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($classificationsPlace['ClassificationsPlace']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Classifications'); ?></dt>
		<dd>
			<?php echo $this->Html->link($classificationsPlace['Classifications']['name'], array('controller' => 'classifications', 'action' => 'view', $classificationsPlace['Classifications']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Place'); ?></dt>
		<dd>
			<?php echo $this->Html->link($classificationsPlace['Place']['name'], array('controller' => 'places', 'action' => 'view', $classificationsPlace['Place']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($classificationsPlace['ClassificationsPlace']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($classificationsPlace['ClassificationsPlace']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Classifications Place'), array('action' => 'edit', $classificationsPlace['ClassificationsPlace']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Classifications Place'), array('action' => 'delete', $classificationsPlace['ClassificationsPlace']['id']), null, __('Are you sure you want to delete # %s?', $classificationsPlace['ClassificationsPlace']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Classifications Places'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classifications Place'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('controller' => 'classifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classifications'), array('controller' => 'classifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
