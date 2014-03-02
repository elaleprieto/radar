<!-- LOGO -->
<div id="logo" class="hidden-xs">
	<?php echo $this->Html->link($this->Html->image("logo_blanco.png", array('alt' => 'logo', 'class'=>'hidden-xs')), '/', array('escape' => false)); ?>
	<!--<?php echo $this->Html->link($this->Html->image("radar_xs.png", array('alt' => 'logo', 'class'=>'visible-xs')), '/', array('escape' => false)); ?>-->
	
</div>
<!--<h2 class="visible-xs radar-xs">RADAR cultural</h2>-->
<?php echo $this->Html->link($this->Html->image("logo_horizontal.png", array('alt' => 'logo', 'class'=>'visible-xs img-responsive radar-xs')), '/', array('escape' => false)); ?>
<div x-ng-cloak>
	<!-- Rampa irregular del logo -->
	<div id="rampa" class="navbar-fixed-top hidden-xs"></div>
	
	<!-- Menú Superior -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-radar" data-toggle="collapse" data-target="#navbar-collapse-radar">
				<!--
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
		    	<span class="icon-bar"></span>-->
	    		<?php echo $this->Html->link($this->Html->image("logo_xs.png", array('alt' => 'logo', 'class'=>'visible-xs')), '/', array('escape' => false)); ?>

			</button>
			<?php echo $this->Html->link($this->Html->image("logo_sin.png", array('alt' => 'logo', 'class'=>'hidden-xs')), '/', array('escape' => false, 'class' =>'navbar-brand')); ?>

	</div>

		<div class="navbar-collapse collapse navbar-radar-collapse"  id="navbar-collapse-radar">
			
			<ul class="nav navbar-nav menu-center">
			
				<li class="<?php echo ($this->request->controller == 'events' && $this->request->action == 'index') ? 'active' : '' ?>">
					<!-- Botón con texto para vista lg y md -->
					<a href="/" class="visible-md visible-lg hidden-xs hidden-sm">
						<span class="glyphicon glyphicon-calendar"></span>
						<?php echo __('Events'); ?>
					</a>
					<!-- Botón sin texto para vista sm y xs -->
					<a href="/" class="hidden-md hidden-lg visible-xs visible-sm">
						<span class="glyphicon glyphicon-calendar"></span>
					</a>
				</li>
				<li class="<?php echo ($this->request->controller == 'places' && $this->request->action == 'index') ? 'active' : '' ?>">
					<!-- Botón con texto para vista lg y md -->
					<a href="/places" class="visible-md visible-lg hidden-xs hidden-sm">
						<span class="glyphicon glyphicon-map-marker"></span>
						<?php echo __('Places'); ?>	
					</a>
					<!-- Botón sin texto para vista sm y xs -->
					<a href="/places" class="hidden-md hidden-lg visible-xs visible-sm">
						<span class="glyphicon glyphicon-map-marker"></span>	
					</a>
				</li>
				
				<?php
				# Si el usuario es administrador se habilita el menú. 
				if ($this->Session->read('Auth.User.role') == 'admin'): 
				?>
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-caret-down"></i>
							<span class="sr-only">Toggle Dropdown</span>
						</a>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="/admin/places/add">
									<?php echo __('Add Place'); ?>
								</a>
							</li>
							<li>
								<a href="/admin/places/index">
									<?php echo __('List Places'); ?>
								</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				
				<li>	
					<a href="/events/add">
					<!--		<button class="btn btn-warning"><?php echo __('RADEAR MY EVENTS!'); ?></button>
					</a>
					<!--<a href="/events/add" id="btn-radea" >
						<!-- Botón para vista lg y md -->
					
						<button type="button" class="btn btn-warning btn-xs visible-md visible-lg hidden-xs hidden-sm">
							<?php echo __('RADEAR MY EVENTS!'); ?>
						</button>
					
						<!-- Botón para vista sm y xs -->
						<button type="button" class="btn btn-warning btn-xs visible-sm visible-xs hidden-md hidden-lg">
							<?php echo __('RADEA!'); ?>
						</button>
					
						<!-- <span class="btn btn-warning label">
							<?php echo __('RADEAR MY EVENTS!'); ?>
						</span> -->
				<!--	</a>
					<a  href="/events/add" id="btn-radea" class="btn btn-warning visible-xs visible-sm">
						¡Radear!-->
					</a>
				</li>
		</ul>
			
			<!-- Nav right -->
			<ul class="nav navbar-nav navbar-right">
			
				<li class="hidden-sm"><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
				<li class="hidden-sm"><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li>
				<li class="hidden-sm"><a class="visible-md visible-lg hidden-sm hidden-xs">|</a></li>
				<li class="hidden-sm">
					<a href="https://twitter.com/radardecultura" target="_blank">
						<i class="fa fa-twitter-square fa-lg"></i>
					</a>
				</li>
				<li class="hidden-sm">
					<a href="https://www.facebook.com/RadarDeCultura" target="_blank">
						<i class="fa fa-facebook-square fa-lg"></i>
					</a>
				</li>

				<?php if ($this->Session->read('Auth.User.name') != ''): ?>
					<li><a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
						<span><?php echo AuthComponent::user('name') ?> </span>
						</a>
					</li>
			 		 
					<!--<?php 
							// echo $this->Html->link(__('Logout'), array('controller'=>'users'
							//	, 'action'=>'logout'), array('class'=>'menu menu_derecha'))
						?>-->

					<!-- Logout de facebook -->
					<li>
						<?php echo $this->Facebook->logout(array(
							'label' => __('Logout'),
							'redirect' => array(
								'controller' => 'users',
								'action' => 'logout'
							),
						));
 						?>
 					</li>
				<?php else: ?>
					<li>
						<?php
							echo $this->Html->link(__('Login'), array(
								'controller' => 'users',
								'action' => 'login'
							), array('id' => 'menu_superior_derecha_verde'));
						?>
					</li>
					<li>
						<?php echo $this->Html->link(__('Sign up!'), '/registrate', array('class' => 'menu_superior_derecha')); ?>
					</li>
				<?php endif; ?>
				
				</li>
				
				<!-- Menú desplegable de más info. disponible para vista sm -->
				<li class="dropdown visible-sm visible-xs">
    				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
      					<small>más</small> <span class="caret"></span>
    				</a>
    				<ul class="dropdown-menu">
	      				<li><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
						<li><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li>
						<li><a class="visible-md visible-lg hidden-sm hidden-xs">|</a></li>
						<li>
							<a href="https://twitter.com/radardecultura" target="_blank">
								<i class="fa fa-twitter-square fa-lg"></i>
							</a>
						</li>
						<li>
							<a href="https://www.facebook.com/RadarDeCultura" target="_blank">
								<i class="fa fa-facebook-square fa-lg"></i>
							</a>
						</li>

    				</ul>
  				</li>
			</ul><!-- /.vista-sm-->
		</div><!-- /.navbar-collapse -->
	</nav>
</div>