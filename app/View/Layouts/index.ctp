<!DOCTYPE html>
<!--<html>-->
<?php echo $this->Facebook->html(); ?>
	<head>
		<?php echo $this -> Html -> charset(); ?>
		<title> #RadarCultural :: <?php echo $title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
            echo $this -> Html -> meta('icon');
            echo $this -> Html -> css(array( 'bootstrap.min','layouts/default',  'inicio', /*'bootstrap-responsive.min'*/));
            echo $this -> fetch('meta');
            echo $this -> fetch('css');
		?>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body ng-app="RadarApp">
		
			<div id="header"></div>
				<?php echo $this -> Session -> flash(); ?>
				<?php echo $this -> fetch('content'); ?>
			<div id="footer"></div>
		
		<!-- Scripts -->
		<?php echo $this->Html->script(array('//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'
			, '//ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js'
			, 'vendors/bootstrap.min'
			, 'vendors/jquery.cookie'
			)
		)
		?>
		<?php echo $this->fetch('script')?>
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
		
		<!-- Plugin Facebook-->
		<?php echo $this->Facebook->init(); ?>

		<!-- SQL Dump -->
		<?php echo $this -> element('sql_dump'); ?>	
	</body>
</html>
