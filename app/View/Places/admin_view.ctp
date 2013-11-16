<div class="places view">
<h2><?php  echo __('Place'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($place['Place']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($place['Place']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort'); ?></dt>
		<dd>
			<?php echo h($place['Place']['sort']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($place['Place']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Long'); ?></dt>
		<dd>
			<?php echo h($place['Place']['long']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($place['Place']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($place['Place']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($place['Place']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($place['Place']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($place['Place']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($place['Place']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($place['Place']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($place['Place']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accessibility Parking'); ?></dt>
		<dd>
			<?php echo h($place['Place']['accessibility_parking']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accessibility Ramp'); ?></dt>
		<dd>
			<?php echo h($place['Place']['accessibility_ramp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accessibility Equipment'); ?></dt>
		<dd>
			<?php echo h($place['Place']['accessibility_equipment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accessibility Signage'); ?></dt>
		<dd>
			<?php echo h($place['Place']['accessibility_signage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accessibility Braille'); ?></dt>
		<dd>
			<?php echo h($place['Place']['accessibility_braille']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($place['Place']['user_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Place'), array('action' => 'edit', $place['Place']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Place'), array('action' => 'delete', $place['Place']['id']), null, __('Are you sure you want to delete # %s?', $place['Place']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('controller' => 'classifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classification'), array('controller' => 'classifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($place['Event'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Lat'); ?></th>
		<th><?php echo __('Long'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Date Start'); ?></th>
		<th><?php echo __('Date End'); ?></th>
		<th><?php echo __('Website'); ?></th>
		<th><?php echo __('Cost'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Verified'); ?></th>
		<th><?php echo __('Rate'); ?></th>
		<th><?php echo __('Complaint'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Place Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($place['Event'] as $event): ?>
		<tr>
			<td><?php echo $event['id']; ?></td>
			<td><?php echo $event['title']; ?></td>
			<td><?php echo $event['address']; ?></td>
			<td><?php echo $event['description']; ?></td>
			<td><?php echo $event['lat']; ?></td>
			<td><?php echo $event['long']; ?></td>
			<td><?php echo $event['status']; ?></td>
			<td><?php echo $event['date_start']; ?></td>
			<td><?php echo $event['date_end']; ?></td>
			<td><?php echo $event['website']; ?></td>
			<td><?php echo $event['cost']; ?></td>
			<td><?php echo $event['active']; ?></td>
			<td><?php echo $event['verified']; ?></td>
			<td><?php echo $event['rate']; ?></td>
			<td><?php echo $event['complaint']; ?></td>
			<td><?php echo $event['created']; ?></td>
			<td><?php echo $event['modified']; ?></td>
			<td><?php echo $event['category_id']; ?></td>
			<td><?php echo $event['place_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Classifications'); ?></h3>
	<?php if (!empty($place['Classification'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Sort'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($place['Classification'] as $classification): ?>
		<tr>
			<td><?php echo $classification['id']; ?></td>
			<td><?php echo $classification['name']; ?></td>
			<td><?php echo $classification['color']; ?></td>
			<td><?php echo $classification['sort']; ?></td>
			<td><?php echo $classification['created']; ?></td>
			<td><?php echo $classification['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'classifications', 'action' => 'view', $classification['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'classifications', 'action' => 'edit', $classification['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'classifications', 'action' => 'delete', $classification['id']), null, __('Are you sure you want to delete # %s?', $classification['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Classification'), array('controller' => 'classifications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
