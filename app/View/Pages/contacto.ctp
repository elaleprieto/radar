<?php echo $this->Html->css(array( 'pages/contact'), '', array('inline'=>false)) ?>
<?php echo $this->Html->css(array( 'font-awesome/css/font-awesome.min'), '', array('inline'=>false)) ?>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<div class="row">
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
			<div class="col-sm-6">
				<form method="post" action="enviar.php" role="form">
			      	<fieldset>
			      		<h1 class="titulo">HOLA</h1>
			      		<div class="form-group">
			       			<label for="inputNombre">Nombre</label>
							<input class="col-sm-12 form-control" id="inputNombre" name="nombre" placeholder="tu nombre" type="text">
						</div>
						<div class="form-group">
							<label for="inputApellido">Apellido</label>
							<input class="col-sm-12 form-control" id="inputApellido" name="apellido" placeholder="tu apellido" type="text">
						</div>
						<div class="form-group">
							<label for="inputEmail">Email</label>
							<input class="col-sm-12 form-control" id="inputEmail" name="mail" placeholder="tu dirección de email" type="email">
						</div>
						<div class="form-group">
							<label>Motivo</label>
							<label class="radio-inline">
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>consulta
							</label>
							<label class="radio-inline">
								<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">sugerencia
							</label>
							<label class="radio-inline">
								<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">problema
							</label>
						</div>
						<div class="form-group">
							<label for="inputEmail">Mensaje</label>
							<textarea class="col-sm-12 form-control" rows="8" placeholder="Dejanos tu consulta" name="mensaje"></textarea>
						</div>
						
						<button type="submit" class="btn btn-verde btn-block" name="enviar">Enviar</button>
					</fieldset>
				</form>	
			</div>
		</div>
	</div>
<!-- SPONSOR -->
	<div class="col-sm-2">
	    <div class="col-sm-12">
	    	  <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/santafedisenia.jpg');?></a>
	    </div>
	    <div class="col-sm-12">
	    	    <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/tallercandombe.jpg');?></a>
	    </div>
	</div>
</div>