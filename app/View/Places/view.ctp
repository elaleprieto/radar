<?php
# Styles
echo $this -> Html -> css(array('events/view'));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3 hiden-xs">
				<?php //echo $this->Html->image('logos/logoBetaVertical.png', array('class' => 'img-responsive')); ?>
				<?php 
				if($place['Place']['image'])
					$foto = 'fotos/places/'.$place['Place']['image'];
				else
					$foto = 'logos/logoBetaVertical.png';

				echo $this->Html->image($foto, array('class' => 'img-responsive')); 
				?>
			</div>
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-12">
						<h2><?php echo h($place['Place']['name']); ?></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p><span class="glyphicon glyphicon-map-marker" style="color:#ABD402"></span>
							&nbsp;&nbsp;<?php echo h($place['Place']['address']); ?>
						</p>
						<p>
							<?php
								if($place['Place']['phone']){
									echo '<span class="glyphicon glyphicon-phone-alt" style="color:#ABD402"></span>';
									echo '&nbsp;&nbsp;'.h($place['Place']['phone']);
								}
							?>
							<!--<span class="glyphicon glyphicon-phone-alt" style="color:#ABD402"></span>-->
							<!--&nbsp;&nbsp;<?php echo h($place['Place']['phone']); ?>-->
						</p>
						<p>
							<?php
								if($place['Place']['email']){
									echo '<span class="glyphicon glyphicon-envelope" style="color:#ABD402"></span>';
									echo '&nbsp;&nbsp;'.h($place['Place']['email']);
								}
							?>
							<!--<span class="glyphicon glyphicon-envelope" style="color:#ABD402"></span>-->
							<!--&nbsp;&nbsp;<?php echo h($place['Place']['email']); ?>-->
						</p>
						<p>
							<?php
								if($place['Place']['website']){
									echo '<span class="glyphicon glyphicon-globe" style="color:#ABD402"></span>';
									echo '&nbsp;&nbsp';
									echo '<a href="http://'.$place['Place']['website'].'" target="_blank">';
									echo h($place['Place']['website']);
									echo '</a>';
								}
							?>
							<!--<span class="glyphicon glyphicon-globe" style="color:#ABD402"></span>-->
							<!--&nbsp;&nbsp;<a <?php echo 'href="'.$place['Place']['website'].'" target="_blank"'?> ><?php echo h($place['Place']['website']); ?></a>-->
				
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<p style="justify"><?php echo h($place['Place']['description']); ?></p>
			</div>
		</div>
		<?php if($place['Place']['description']){
			echo '<hr>';
		}?>
		<div class="row">
			<div class="col-sm-12">
				<?php
					if(($place['Place']['accessibility_parking'] ==1) || ($place['Place']['accessibility_ramp']==1) ||
						($place['Place']['accessibility_equipment']==1) || ($place['Place']['accessibility_signage']==1) ||
						($place['Place']['accessibility_braille']==1)) {

						echo $this->Html->tag('h3', __('Accessibility')); 
					} else {
						echo '<p>No hay información disponible sobre accesibilidad.</p><br>';
					}
				?>	
				<?php
				if($place['Place']['accessibility_parking'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-warning-sign" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Parking spaces reserved for people with disabilities')?>
					</p>
				<?php
				endif;
				if($place['Place']['accessibility_ramp'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-road" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Stairs, ramps or elevators accessible wheelchair')?>
					</p>
				<?php
				endif;
				if($place['Place']['accessibility_equipment'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-headphones" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Electronic equipment and audiovisual adapted')?>
					</p>
				<?php
				endif;
				if($place['Place']['accessibility_signage'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-eye-open" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Signs and information boards clearly perceived and understood')?>
					</p>
				<?php
				endif;
				if($place['Place']['accessibility_braille'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-hand-up" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Tactile information: Braille')?>
					</p>
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