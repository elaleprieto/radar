<div class="classificationsPlaces index">
	<h2><?php echo __('Classifications Places'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('classifications_id'); ?></th>
			<th><?php echo $this->Paginator->sort('place_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($classificationsPlaces as $classificationsPlace): ?>
	<tr>
		<td><?php echo h($classificationsPlace['ClassificationsPlace']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($classificationsPlace['Classifications']['name'], array('controller' => 'classifications', 'action' => 'view', $classificationsPlace['Classifications']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($classificationsPlace['Place']['name'], array('controller' => 'places', 'action' => 'view', $classificationsPlace['Place']['id'])); ?>
		</td>
		<td><?php echo h($classificationsPlace['ClassificationsPlace']['created']); ?>&nbsp;</td>
		<td><?php echo h($classificationsPlace['ClassificationsPlace']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $classificationsPlace['ClassificationsPlace']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $classificationsPlace['ClassificationsPlace']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $classificationsPlace['ClassificationsPlace']['id']), null, __('Are you sure you want to delete # %s?', $classificationsPlace['ClassificationsPlace']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Classifications Place'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('controller' => 'classifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classifications'), array('controller' => 'classifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
