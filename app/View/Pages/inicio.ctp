<?php //echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 'application'), array('inline'=>false)) ?>
<?php echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'inicio'), array('inline'=>false)) ?>
<?php echo $this->Html->css(array('inicio'), '', array('inline'=>false)) ?>

<div class="row">
	<div class="span12">
		<div id="map"></div>
		<form method="post" action="/event/get/">
			<input value="1" name="interval" type="hidden">
			<div class="control-group btn-group" data-toggle="buttons-radio">
				<button type="button" class="btn active" data-set="interval" value="1">Hoy</button>
				<button type="button" class="btn" data-set="interval" value="2">Mañana</button>
				<button type="button" class="btn" data-set="interval" value="3">Últimos 7 días</button>
			</div>
			<div class="control-group">
				<script type="text/javascript">
				var categories = [
					'Arquitectura y diseño', 'Artes plásticas', 'Cine', 'Danza', 'Deporte',
					'Escultura', 'Fotografía', 'Literatura', 'Música', 'Teatro', 'Tecnología',
					'Infantiles',
				];
				for (var i = 0; i < categories.length; i++) {
					document.write('<label class="checkbox inline"><input type="checkbox" name="category" value="' + i + '"> ' + categories[i] + '</label>');
				}
				</script>
			</div>
		</form>
	</div>
</div>
