<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>
<div class="row">
    <div class="span10">
    	<div class="row-fluid">
    		<div class="span4 whipala">
				<img src="img/whipalaRadar.png" class="whipala">
			</div>
    		<div class="span6">
    			<?php echo $this -> Form -> create('User'); ?>
		        <fieldset>
		        	<h1 class="titulo" >REGISTRO</h1>
		        	<?php
		            	echo $this -> Form -> input('username', array(
		                	'class' => 'span12',
		                    'label' => __('Username'),
		                    'required' => 'required'
		                ));
		                echo $this -> Form -> input('password', array(
		                    'class' => 'span12',
		                    'label' => __('Password'),
		                    'required' => 'required'
		                ));
		                echo $this -> Form -> input('name', array(
		                    'class' => 'span12',
		                    'label' => __('Name'),
		                    'required' => 'required'
		               	));
		                echo $this -> Form -> input('email', array(
		                    'class' => 'span12',
		                    'label' => __('Email'),
		                    'required' => 'required'
		                ));
		            ?>    
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
					<br>
		        	<div class="row-fluid">
		        		<?php 
		        			$options = array('label' => __('Submit'),'class' => 'btn btn-verde btn-block');
							echo $this -> Form -> end($options);
		        		?>	
		        	</div>
		        </fieldset>
    		</div>
    	</div>
    </div>
<!-- SPONSOR -->
	<div class="span2">
	    <ul class="thumbnails">
            <li class="span2">
                <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/santafedisenia.jpg');?></a>
            </li>
            <li class="span2">
                <a href="#" class="thumbnail"><?=$this->Html->image('sponsor/tallercandombe.jpg');?></a>
            </li>
        </ul>
	</div>
</div>