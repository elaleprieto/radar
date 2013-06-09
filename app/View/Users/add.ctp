<?php echo $this -> Html -> css(array('users/add'), null, array('inline' => FALSE)) ?>

<div class="row">
    <div class="span12">
        <?php echo $this -> Form -> create('User'); ?>
        	<fieldset>
        		<legend><?php echo __('Add User'); ?></legend>
            	<?php
                    echo $this -> Form -> input('username', array(
                        'class' => 'span6',
                        'label' => __('Username'),
                        'required' => 'required'
                    ));
                    echo $this -> Form -> input('password', array(
                        'class' => 'span6',
                        'label' => __('Password'),
                        'required' => 'required'
                    ));
                    echo $this -> Form -> input('name', array(
                        'class' => 'span6',
                        'label' => __('Name'),
                        'required' => 'required'
                    ));
                    echo $this -> Form -> input('email', array(
                        'class' => 'span6',
                        'label' => __('Email'),
                        'required' => 'required'
                    ));
                ?>    
                
                <div class="row">
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
        	</fieldset>
        <?php echo $this -> Form -> end(__('Submit')); ?>
    </div>
</div>