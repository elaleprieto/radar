<div class="categoriesEvents view">
<h2><?php  echo __('Categories Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoriesEvent['CategoriesEvent']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoriesEvent['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoriesEvent['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoriesEvent['Event']['title'], array('controller' => 'events', 'action' => 'view', $categoriesEvent['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($categoriesEvent['CategoriesEvent']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($categoriesEvent['CategoriesEvent']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Categories Event'), array('action' => 'edit', $categoriesEvent['CategoriesEvent']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Categories Event'), array('action' => 'delete', $categoriesEvent['CategoriesEvent']['id']), null, __('Are you sure you want to delete # %s?', $categoriesEvent['CategoriesEvent']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categories Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
