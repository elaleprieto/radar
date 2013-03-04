<?php //echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 'application'), array('inline'=>false)) ?>
<?php echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'inicio'), array('inline'=>false)) ?>
<?php echo $this->Html->css(array('inicio'), '', array('inline'=>false)) ?>

<div class="row">
	<div class="span12">
		<div id="map"></div>
		<?php $this->Form->create('Event') ?>
			<input value="1" name="interval" type="hidden">
			<div class="control-group btn-group" data-toggle="buttons-radio">
				<button type="button" class="btn active" data-set="interval" value="1">Hoy</button>
				<button type="button" class="btn" data-set="interval" value="2">Mañana</button>
				<button type="button" class="btn" data-set="interval" value="3">Últimos 7 días</button>
			</div>
			<div class="control-group">
				<?php echo $this->Form->input('category', array('type' => 'select', 'multiple' => 'checkbox', 'class'=>'checkbox inline', 'label'=>FALSE)); ?>
			</div>
		<?php $this->Form->end() ?>
	</div>
</div>
<div class="row">
	<div class="span12">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Evento</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($events as $event): ?>
					<tr>
						<td><?php echo $event['Event']['date_start'] ?></td>
						<td><?php echo $event['Event']['date_end'] ?></td>
						<td><?php echo $event['Event']['title'] ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>