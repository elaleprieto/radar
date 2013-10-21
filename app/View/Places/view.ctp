<div class="row">
	<div class="col-sm-3">
		<?php echo $this->Html->image('logos/logoBetaVertical.png', array('class' => 'img-responsive')); ?>
	</div>
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-12">
				<h1><?php echo h($place['Place']['name']); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo h($place['Place']['description']); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h1><?php echo __('Accessibility'); ?></h1>
				<?php
				if($place['Place']['accessibility_parking'] == 1):
				?>
					<p>Plazas de aparcamiento reservadas para personas con discapacidad</p>
				<?php
				endif;
				if($place['Place']['accessibility_ramp'] == 1):
				?>
					<p>Escaleras, rampas o ascensores accesibles para vehículos de personas con movilidad reducida</p>
				<?php
				endif;
				if($place['Place']['accessibility_equipment'] == 1):
				?>
					<p>Equipos electrónicos, informáticos y audiovisuales adaptados</p>
				<?php
				endif;
				if($place['Place']['accessibility_signage'] == 1):
				?>
					<p>Señales y paneles informativos claramente perceptibles y comprensibles</p>
				<?php
				endif;
				if($place['Place']['accessibility_braille'] == 1):
				?>
					<p>Información táctil: Braille</p>
				<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>

				<!-- <div class="places view">
				<h2><?php  echo __('Place');
 ?></h2>
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
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Place'), array(
			'action' => 'edit',
			$place['Place']['id']
		));
 ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Place'), array(
				'action' => 'delete',
				$place['Place']['id']
			), null, __('Are you sure you want to delete # %s?', $place['Place']['id']));
 ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array(
				'controller' => 'places',
				'action' => 'index'
			));
 ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array(
				'controller' => 'places',
				'action' => 'add'
			));
 ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Places'); ?></h3>
	<?php if (!empty($place['Place'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Lat'); ?></th>
		<th><?php echo __('Long'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Date Start'); ?></th>
		<th><?php echo __('Date End'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Place Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($place['Place'] as $place): ?>
		<tr>
			<td><?php echo $place['id']; ?></td>
			<td><?php echo $place['title']; ?></td>
			<td><?php echo $place['lat']; ?></td>
			<td><?php echo $place['long']; ?></td>
			<td><?php echo $place['status']; ?></td>
			<td><?php echo $place['date_start']; ?></td>
			<td><?php echo $place['date_end']; ?></td>
			<td><?php echo $place['created']; ?></td>
			<td><?php echo $place['modified']; ?></td>
			<td><?php echo $place['category_id']; ?></td>
			<td><?php echo $place['place_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array(
					'controller' => 'places',
					'action' => 'view',
					$place['id']
				));
 ?>
				<?php echo $this->Html->link(__('Edit'), array(
						'controller' => 'places',
						'action' => 'edit',
						$place['id']
					));
 ?>
				<?php echo $this->Form->postLink(__('Delete'), array(
						'controller' => 'places',
						'action' => 'delete',
						$place['id']
					), null, __('Are you sure you want to delete # %s?', $place['id']));
 ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Place'), array(
				'controller' => 'places',
				'action' => 'add'
			));
 ?> </li>
		</ul>
	</div>
</div> -->