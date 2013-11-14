<?php echo $this->Html->css(array( 'pages/contact'), '', array('inline'=>false)) ?>
<?php echo $this->Html->css(array( 'font-awesome/css/font-awesome.min'), '', array('inline'=>false)) ?>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<div class="row">
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-7 col-sm-offset-3">
				<form method="post" action="enviar.php" role="form">
			      	<fieldset>
			      		<h1 class="titulo"><?php echo __('Contact us')?></h1>
			      		<div class="form-group">
			       			<label for="inputNombre"><?php echo __('Name')?></label>
							<input class="col-sm-12 form-control" id="inputNombre" name="nombre" placeholder="tu nombre" type="text">
						</div>
						<div class="form-group">
							<label for="inputApellido"><?php echo __('Surname')?></label>
							<input class="col-sm-12 form-control" id="inputApellido" name="apellido" placeholder="tu apellido" type="text">
						</div>
						<div class="form-group">
							<label for="inputEmail"><?php echo __('Email')?></label>
							<input class="col-sm-12 form-control" id="inputEmail" name="mail" placeholder="tu dirección de email" type="email">
						</div>
						<div class="form-group">
							<label><?php echo __('Reason')?></label>
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
							<label for="inputEmail"><?php echo __('Message')?></label>
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
	    <?php echo $this->element('sponsors'); ?>
	</div>
</div>