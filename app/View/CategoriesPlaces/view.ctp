<div class="categoriesPlaces view">
<h2><?php  echo __('Categories Place'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoriesPlace['CategoriesPlace']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoriesPlace['Category']['name'], array('controller' => 'categories', 'action' => 'view', $categoriesPlace['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Place'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoriesPlace['Place']['name'], array('controller' => 'places', 'action' => 'view', $categoriesPlace['Place']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($categoriesPlace['CategoriesPlace']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($categoriesPlace['CategoriesPlace']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Categories Place'), array('action' => 'edit', $categoriesPlace['CategoriesPlace']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Categories Place'), array('action' => 'delete', $categoriesPlace['CategoriesPlace']['id']), null, __('Are you sure you want to delete # %s?', $categoriesPlace['CategoriesPlace']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories Places'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categories Place'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
