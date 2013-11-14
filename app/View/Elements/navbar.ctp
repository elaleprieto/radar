<!-- LOGO -->
<div id="logo">
	<?php echo $this->Html->link($this->Html->image("logo_blanco.png", array('alt' => 'logo')), '/', array('escape' => false)); ?>
</div>

<div x-ng-cloak>
	<!-- Rampa irregular del logo -->
	<div id="rampa"></div>
	
	<!-- Menú Superior -->
	<nav class="navbar navbar-inverse" role="navigation">
		
		<!-- Vista para dispositivos sm y xs -->
		<div class="visible-sm visible-xs hidden-md hidden-lg">
			<div class="navbar-collapse collapse col-xs-12">
				<ul class="nav navbar-nav menu-centro">
					<li class="<?php echo ($this->request->controller == 'events' && $this->request->action == 'index') ? 'active' : '' ?>">
						<a href="/"><span class="glyphicon glyphicon-calendar"></span></a>
					</li>
					<li class="<?php echo ($this->request->controller == 'places' && $this->request->action == 'index') ? 'active' : '' ?>">
						<a href="/places"><span class="glyphicon glyphicon-map-marker"></span></a>
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
							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="/admin/places/add">
										<?php echo __('Add Place'); ?>
									</a>
								</li>
							</ul>
						</li>
					<?php endif; ?>
					
					<li>
						<a href="/events/add">
							<button class="btn btn-warning btn-xs pull-right"><?php echo __('RADEA!'); ?></button>
						</a>
					</li>
				</ul>
				
				<!-- Nav right -->
				<ul class="nav navbar-nav navbar-right">
					
					<!-- Zoom -->
					<?php
					# Si el usuario se encuenta en events/index ó en places/index se habilitan los botones de zoom 
					if(($this->request->controller == 'events' && $this->request->action == 'index') 
						|| ($this->request->controller == 'places' && $this->request->action == 'index')):
					?>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
								<span class="fa fa-search-plus"></span>
							</a>
						</li>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
								<span class="fa fa-search-minus"></span>
							</a>
						</li>
					<?php endif; ?>
					
					<li><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
					<li><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li> 
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
						<li>
							<a href="/users/edit/<?php echo AuthComponent::user('id'); ?>"> 
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
				</ul>
			</div>
		</div>


		<!-- Vista para dispositivos md y lg -->
		<div class="navbar-collapse collapse navbar-radar-collapse visible-md visible-lg hidden-sm hidden-xs">
			<ul class="nav navbar-nav menu-centro">
				<li class="<?php echo ($this->request->controller == 'events' && $this->request->action == 'index') ? 'active' : '' ?>">
					<a href="/">
						<span class="glyphicon glyphicon-calendar"></span>
						<?php echo __('Events'); ?> 
					</a>
				</li>
				<li class="<?php echo ($this->request->controller == 'places' && $this->request->action == 'index') ? 'active' : '' ?>">
					<a href="/places"><span class="glyphicon glyphicon-map-marker"></span>
						<?php echo __('Places'); ?>	
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
					<a href="/events/add" id="btn-radea">
						<button class="btn btn-warning pull-right">
							<?php echo __('RADEAR MY EVENTS!'); ?>
						</button>
						<!-- <span class="btn btn-warning label">
							<?php echo __('RADEAR MY EVENTS!'); ?>
						</span> -->
					</a>
				</li>
			</ul>
			
			<!-- Nav right -->
			<ul class="nav navbar-nav navbar-right">
				
				<!-- Zoom -->
				<?php
				# Si el usuario se encuenta en events/index ó en places/index se habilitan los botones de zoom 
				if(($this->request->controller == 'events' && $this->request->action == 'index') 
					|| ($this->request->controller == 'places' && $this->request->action == 'index')):
				?>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() + 1)">
								<span class="fa fa-search-plus"></span>
							</a>
						</li>
						<li class="zoom-button">
							<a href="#" x-ng-click="map.setZoom(map.getZoom() - 1)">
								<span class="fa fa-search-minus"></span>
							</a>
						</li>
						<li>
							<a href="#">|</a>
						</li>
				<?php endif; ?>				
				
				<li><a href="/about"><i class="fa fa-info-circle fa-lg"></i></a></li>
				<li><a href="/contacto"><i class="fa fa-envelope fa-lg"></i></a></li>
				<li><a>|</a></li>
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
						<?php echo $this->Html->link(__('Sign up!'), '/registrate', array('class' => 'menu_superior_derecha')); ?>
					</li>
				<?php endif; ?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>
</div>