<?php
# CSS
echo $this -> Html -> css(array('users/login'), null, array('inline' => FALSE));
# JavaScript
echo $this -> Html -> script(array('login'), array('inline' => FALSE));
?>
<div class="row">
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
    		<div class="col-sm-6">
    			<h1 class="titulo">Bienvenidos</h1>
				<?php echo $this->Form->create('User') ?>
					<div class="form-group">
						<?php
							echo $this->Form->label('username', 'Usuario');
							echo $this->Form->input('username', array('class'=>'col-sm-12 form-control','label'=>FALSE, 'placehorlder'=>'Usuario'));
						?>	
					</div>
					<div class="form-group">
						<?php	
							echo $this->Form->label('password', 'Contraseña');
							echo $this->Form->input('password', array('class'=>'col-sm-12 form-control','label'=>FALSE, 'placehorlder'=>'Contraseña'));
						?>
					</div>
					<br>
						<button type="submit" class="btn btn-verde">Entrar</button>
						<!--<button type="reset" class="btn span3">Borrar	</button>-->
						<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'btn btn-warning')) ?>
						
						<div class="btn btn-facebook col-sm">
							<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream', 'class'=>'col-sm')); ?>
						</div>
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
<br />
