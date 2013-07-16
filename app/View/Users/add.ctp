<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>

<div class="row">
    <div class="span12">
    	<div class="row-fluid">
    		<div class="span2 offset1">
    			<br><br><br><br><div class="resaltado"><h1>BIEN<br>VENI<br>DXS</h1></div>
    		</div>
    		<div class="span9">
    			<br><br>
    			<?php echo $this -> Form -> create('User'); ?>
		        	<fieldset>
		        		<div class="row-fluid">
		        		<legend><?php echo __('Registrate'); ?></legend>
		            	<?php
		                    echo $this -> Form -> input('username', array(
		                        'class' => 'span4',
		                        'label' => __('Username'),
		                        'required' => 'required'
		                    ));
		                    echo $this -> Form -> input('password', array(
		                        'class' => 'span4',
		                        'label' => __('Password'),
		                        'required' => 'required'
		                    ));
		                    echo $this -> Form -> input('name', array(
		                        'class' => 'span4',
		                        'label' => __('Name'),
		                        'required' => 'required'
		                    ));
		                    echo $this -> Form -> input('email', array(
		                        'class' => 'span4',
		                        'label' => __('Email'),
		                        'required' => 'required'
		                    ));
		                ?>    
		                </div>
		                <div class="row-fluid">
		                    <div class="gender span12">
		                    	<?php
		                            $options = array(
		                                '1' => __('Female'),
		                                '2' => __('Male'),
		                                '3' => __('Other')
		                            );
		                            echo $this -> Form -> radio('gender', $options, array(
		                                'legend' => false
		                            ));
		                    	?>
		                    </div>
		                </div>
		        	<div class="row-fluid">
		        <?php 
		        	$options = array('label' => __('Submit'),'class' => 'btn btn-verde');
					echo $this -> Form -> end($options);
		        ?>	
		        </div>
		        </fieldset>
    		</div>
    	</div>
    </div>
</div>