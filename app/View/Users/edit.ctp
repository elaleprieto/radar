<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>
<div class="row">
    <div class="col-sm-10">
    	<div class="row">
    		<div class="col-sm-4 whipala">
    			<?php echo $this->Html->image('whipalaRadar.png', array('class' => 'whipala')); ?>
			</div>
    		<div class="col-sm-6">
    			<?php echo $this -> Form -> create('User'); ?>
		        <fieldset>
		        	<h1 class="titulo"><?php echo __('Edit User'); ?></h1>
		        	<?php
		            	// echo $this -> Form -> input('username', array('class' => 'col-sm-12 form-group form-control'
		            		// , 'label' => __('Username')
		            		// , 'required' => 'required'
		                // ));
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


<!-- <div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div> -->
<!-- <div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div> -->
