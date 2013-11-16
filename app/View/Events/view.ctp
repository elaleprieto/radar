<?php
App::uses('CakeTime', 'Utility');

# Styles
echo $this -> Html -> css(array('events/view'));
?>

<div class="row">
	<div class="col-sm-3">
		<!-- Categoría del lugar-->
		<div class="row">
		</div>
		<div class="row">
			<?php echo $this->Html->image('logos/logoBetaVertical.png', array('class' => 'img-responsive')); ?>
		</div>
	</div>
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-12">
				<h2><?php echo h($event['Event']['title']); ?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo h($event['Event']['description']); ?></p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<p><span class="glyphicon glyphicon-map-marker" style="color:#ABD402"></span>&nbsp;&nbsp;<?php echo h($event['Event']['address']); ?></p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-2 col-offset-2">
				<p><?php echo __('From')?></p>
			</div>
			<div class="col-sm-4">
				<p><span class="glyphicon glyphicon-calendar" style="color:#ABD402"></span>&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_start'], '%d/%m/%Y'); ?></p>
			</div>
			<div class="col-sm-4">
				<p><span class="glyphicon glyphicon-time" style="color:#ABD402"></span>&nbsp;&nbsp;<?php echo CakeTime::format($event['Event']['date_start'], '%H:%M'); ?></p>
			</div>
		</div>	<hr>
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
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo __('Accessibility'); ?></p>
				<p></p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo __('Additional information'); ?></p>
				<p><?php echo __('Ticket sales').' :'.$event['Event']['cost']; ?></p>
				<p><?php echo $event['Event']['website']; ?></p>
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
