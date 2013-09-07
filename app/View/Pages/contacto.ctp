<?php echo $this->Html->css(array( 'pages/contact'), '', array('inline'=>false)) ?>
<?php echo $this->Html->css(array( 'font-awesome/css/font-awesome.min'), '', array('inline'=>false)) ?>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<div class="row">
	<div class="span10">
		<dl class="dl-horizontal">
        	<dt>
        		<br><br><br><br><div class="resaltado"><h1 >HOLA</h1></div>
        		<i class="icon-facebook-sign icon-2x"></i>
				<i class="icon-twitter-sign icon-2x"></i><br>
				<i class="icon-pinterest-sign icon-2x"></i>
				<i class="icon-youtube-sign icon-2x"></i><br>
				<i class="icon-flickr icon-2x"></i>
				<i class="icon-rss icon-2x"></i>
        	</dt>
            <dd>
            	<form method="post" action="enviar.php" class="form-horizontal ">
			      	<fieldset>
			      		<legend>Contactate</legend>
			       		<div class="control-group">
							<label class="control-label" for="inputNombre">Nombre</label>
							<div class="controls">
								<input class="span4" id="inputNombre" name="nombre" placeholder="tu nombre" type="text">
							</div>
						</div>
			        	<div class="control-group">
							<label class="control-label" for="inputApellido">Apellido</label>
							<div class="controls">
								<input class="span4" id="inputApellido" name="apellido" placeholder="tu apellido" type="text">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputEmail">Email</label>
							<div class="controls">
								<input class="span4" id="inputEmail" name="mail" placeholder="tu dirección de email" type="email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Motivo</label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>consulta
								</label>
								<label class="radio inline">
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">sugerencia
								</label>
								<label class="radio inline">
									<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">problema
								</label>
							</div>
			        	</div>
			        	<div class="control-group">
							<label class="control-label" for="inputEmail">Mensaje</label>
							<div class="controls">
			               		<textarea class="span4" rows="8" placeholder="Dejanos tu consulta" name="mensaje"></textarea>
							</div>
						</div>
						<div class="control-group">
							<div class="controls span4">
								<button type="submit" class="btn btn-verde btn-block " name="enviar">Enviar</button>
							</div>
						</div>
					</fieldset>
				</form>	            	
			</dd>
		</dl>
	</div>
<!-- SPONSOR -->
	<div class="span2">
	    <ul class="thumbnails">
            <li class="span2">
                <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/santafedisenia.jpg');?></a>
            </li>
            <li class="span2">
                <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/tallercandombe.jpg');?></a>
            </li>
        </ul>
	</div>
</div>