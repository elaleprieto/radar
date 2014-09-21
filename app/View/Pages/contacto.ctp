<?php echo $this->Html->css(array( 'pages/contact'), '', array('inline'=>false)) ?>

<div class="row">
	<div class="col-sm-10">
		<div class="row contacto">
			<div class="col-sm-7 col-sm-offset-3">
				<!-- <form method="post" action="enviar.php" role="form"> -->
				<?php echo $this->Form->create('User', array('action' => 'contactar')); ?>
					<fieldset>
						<h1 class="titulo"><?php echo __('Contact us')?></h1>
						<div class="form-group">
							<label for="nombre"><?php echo __('Name')?></label>
							<input class="col-sm-12 form-control" id="nombre" name="nombre" placeholder="tu nombre" type="text">
						</div>
						<div class="form-group">
							<label for="apellido"><?php echo __('Surname')?></label>
							<input class="col-sm-12 form-control" id="apellido" name="apellido" placeholder="tu apellido" type="text">
						</div>
						<div class="form-group">
							<label for="email"><?php echo __('Email')?></label>
							<input class="col-sm-12 form-control" id="email" name="mail" placeholder="tu dirección de email" type="email">
						</div>
						<div class="form-group">
							<label><?php echo __('Reason')?></label>
							<label class="radio-inline">
								<input type="radio" name="asunto" value="consulta" checked>consulta
							</label>
							<label class="radio-inline">
								<input type="radio" name="asunto" value="sugerencia">sugerencia
							</label>
							<label class="radio-inline">
								<input type="radio" name="asunto" value="problema">problema
							</label>
						</div>
						<div class="form-group">
							<label for="mensaje"><?php echo __('Message')?></label>
							<textarea id="mensaje" class="col-sm-12 form-control" rows="8" placeholder="Dejanos tu consulta" name="mensaje"></textarea>
						</div>
						<button type="submit" class="btn btn-verde btn-block" name="enviar">Enviar</button>
					</fieldset>
				<!-- </form> -->
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<!-- SPONSOR -->
	<div class="col-sm-2">
	    <?php echo $this->element('sponsors'); ?>
	</div>
</div>
