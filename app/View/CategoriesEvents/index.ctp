<div class="categoriesEvents index">
	<h2><?php echo __('Categories Events'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($categoriesEvents as $categoriesEvent): ?>
	<tr>
		<td><?php echo h($categoriesEvent['CategoriesEvent']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($categoriesEvent['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoriesEvent['Category']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($categoriesEvent['Event']['title'], array('controller' => 'events', 'action' => 'view', $categoriesEvent['Event']['id'])); ?>
		</td>
		<td><?php echo h($categoriesEvent['CategoriesEvent']['created']); ?>&nbsp;</td>
		<td><?php echo h($categoriesEvent['CategoriesEvent']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoriesEvent['CategoriesEvent']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoriesEvent['CategoriesEvent']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoriesEvent['CategoriesEvent']['id']), null, __('Are you sure you want to delete # %s?', $categoriesEvent['CategoriesEvent']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Categories Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
