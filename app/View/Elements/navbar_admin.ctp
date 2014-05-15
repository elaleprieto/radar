<!-- LOGO -->
<div id="logo">
	<?php echo $this->Html->link($this->Html->image("logo_blanco.png", array('alt' => 'logo')), '/', array('escape' => false)); ?>
</div>

<div x-ng-cloak>
	<!-- Rampa irregular del logo -->
	<div id="rampa" class="navbar-fixed-top"></div>
	
	<!-- Menú Superior -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

		<div class="navbar-collapse collapse navbar-radar-collapse">
			<ul class="nav navbar-nav menu-centro">
				
				<!-- Events -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">
						<span class="glyphicon glyphicon-calendar"></span>
						<?php echo __('Events'); ?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="<?php echo __('/events').__('/add'); ?>">
								<?php echo __('Add Event'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo __('/admin').__('/events').__('/resume'); ?>">
								<?php echo __('List Events'); ?>
							</a>
						</li>
					</ul>
				</li>

				<!-- Places -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">
						<span class="glyphicon glyphicon-map-marker"></span>
						<?php echo __('Places'); ?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="/admin<?php echo __('/places').__('/add'); ?>">
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

				<!-- Gestión de Usuarios -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">
						<span class="glyphicon glyphicon-user"></span>
						<?php echo __('Users'); ?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="<?php echo __('/users').__('/add'); ?>">
								<?php echo __('Add User'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo __('/users'); ?>">
								<?php echo __('List Users'); ?>
							</a>
						</li>
					</ul>
				</li>

				<!-- Gestión de Denuncias -->
				<li class="<?php echo ($this->request->controller == 'compliants' && $this->request->action == 'index') ? 'active' : '' ?>">
					<!-- Botón con texto para vista lg y md -->
					<a href="<?php echo __('/admin').__('/compliants'); ?>" class="visible-md visible-lg hidden-xs hidden-sm">
						<span class="glyphicon glyphicon-bullhorn"></span>
						<?php echo __('Compliants'); ?>	
					</a>
					<!-- Botón sin texto para vista sm y xs -->
					<a href="<?php echo __('/admin').__('/compliants'); ?>" class="hidden-md hidden-lg visible-xs visible-sm">
						<span class="glyphicon glyphicon-bullhorn"></span>	
					</a>
				</li>
				
			</ul>
			
			<!-- Nav right -->
			<ul class="nav navbar-nav navbar-right">
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
						<?php echo $this->Html->link(__('Sign up!'), __('/singup'), array('class' => 'menu_superior_derecha')); ?>
					</li>
				<?php endif; ?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>
</div>