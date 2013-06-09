<?php
    /**
     *
     * PHP 5
     *
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright 2005-2012, Cake Software Foundation, Inc.
     * (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc.
     * (http://cakefoundation.org)
     * @link          http://cakephp.org CakePHP(tm) Project
     * @package       Cake.View.Layouts
     * @since         CakePHP(tm) v 0.10.0.1076
     * @license       MIT License
     * (http://www.opensource.org/licenses/mit-license.php)
     */
?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo $this -> Html -> charset(); ?>
		<title> #RadarCultural :: <?php echo $title_for_layout; ?></title>
		<?php
            echo $this -> Html -> meta('icon');

            echo $this -> Html -> css(array('bootstrap.min', 'layouts/default', 'bootstrap-responsive.min'));

            echo $this -> fetch('meta');
            echo $this -> fetch('css');
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
						<?= $this -> Html -> link('Radar<strong>Cultural</strong>', '/', array(
                            'class' => 'brand',
                            'escape' => FALSE
                        ))
						?>
						    <ul class="nav nav-pills pull-right">
						        <li>
                                    <?php echo $this -> Html -> link('Agregar evento', array('controller' => 'events'
                                        , 'action' => 'add'))
                                    ?>
                                </li>
                                <li class="divider-vertical"></li>
    						    <?php if ($this->Session->read('Auth.User.name') != ''): ?>
                                    <li>
                                        <span class="username navbar-text">
                                            <?php echo $this->Session->read('Auth.User.name') ?>
                                        </span>
                                    </li>
                                    <li class="active">
                                        <?php echo $this->Html->link('Salir', array('controller'=>'users'
                                            , 'action'=>'logout'))
                                        ?>
                                    </li>
    					        <?php else: ?>
                                    <li>
                                        <?php echo $this->Html->link('Ingresar', array('controller'=>'users'
                                            , 'action'=>'login'))
                                        ?>
                                    </li>
                                    <li class="divider-vertical"></li>
                                    <li>
                                        <?php echo $this->Html->link('¡Registrate!', '/registrate')
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

		<?php echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js', 'bootstrap.min'))
		?>
		<?php echo $this->fetch('script')
		?>

		<?php echo $this -> element('sql_dump'); ?>
	</body>
</html>
