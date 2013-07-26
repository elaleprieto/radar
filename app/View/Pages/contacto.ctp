<?php echo $this->Html->css(array( 'pages/contact'), '', array('inline'=>false)) ?>
<?php echo $this->Html->css(array( 'font-awesome/css/font-awesome.min'), '', array('inline'=>false)) ?>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<div class="row">
	<div class="span10">
		<div class="row-fluid">
			<div class="span4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
			<div class="span6">
				<form method="post" action="enviar.php">
			      	<fieldset>
			      		<h1 class="titulo">HOLA</h1>
			       		<label for="inputNombre">Nombre</label>
						<input class="span12" id="inputNombre" name="nombre" placeholder="tu nombre" type="text">
						<label for="inputApellido">Apellido</label>
						<input class="span12" id="inputApellido" name="apellido" placeholder="tu apellido" type="text">
						<label for="inputEmail">Email</label>
						<input class="span12" id="inputEmail" name="mail" placeholder="tu dirección de email" type="email">
						<label>Motivo</label>
						<label class="radio inline">
							<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>consulta
						</label>
						<label class="radio inline">
							<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">sugerencia
						</label>
						<label class="radio inline">
							<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">problema
						</label>
						<br><br>
						<label for="inputEmail">Mensaje</label>
						<textarea class="span12" rows="8" placeholder="Dejanos tu consulta" name="mensaje"></textarea>
						<br><br>
						<button type="submit" class="btn btn-verde btn-block" name="enviar">Enviar</button>
					</fieldset>
				</form>	
			</div>
		</div>
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