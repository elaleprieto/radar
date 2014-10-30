<?php
App::uses('CakeTime', 'Utility');

# Styles
echo $this -> Html -> css(array('events/view'));
?>

<div class="row">
	<div class="col-sm-12">
		<!-- Categoría del lugar-->
		<div class="row">
		</div>
		<div class="row">
			<?php //echo $this->Html->image('logos/logoBetaVertical.png', array('class' => 'img-responsive')); ?>
			<?php 
			if($event['Event']['foto'])
				$foto = 'fotos/'.$event['Event']['foto'];
			else
				$foto = 'logos/logoBetaVertical.png';

			echo $this->Html->image($foto, array('class' => 'img-responsive')); 
			?>
		</div>
	</div>
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-12">
				<h2><?php echo h($event['Event']['title']); ?></h2>
			</div>
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-12">
						<h2><?php echo h($event['Event']['title']); ?></h2>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<p>	<span class="glyphicon glyphicon-map-marker" style="color:#ABD402"></span>
							&nbsp;&nbsp;<?php echo h($event['Event']['address']); ?>
						</p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-2 col-offset-2">
						<p><?php echo __('From')?></p>
					</div>
					<div class="col-sm-4">
						<p>
							<span class="glyphicon glyphicon-calendar" style="color:#ABD402"></span>
							&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_start'], '%d/%m/%Y'); ?>
						</p>
					</div>
					<div class="col-sm-4">
						<p>
							<span class="glyphicon glyphicon-time" style="color:#ABD402"></span>
							&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_start'], '%H:%M'); ?>
						</p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-2 col-offset-2">
						<p><?php echo __('To')?></p>
					</div>
					<div class="col-sm-4">
						<p><span class="glyphicon glyphicon-calendar" style="color:#ABD402"></span>&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_end'], '%d/%m/%Y'); ?></p>
					</div>
					<div class="col-sm-4">
						<p><span class="glyphicon glyphicon-time" style="color:#ABD402"></span>&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_end'], '%H:%M'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo h($event['Event']['description']); ?></p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<h3><?php
						if(($event['Event']['accessibility_parking'] ==1) || ($event['Event']['accessibility_ramp']==1) ||
							($event['Event']['accessibility_equipment']==1) || ($event['Event']['accessibility_signage']==1) ||
							($event['Event']['accessibility_braille']==1)){ 
						echo __('Accessibility'); 
						}?>
				</h3>
				<?php
				if($event['Event']['accessibility_parking'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-warning-sign" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Parking spaces reserved for people with disabilities')?>
					</p>
				<?php
				endif;
				if($event['Event']['accessibility_ramp'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-road" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Stairs, ramps or elevators accessible wheelchair')?>
					</p>
				<?php
				endif;
				if($event['Event']['accessibility_equipment'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-headphones" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Electronic equipment and audiovisual adapted')?>
					</p>
				<?php
				endif;
				if($event['Event']['accessibility_signage'] == 1):
				?>
					<p>
						<span class="glyphicon glyphicon-eye-open" style="color:#ABD402"></span>&nbsp;&nbsp;
						<?php echo __('Signs and information boards clearly perceived and understood')?>
					</p>
				<?php
				endif;
				if($event['Event']['accessibility_braille'] == 1):
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
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<h3><?php echo __('Additional information'); ?></h3>
				<p>
					<span class="glyphicon glyphicon-tag" style="color:#ABD402"></span>&nbsp;&nbsp;
					&nbsp;&nbsp;<?php echo __('Ticket sales').' :'.$event['Event']['cost']; ?>
				</p>
							
				<br>
				<?php
				if($event['Event']['website'] != NULL):
				?>
					<p>
						<span class="glyphicon glyphicon-globe" style="color:#ABD402"></span>&nbsp;&nbsp;
						&nbsp;&nbsp;<a <?php echo 'href="http://'.$event['Event']['website'].'" target="_blank"'?> ><?php echo h($event['Event']['website']); ?></a>
					</p>
				<?php
				endif;
				?>
				<br>
				<?php
				if($event['Event']['video'] != NULL):
				?>
					<p>
						<span class="glyphicon glyphicon-facetime-video" style="color:#ABD402"></span>&nbsp;&nbsp;
						&nbsp;&nbsp;
						<? echo $event['Event']['video'];?>						
					</p>
				<?php
				endif;
				?>
			</div>
		</div>
	
		<!--		
		<div class="row">
			<div class="col-sm-12">
				<h3><?php echo __('Date Start'); ?></h3>
				<p><?php echo CakeTime::format($event['Event']['date_start'], '%d/%m/%Y %H:%M'); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3><?php echo __('Date End'); ?></h3>
				<p><?php echo CakeTime::format($event['Event']['date_end'], '%d/%m/%Y %H:%M'); ?></p>
			</div>
		</div>
		-->
	</div>
</div>

<?php //debug($event['Event']) ?>
	

<!-- <div class="events view">
<h2><?php  echo __('Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($event['Event']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($event['Event']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Long'); ?></dt>
		<dd>
			<?php echo h($event['Event']['long']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($event['Event']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Start'); ?></dt>
		<dd>
			<?php echo h($event['Event']['date_start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date End'); ?></dt>
		<dd>
			<?php echo h($event['Event']['date_end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($event['Event']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($event['Event']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['Category']['name'], array('controller' => 'categories', 'action' => 'view', $event['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Place'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['Place']['name'], array('controller' => 'places', 'action' => 'view', $event['Place']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event'), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Places'), array('controller' => 'places', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Place'), array('controller' => 'places', 'action' => 'add')); ?> </li>
	</ul>
</div> -->
