<div class="compliants index">
	<h2><?php echo __('Compliants'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($compliants as $compliant): ?>
	<tr>
		<td><?php echo h($compliant['Compliant']['id']); ?>&nbsp;</td>
		<td><?php echo h($compliant['Compliant']['title']); ?>&nbsp;</td>
		<td><?php echo h($compliant['Compliant']['description']); ?>&nbsp;</td>
		<td><?php echo h($compliant['Compliant']['created']); ?>&nbsp;</td>
		<td><?php echo h($compliant['Compliant']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($compliant['Event']['title'], array('controller' => 'events', 'action' => 'view', $compliant['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($compliant['User']['name'], array('controller' => 'users', 'action' => 'view', $compliant['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $compliant['Compliant']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $compliant['Compliant']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $compliant['Compliant']['id']), null, __('Are you sure you want to delete # %s?', $compliant['Compliant']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Compliant'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
