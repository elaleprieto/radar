<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>
<div class="row">
    <div class="col-sm-9">
    	<div class="row">
    		<div class="col-sm-7 col-sm-offset-3">
    			<?php echo $this -> Form -> create('User'); ?>
		        <fieldset>
		        	<h1 class="titulo"><?php echo __('Registration')?></h1>
		        	<?php
		            	echo $this -> Form -> input('username', array('class' => 'col-sm-12 form-group form-control'
		            		, 'label' => __('Username')
		            		, 'required' => 'required'
		                ));
		                echo $this -> Form -> input('password', array('class' => 'col-sm-12 form-group form-control'
		                	, 'label' => __('Password')
		                	, 'required' => 'required'
		                ));
		                echo $this -> Form -> input('name', array('class' => 'col-sm-12 form-group form-control'
		                	, 'label' => __('Name')
		                	, 'placeholder' => __('Your Name')
		                    , 'required' => 'required'
		               	));
		                echo $this -> Form -> input('email', array('class' => 'col-sm-12 form-group form-control'
		                	, 'label' => __('Email')
		                	, 'placeholder' => __('example@example.com')
		                    , 'required' => 'required'
		                ));
		                echo $this -> Form -> input('location', array('class' => 'col-sm-12 form-group form-control'
		                	, 'label' => __('Your Location')
		                	, 'placeholder' => __('Example: Rome, Italy or Barcelona, Spain.')
		                	, 'required' => 'required'
		                ));
		            ?>    
		            <div class="row-fluid">
		            	<div class="gender col-sm-12 form-group">
		                	<?php
		                    	$options = array('1' => __('Female'), '2' => __('Male'), '3' => __('Other'));
		                        echo $this -> Form -> radio('gender', $options, array('legend' => false ));
		                   	?>
		                </div>
					</div>
					<div class="row-fluid">
		            	<div class="col-sm-12 form-group">
		                	<?php
							# Se carga la librería del catpcha
							// require_once('recaptchalib.php');
							App::import('Vendor', 'recaptchalib', array('file' => 'recaptchalib.php'));
							
							// $publickey = "your_public_key"; // you got this from the signup page
							$publickey = "6LeWP-8SAAAAAMIaV0hZZai_g88inVru8I9wDQTf"; // you got this from the signup page
							
							echo recaptcha_get_html($publickey);
							?>
		                </div>
					</div>
					<br>
		        	<div class="row">
		        		<?php 
		        			$options = array('label' => __('Submit'),'class' => 'btn btn-verde btn-block btn-lg');
							echo $this -> Form -> end($options);
		        		?>	
		        	</div>
		        	<!--<div class="row-fluid">
						<?php 
							echo $this->Facebook->registration(array(
  														'fields' => 'name,email,location',
  														'width' => '500'
														));
						?>
		        	</div>-->
		        </fieldset>
    		</div>
    	</div>
    </div>
    <!-- SPONSOR -->
	<div class="col-sm-3">
	    <?php echo $this->element('sponsors'); ?>
	</div>
</div>