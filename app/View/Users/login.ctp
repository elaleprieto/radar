<?php
# CSS
echo $this -> Html -> css(array('users/login'), null, array('inline' => FALSE));
# JavaScript
echo $this -> Html -> script(array('login'), array('inline' => FALSE));
?>
<div class="row">
	<div class="span10">
		<div class="row-fluid">
			<div class="span4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
    		<div class="span6">
    			<h1 class="titulo">Bienvenidos</h1>
				<?php echo $this->Form->create('User') ?>
					<?php
						echo $this->Form->label('username', 'Usuario');
						echo $this->Form->input('username', array('class'=>'span12','label'=>FALSE, 'placehorlder'=>'Usuario'));
						echo $this->Form->label('password', 'Contraseña');
						echo $this->Form->input('password', array('class'=>'span12','label'=>FALSE, 'placehorlder'=>'Contraseña'));
					?>
					<br>
					<div class="row-fluid">
						<button type="submit" class="btn btn-verde span6">Entrar</button>
						<!--<button type="reset" class="btn span3">Borrar	</button>-->
						<?php echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'btn span6')) ?>
					</div>		
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
<br />
