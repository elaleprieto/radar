<div class="rols view">
<h2><?php echo __('Rol'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($rol['Rol']['weight']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rol'), array('action' => 'edit', $rol['Rol']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rol'), array('action' => 'delete', $rol['Rol']['id']), null, __('Are you sure you want to delete # %s?', $rol['Rol']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rols'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rol'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($rol['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Role'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Confirmed'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Gender'); ?></th>
		<th><?php echo __('Birthday'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Map Lat'); ?></th>
		<th><?php echo __('Map Lng'); ?></th>
		<th><?php echo __('Map Type'); ?></th>
		<th><?php echo __('Map Zoom'); ?></th>
		<th><?php echo __('Facebook Id'); ?></th>
		<th><?php echo __('Twitter Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Rol Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($rol['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['role']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['confirmed']; ?></td>
			<td><?php echo $user['active']; ?></td>
			<td><?php echo $user['gender']; ?></td>
			<td><?php echo $user['birthday']; ?></td>
			<td><?php echo $user['location']; ?></td>
			<td><?php echo $user['map_lat']; ?></td>
			<td><?php echo $user['map_lng']; ?></td>
			<td><?php echo $user['map_type']; ?></td>
			<td><?php echo $user['map_zoom']; ?></td>
			<td><?php echo $user['facebook_id']; ?></td>
			<td><?php echo $user['twitter_id']; ?></td>
			<td><?php echo $user['created']; ?></td>
			<td><?php echo $user['modified']; ?></td>
			<td><?php echo $user['rol_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
