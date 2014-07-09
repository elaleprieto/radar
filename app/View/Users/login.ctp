<?php
# CSS
echo $this -> Html -> css(array('users/login'), null, array('inline' => FALSE));
# JavaScript
//echo $this -> Html -> script(array('login'), array('inline' => FALSE));
?>
<div class="row">
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
    			<h1 class="titulo"><?php echo __('Welcome')?></h1>
			</div>
    		<div class="col-sm-5 col-sm-offset-3" >
				<?php echo $this->Form->create('User') ?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
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
							<div class="col-sm-12">
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
						
						<div class="col-sm-8 form-group">
							<!-- Botón Login -->
							<button type="submit" class="btn btn-verde col-sm-12 "><?php echo __('Login'); ?></button>
						</div>
						<div class="col-sm-4">
				
							<div>
								<div>
									
									<!-- Botón Facebook -->
									<div class="btn btn-facebook col-sm-6">
										<?php 
										echo $this->Facebook->login(array('perms' => 'email,publish_stream'));
										?>
									</div>
								</div>
								<div>
									<!-- Botón Twitter -->
									<div class="btn btn-twitter col-sm-6">
									<a href="/users/loginTwitter" >
										t
									</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
							<!-- Botón Registrate -->
							<?php 
							echo $this->Html->link(__('Register!')
								, '/registrate', array('class'=>'btn btn-warning col-sm-12')
							);
							?>
						</div>
				</form>
				
			</div>
			
		</div>
	</div>
	
	<!-- SPONSOR -->
	<div class="col-sm-3">
	    <?php echo $this->element('sponsors'); ?>
	</div>
	
</div>
