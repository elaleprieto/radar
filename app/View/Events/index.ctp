<?php 
echo $this->Html->css(array('inicio', 'events/index'), '', array('inline'=>false));
echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true'
    	, 'angular/filters'
    	, 'events/index_an'
	)
    , array('inline'=>false)
);
?>

<?php //debug($this->request->clientIp()) ?>
<?php
# User Location
if(AuthComponent::user('location')) {
	$userLocation = AuthComponent::user('location');
} else {
	$ip = '190.183.62.72';
	// $ip = $this->request->clientIp();
	$ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
	
	if($ipData && $ipData->geoplugin_countryName != null){
		$userLocation = $ipData->geoplugin_city . ', ' . $ipData->geoplugin_countryName;
		
		# Se guarda el userLocation
		if($userId = AuthComponent::user('id')) {
			// $this->requestAction(array('controller' => 'users', 'action' => 'setLocation')
				// , array('pass' => array($userId, $userLocation))
			// );
			$this->requestAction("/users/setLocation/$userId/$userLocation");
		}
	} else {
		$userLocation = null;
	}
}
?>

<div ng-controller="EventoController" ng-init="user.location='<?php echo $userLocation; ?>'">
    <div class="row">
        <!-- MAPA -->
        <div class="span8">
        	<div class="row"><br>
				<div class="span4">
					<div class="row">
						<div id="eventInterval" class="control-group btn-group" data-toggle="buttons-radio">
	    					<button class="btn btn-verde" ng-click="centerMap()">Región</button>
	    					<button class="btn btn-verde" ng-click="centerMap('cordoba')">Córdoba</button>
							<button class="btn btn-verde" ng-click="centerMap('santafe')">Santa Fe</button>
							<button class="btn btn-warning" ng-click="setLocation()">Mi Ubicación</button>
						</div>
					</div>
				</div>
				
				<!-- Error Message -->
				<div class="span4" ng-show="errorLocation" ng-cloak>
					<span class="alert" ng-bind="errorLocation"></span>
				</div>
			</div>
            <div class="row">
                <div id="map"></div>
    		</div>
            <div class="row">
                <?php $this->Form->create('Event') ?>
                <input value="1" name="interval" type="hidden">
    			<div id="eventInterval" class="control-group btn-group" data-toggle="buttons-radio">
    			    <button type="button" class="btn disabled">qué hacer...</button>
    				<button type="button" class="btn btn-verde active" ng-click="setEventInterval(1)">Hoy</button>
    				<button type="button" class="btn btn-verde" ng-click="setEventInterval(2)">Mañana</button>
    				<button type="button" class="btn btn-verde" ng-click="setEventInterval(7)">Próximos 7 días</button>
    			</div>
    			<div id="eventInterval" class="control-group btn-group pull-right" data-toggle="buttons-radio">
                    <?php echo $this->Html->link('Agregar evento'
                        , array('controller'=>'events', 'action'=>'add')
                        , array('class'=>'btn btn-warning pull-right'))
                    ?>
                </div>
            </div>   
    	</div>
    	
    	<!-- CATEGORÍAS -->
    	<div class="span2">
    	    <p loading>Cargando Categorías...</p>
    	    <div ng-view></div>
    	    <div ng-controller="CategoriaController">
                <p loaded>Categorías</p>
        	    <div class="row-fluid" ng-init='categorias=<?php echo json_encode($categorias) ?>'>
        	        <div class="span12">
            	        <div class="row-fluid categoriaLink" ng-class="{highlight:categoria.highlight}" 
            	           ng-model="categoria" ng-repeat="categoria in categorias" ng-click="show(categoria)">
                	        <div class="span2">
                	            <img class="icono-categoria" 
                	               ng-src="<?php echo IMAGES_URL ?>categorias/{{categoria.Category.icon}}" />
            	            </div>
                	        <div class="span10 itemcate" ng-bind="categoria.Category.name"></div>
            	        </div>
        	        </div>
        	    </div>
    	    </div>
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
    
    <!-- Events List -->
    <div class="row">
    	<div class="span12">
    		<table id="eventsList" class="table table-striped">
    			<thead>
    				<tr>
    					<th>Fecha Inicio</th>
    					<th>Fecha Fin</th>
    					<th>Evento</th>
    					<th>Dirección</th>
    				</tr>
    			</thead>
    			<tbody>
    			    <tr ng-repeat="evento in eventos | orderBy:'Event.date_start'">
    			        <td ng-bind="evento.Event.date_start | isodate | date:'dd/MM/yyyy HH:mm'"></td>
    			        <td ng-bind="evento.Event.date_end | isodate | date:'dd/MM/yyyy HH:mm'"></td>
    			        <td ng-bind="evento.Event.title"></td>
    			        <td ng-bind="evento.Event.address"></td>
    			    </tr>
    			</tbody>
    		</table>
    	</div>
    </div>
</div>