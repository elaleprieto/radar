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
		<div class="row hidden-xs">
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
		</div>
		<div class="row hidden-xs">
			<div class="col-sm-12">
				<p><?php echo h($event['Event']['description']); ?></p>
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
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<?php
					if(($event['Event']['accessibility_parking'] ==1) || ($event['Event']['accessibility_ramp']==1) ||
						($event['Event']['accessibility_equipment']==1) || ($event['Event']['accessibility_signage']==1) ||
						($event['Event']['accessibility_braille']==1)) { 
					
						echo $this->Html->tag('h3', __('Accessibility')); 
					} else {
						echo '<p>No hay información disponible sobre accesibilidad.</p>';
					}
				?>
				
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
					<!--&nbsp;&nbsp;<?php echo __('Ticket sales').' :'.$event['Event']['cost']; ?>-->
					&nbsp;&nbsp;
					<?php 
						echo __('Ticket sales').':';
						if($event['Event']['cost']!=0){
							echo ' si. Costo: '.$event['Event']['cost']; 
						} else {
							echo ' no';
						}
					
					?>
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
				if(isset($event['Event']['video']) && $event['Event']['video'] != NULL):
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
	</div>
</div>