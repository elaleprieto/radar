<!DOCTYPE html>
<!--<html>-->
<?php echo $this->Facebook->html(); ?>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title> #RadarCultural </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css(array(
				'bootstrap.min',
				'//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
				'events/index',
				'inicio',
				'layouts/default',
			));
			echo $this->fetch('meta');
			echo $this->fetch('css');
		?>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body ng-app="RadarApp">
		
		<!-- Navbar -->
		<?php 
		// if (AuthComponent::user('role') == 'admin'):
		// $rol = AuthComponent::user('Rol');
		if(isset($userData) && isset($userData['Rol'])):
			$rol = $userData['Rol'];
			if ($rol['weight'] == USER::ADMIN):	
				echo $this->element('navbar_admin'); 
			elseif ($rol['weight'] == USER::PLACELOADER):
				echo $this->element('navbar_placeloader'); 
			else:
				echo $this->element('navbar');
			endif;
		else:
			echo $this->element('navbar');
		endif;
		?>

		<?php echo $this->Session->flash('flash', array('element' => 'failure')); ?>

		<div id="container">
			<div class="container">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<?php
			echo $this->element('scripts');
			echo $this->fetch('script');
		?>
		
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-27799433-2']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();
		</script>
		<!-- Plugin Facebook-->
		<?php echo $this->Facebook->init(); ?>

		<?php echo $this->element('sql_dump'); ?>	

	</body>
</html>
