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
						echo $this->Form->label('username', __('User'));
						echo $this->Form->input('username'
							, array('class'=>'span12','label'=>FALSE, 'placehorlder'=>__('User'))
						);
						echo $this->Form->label('password', __('Password'));
						echo $this->Form->input('password'
							, array('class'=>'span12','label'=>FALSE, 'placehorlder'=>__('Password'))
						);
					?>
					<br>
					<div class="row-fluid">
						<button type="submit" class="btn btn-verde span6"><?php echo __('Login'); ?></button>
						<!--<button type="reset" class="btn span3">Borrar	</button>-->
						<?php echo $this->Html->link(__('Register!'), '/registrate', array('class'=>'btn span6')) ?>
					</div>
				</form>
				<div class="row-fluid">
					<div class="btn btn-facebook span6">
						<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream', 'class'=>'span6')); ?>
					</div>
					<div class="btn btn-info span6">
						<a href="/users/loginTwitter"><?php echo __('Login with Twitter'); ?></a>
					</div>
				</div>
				<br />
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
