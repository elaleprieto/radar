<!DOCTYPE html>
<html>
	<head>
		<?php echo $this -> Html -> charset(); ?>
		<title> #RadarCultural :: <?php echo $title_for_layout; ?></title>
		<?php
            echo $this -> Html -> meta('icon');
            echo $this -> Html -> css(array( 'layouts/default','bootstrap.min', 'inicio', 'bootstrap-responsive.min'));
            echo $this -> fetch('meta');
            echo $this -> fetch('css');
		?>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body ng-app="RadarApp">
		<div id="container">
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
    					<ul class="nav">
                            <li><?= $this->Html->link( $this->Html->image("logoapaisado.png", array('alt'=>'logo')),'/', array('class'=>'menu_icono','style'=>'padding-top: 2px','escape' => false));?></li>
                            <li><?= $this->Html->link('Espacios', '/espacios', array('class'=>'menu')) ?></li>
                            <li><?= $this->Html->link('Eventos','/', array('class'=>'menu')) ?></li>
                            <li><?= $this->Html->link('Sobre radar', '/about', array('class'=>'menu')) ?></li>
                            <li><?= $this->Html->link('Contacto', '/contacto', array('class'=>'menu')) ?></li>
                        </ul>
                        <ul class="nav pull-right">
                            <?php if ($this->Session->read('Auth.User.name') != ''): ?>
                                <li><a> 
                                    <span class="username navbar-text">
                                       <?php echo $this->Session->read('Auth.User.name') ?>
                                    </span></a>
                                </li>
                                <li class="active">
                                    <?php echo $this->Html->link('Salir', array('controller'=>'users'
                                        , 'action'=>'logout'), array('class'=>'menu'))
                                    ?>
                                </li>
    					    <?php else: ?>
                                
                                <li>
                                    <?php echo $this->Html->link('Ingresar', array('controller'=>'users'
                                            , 'action'=>'login'),  array('class'=>'menu'))
                                    ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('¡Registrate!', '/registrate', array('class'=>'menu'))
                                        ?>
                                </li>
    					    <?php endif ?>
                        </ul>
					</div>
				</div>
			</div>
			<div id="header"></div>
			<div class="container">
				<?php echo $this -> Session -> flash(); ?>
				<?php echo $this -> fetch('content'); ?>
			</div>
			<div id="footer"></div>
		</div>
		<?php echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'
			, 'https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js'
			, 'vendors/bootstrap.min'
			)
		)
		?>
		<?php echo $this->fetch('script')
		?>
		<?php echo $this -> element('sql_dump'); ?>
		
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-27799433-2']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</body>
</html>
