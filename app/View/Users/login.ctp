<?php
# CSS
echo $this -> Html -> css(array('users/login'), null, array('inline' => FALSE));
# JavaScript
//echo $this -> Html -> script(array('login'), array('inline' => FALSE));
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
						<div class="row">
							<div class="col-sm-11">
								<?php
									echo $this->Form->label('username', __('User'));
									echo $this->Form->input('username'
										, array('class' => 'col-sm-12 form-control'
											, 'label' => FALSE
											, 'placehorlder' => __('User')
										)
									);
								?>	
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-11">
								<?php	
									echo $this->Form->label('password', __('Password'));
									echo $this->Form->input('password'
										, array('class'=>'col-sm-12 form-control'
											, 'div' => false
											,'label' => FALSE
											, 'placehorlder' => __('Password')
										)
									);
								?>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-5">
							<!-- Botón Login -->
							<button type="submit" class="btn btn-verde col-sm-12 "><?php echo __('Login'); ?></button>
						</div>
						<div class="col-sm-5 col-sm-offset-1">
							<!-- Botón Registrate -->
							<?php 
							echo $this->Html->link(__('Register!')
								, '/registrate', array('class'=>'btn btn-warning col-sm-12')
							);
							?>
						</div>
					</div>
						
						<br />
					<div class="row">
						<div class="col-sm-5">
							
							<!-- Botón Facebook -->
							<div class="btn btn-facebook col-sm-12">
								<?php 
								echo $this->Facebook->login(array('perms' => 'email,publish_stream'));
								?>
							</div>
						</div>
						<div class="col-sm-5 col-sm-offset-1">
							<!-- Botón Twitter -->
							<a href="/users/loginTwitter" class="btn btn-info col-sm-12">
								<?php echo __('Login with Twitter'); ?>
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- SPONSOR -->
	<div class="col-sm-2">
	    <?php echo $this->element('sponsors'); ?>
	</div>

</div>
