<div class="classifications view">
<h2><?php  echo __('Classification'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['color']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['sort']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($classification['Classification']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Classification'), array('action' => 'edit', $classification['Classification']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Classification'), array('action' => 'delete', $classification['Classification']['id']), null, __('Are you sure you want to delete # %s?', $classification['Classification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Classifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classification'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Places'); ?></h3>
	<?php if (!empty($classification['Place'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Sort'); ?></th>
		<th><?php echo __('Lat'); ?></th>
		<th><?php echo __('Long'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Website'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th><?php echo __('Accessibility Parking'); ?></th>
		<th><?php echo __('Accessibility Ramp'); ?></th>
		<th><?php echo __('Accessibility Equipment'); ?></th>
		<th><?php echo __('Accessibility Signage'); ?></th>
		<th><?php echo __('Accessibility Braille'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($classification['Place'] as $place): ?>
		<tr>
			<td><?php echo $place['id']; ?></td>
			<td><?php echo $place['name']; ?></td>
			<td><?php echo $place['sort']; ?></td>
			<td><?php echo $place['lat']; ?></td>
			<td><?php echo $place['long']; ?></td>
			<td><?php echo $place['created']; ?></td>
			<td><?php echo $place['modified']; ?></td>
			<td><?php echo $place['description']; ?></td>
			<td><?php echo $place['address']; ?></td>
			<td><?php echo $place['phone']; ?></td>
			<td><?php echo $place['email']; ?></td>
			<td><?php echo $place['website']; ?></td>
			<td><?php echo $place['image']; ?></td>
			<td><?php echo $place['accessibility_parking']; ?></td>
			<td><?php echo $place['accessibility_ramp']; ?></td>
			<td><?php echo $place['accessibility_equipment']; ?></td>
			<td><?php echo $place['accessibility_signage']; ?></td>
			<td><?php echo $place['accessibility_braille']; ?></td>
			<td><?php echo $place['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'places', 'action' => 'view', $place['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'places', 'action' => 'edit', $place['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'places', 'action' => 'delete', $place['id']), null, __('Are you sure you want to delete # %s?', $place['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
