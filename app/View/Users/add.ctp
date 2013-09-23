<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>
<div class="row">
    <div class="col-sm-10">
    	<div class="row">
    		<div class="col-sm-4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
    		<div class="col-sm-6">
    			<?php echo $this -> Form -> create('User'); ?>
		        <fieldset>
		        	<h1 class="titulo" >REGISTRO</h1>
		        	<?php
		            	echo $this -> Form -> input('username', array(
		                	'class' => 'col-sm-12 form-group form-control',
		                    'label' => __('Username'),
		                    'required' => 'required'
		                ));
		                echo $this -> Form -> input('password', array(
		                    'class' => 'col-sm-12 form-group form-control',
		                    'label' => __('Password'),
		                    'required' => 'required'
		                ));
		                echo $this -> Form -> input('name', array(
		                    'class' => 'col-sm-12 form-group form-control',
		                    'label' => __('Name'),
		                    'required' => 'required'
		               	));
		                echo $this -> Form -> input('email', array(
		                    'class' => 'col-sm-12 form-group form-control',
		                    'label' => __('Email'),
		                    'required' => 'required'
		                ));
		            ?>    
		            <div class="row-fluid">
		            	<div class="gender col-sm-12 form-group">
		                	<?php
		                    	$options = array(
		                        	'1' => __('Female'),
		                            '2' => __('Male'),
		                            '3' => __('Other')
		                        );
		                        echo $this -> Form -> radio('gender', $options, array(
		                        	'legend' => false,
		                        ));
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
	<div class="col-sm-2">
	    <div class="col-sm-12">
	    	  <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/santafedisenia.jpg');?></a>
	    </div>
	    <div class="col-sm-12">
	    	    <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/tallercandombe.jpg');?></a>
	    </div>
	</div>
</div>
</div>