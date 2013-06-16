<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		#RadarCultural :: <?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('bootstrap.min', 'radar', 'bootstrap-responsive.min'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		
	?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
</head>
<body>
	<div id="container">
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
				    <ul class="nav">
    				    <li><?= $this->Html->image('logoCulturaLibre.png', array('class' => 'menu'))?></li>
                        <li><?= $this->Html->link('Radar<br><strong>CULTURAL</strong>', '/', array('class'=>'menu-brand', 'escape'=>FALSE)) ?></li>
                        <li><?= $this->Html->link('Sobre Radar', '/', array('class'=>'menu')) ?></li>
                        <li><?= $this->Html->link('Espacios', '/', array('class'=>'menu')) ?></li>
                        <li><?= $this->Html->link('Eventos', '/', array('class'=>'menu')) ?></li>
                        <li><?= $this->Html->link('Contacto', '/', array('class'=>'menu')) ?></li>    
				    </ul>
                    <?= $this->Html->link('Agregar evento', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-warning pull-right')) ?>
				</div>
			</div>
		</div>
		<div id="header">
		</div>
		<div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	
	<?php echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js', 'bootstrap.min')) ?>
	<?php echo $this->fetch('script') ?>
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
