<?php
# CSS
echo $this -> Html -> css(array('users/login'), null, array('inline' => FALSE));

# JavaScript
echo $this -> Html -> script(array('login'), array('inline' => FALSE));
?>
<div class="row">
	<div class="offset3 span8">
		<h1><small>Bienvenido a</small></h1>
		<h1>Radar Cultural</h1>
		<hr />
		<?php echo $this->Form->create('User', array('class'=>'form-horizontal')) ?>
			<div class="control-group">
				<?php
				echo $this->Form->label('username', 'Usuario', array('class'=>'control-label'));
				echo $this->Form->input('username', array('div'=>'controls', 'label'=>FALSE, 'placehorlder'=>'Usuario'))
				?>
			</div>
			<div class="control-group">
				<?php
				echo $this->Form->label('password', 'Contraseña', array('class'=>'control-label'));
				echo $this->Form->input('password', array('div'=>'controls', 'label'=>FALSE, 'placehorlder'=>'Contraseña'))
				?>
			</div>
			<div class="control-group">
				<div class="controls">
					<!-- <label class="checkbox">
						<input type="checkbox">
						Recordarme
					</label> -->
					<button type="submit" class="btn btn-verde">
						Entrar
					</button>
					<button type="reset" class="btn">
						Borrar
					</button>
					<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'btn')) ?>
				</div>
			</div>
		</form>
	</div>
</div>
<br />
