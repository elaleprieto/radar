<?php //echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 'application'), array('inline'=>false)) ?>
<?php echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true', 'inicio'), array('inline'=>false)) ?>
<?php echo $this->Html->scriptBlock('WEBROOT="' . $this -> Html -> url('/', true) . '"', $options = array('inline' => true)) # Se define la ruta base ?>
<?php echo $this->Html->css(array('inicio'), '', array('inline'=>false)) ?>

<div class="row">
    <!-- MAPA -->
    <div class="span8">
        <div class="row">
            <p>Una agenda de cultura, <b>hecha por todxs</b></p>
            <div id="map"></div>
		</div>
        <div class="row">
            <?php $this->Form->create('Event') ?>
            <input value="1" name="interval" type="hidden">
			<div id="eventInterval" class="control-group btn-group" data-toggle="buttons-radio">
			    <button type="button" class="btn disabled">qué hacer...</button>
				<button type="button" class="btn btn-verde active" data-set="interval" value="1">Hoy</button>
				<button type="button" class="btn btn-celeste" data-set="interval" value="2">Mañana</button>
				<button type="button" class="btn btn-rojo" data-set="interval" value="7">Próximos 7 días</button>
			</div>
			<div id="eventInterval" class="control-group btn-group pull-right" data-toggle="buttons-radio">
                <?= $this->Html->link('Agregar evento', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-warning pull-right')) ?>
            </div>
        </div>   
	</div>
	<!-- CATEGORÍAS -->
	<div class="span2">
        <p>Categorías</p>
		<?php foreach ($categories as $categoria): ?>
		    <div class="categoria active">
    		    <?php
        		    $cat=str_replace("á","a",$categoria);
                    $cat=str_replace("é","e",$cat);
                    $cat=str_replace("í","i",$cat);
                    $cat=str_replace("ó","o",$cat);
                    $cat=str_replace("ú","u",$cat);
                    $cat=str_replace("ñ","ni",$cat);
        		    echo $this->Html->image('categorias/'.strtolower(preg_replace("/[^A-z]/","",$cat)).'.png', array('class'=>'icono-categoria'));
        		    echo $categoria;
    		    ?>
            </div>
        <?php endforeach ?>
		<!--<div id="eventCategories" class="control-group">-->
        <div id="eventCategories" class="control-group">
        <?php
            // echo $this->Form->input('category', array('class'=>'checkbox inline'
            // , 'div'=>'hola'
            // , 'label'=>FALSE
			// , 'multiple' => 'checkbox'
			// , 'type' => 'select'
            // )
            // );
        ?>
        </div>
		<?php //$this->Form->end() ?>
	</div>
	<!-- SPONSOR -->
	<div class="span2">
	    <ul class="thumbnails">
            <li class="span2">
                <a href="#" class="thumbnail">
                    <?=$this->Html->image('sponsor/santafedisenia.jpg');?>
                </a>
            </li>
            <li class="span2">
                <a href="#" class="thumbnail">
                    <?=$this->Html->image('sponsor/tallercandombe.jpg');?>
                </a>
            </li>
        </ul>
	</div>
</div>
<div class="row">
	<div class="span12">
		<table id="eventsList" class="table table-striped">
			<thead>
				<tr>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Evento</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>