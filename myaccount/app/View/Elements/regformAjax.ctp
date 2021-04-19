<div id="reg_panel3" style="display: none;">
    <div id="form_content">
        <div id="log_form">
            <label id="close_btn">
                <a href="javascript:void(0);"><img src="<?php echo $this->base?>/images/icons/inactive.png" /></a>
            </label>
            <div id="form_header">
                <img src="<?php echo $this->base?>/images/gallery/itakicircle.png" />
                <label>SIGN <span>UP</span></label>
            </div>
            <br />
            <div id="form_content">
                <?php echo $this->Form->create('User', array('id' => 'signfrm', 'class' => 'signinAjax', 'action' => 'register')); ?> 	
                <label>Email Address:</label>
                <br />
                <?php echo $this->Form->input('username', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '3', "placeholder" => "email@example.com", "class" => "required email")); ?>
                <br />

                <label>Password:</label>
                <br />
                <?php echo $this->Form->input('password', array('label' => false, 'type' => 'password', 'div' => false, 'id' => 'password', 'tabindex' => '4', "placeholder" => "Password", "class" => "required")); ?>
                <br />
                
                <label>Company Name:</label>
                <br />
                <?php echo $this->Form->input('company', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '5', "placeholder" => "Company Name", "class" => "required")); ?>
                <br />

                <label>Firstname:</label>
                <br />
                <?php echo $this->Form->input('firstname', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '6', "placeholder" => "Firstname", "class" => "required")); ?>
                <br />

                <label>Lastname:</label>
                <br />
                <?php echo $this->Form->input('lastname', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '7', "placeholder" => "Lastname", "class" => "required")); ?>
                <br />
                
                <label>Phonenumber:</label>
                <br />
                <?php echo $this->Form->input('phonenumber', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '8', "placeholder" => "Phonenumber", "class" => "required phone")); ?>
                <br />

                <button type="submit" id="main_btn" style="font-size: 20px; padding: 5px 20px;">Sign Up</button>
                <?php echo $this->Form->end(); ?>
                <label style="color: #777; float: right; margin: -28px 53px;">Already registered? <a href="javascript:void(0);" id="showAjaxLoginForm">SIGN IN</a></label>
            </div>            
        </div>
    </div>
</div>