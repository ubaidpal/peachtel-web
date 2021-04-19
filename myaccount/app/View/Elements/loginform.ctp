<?php
    $flash = $this->Session->flash();
    $flash2 = $this->Session->flash('Register');
    $data = $this->Session->flash('rawUserData');
    
    $display = (!empty($flash['Message']) && !is_array($flash['Message'])) ? "block" : "none";
    $show = !empty($data) ? "block" : "none";
    $overlay = ($show == 'block' || $display == "block") ? "block": "none";
    
    $username = '';
    $password = '';
    if(!empty($data)) {
        $username = $data['email'];
        $password = $data['password2'];
    }
?>

<div id="overlay" style="display: <?php echo $overlay; ?>"></div>
<div id="alert5" style="display: <?php echo $show; ?>; z-index: 9999; width: 300px; left: 40%; position: absolute; top: 20%;">
    <div style="color: #fff; padding: 10px; background: #222; border-radius: 5px 5px 0 0;">
        <h3><?php echo $flash2; ?></h3>
    </div>
    <div style="padding: 5px 10px;background: #fff;">
        <hr />
        <p style="padding: 5px 0">Click OK to close window.</p>
        <hr />
    </div>
    <div id="alertActions" style="padding: 10px 0 10px 0;background: #fff; text-align: center; border-radius: 0 0 5px 5px;">
        <button class="btn btn-small btn-primary regWindowClose" id="hide_alert2" style=" width: 250px; padding:10px;">OK</button>
    </div>
</div>

<div id="login_panel" style="display: <?php echo $display?>">
    <div id="form_content">
        <div id="log_form">
            <label id="close_btn">
                <a href="javascript:void(0);"><img src="<?php echo $this->base?>/images/icons/inactive.png" /></a>
            </label>
            <div id="form_header">
                <img src="<?php echo $this->base?>/images/gallery/itakicircle.png" />
                <label>SIGN <span>IN</span></label>
            </div>
            <br />
            <div id="form_content">
                <?php
                    if(!empty($flash['Message']) && !is_array($flash['Message']))
                        echo '<span style="color:red; padding: 3px 10px; margin-bottom: 10px; width: 90%; display: inline-block; background: #f8f6f3;"><img src="images/icons/info_8x16.png" style="display: inline-block;" />'.$flash.'</span>'; 
                ?>
                <?php echo $this->Form->create('User', array('id' => 'loginfrm', 'name' => 'loginForm', 'class' => 'form-login', 'action' => 'login')); ?> 	
                <?php echo $this->Form->input('redirect', array('type' => 'hidden')); ?>
                <label>Username:</label>
                <br />
                <?php echo $this->Form->input('username', array('label' => false, 'style' => 'width: 350px;', 'type' => 'text', 'div' => false, 'tabindex' => '1', "placeholder" => "email@example.com", "class" => "required")); ?>
                <br />

                <label>Password:</label>
                <br />
                <?php echo $this->Form->input('password', array('label' => false, 'style' => 'width: 350px;', 'type' => 'password', 'div' => false, 'id' => 'password', 'tabindex' => '2', "placeholder" => "Password", "class" => "required")); ?>
                <!---<label id="forgot_password"><a href="javascript:void(0);">Forgot your password?</a></label>
                <br />--><br />
                <button type="submit" id="main_btn" style="font-size: 20px; padding: 5px 20px;">Login</button>
                <?php echo $this->Form->end(); ?>
            </div>            
        </div>
        <div id="reg_form">
            <div id="form_header">
                <img src="images/gallery/itakicircle.png" />
                <label>SIGN <span>UP</span></label>
            </div>
            <br />
            <div id="form_content">
                <?php echo $this->Form->create('User', array('id' => 'signfrm', 'class' => 'form-signin', 'action' => 'register')); ?> 	
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
                <?php echo $this->Form->input('phonenumber', array('label' => false, 'type' => 'text', 'div' => false, 'tabindex' => '8', "placeholder" => "Phonenumber eg: +44-444-4444", "class" => "required phone")); ?>
                <br />

                <button type="submit" id="main_btn" style="font-size: 20px; padding: 5px 20px;">Sign Up</button>
                <?php echo $this->Form->end(); ?>
            </div>  
        </div>
    </div>
</div> <!-- #login_panel -->
<script>
var showOverlay = ("<?php echo $show ?>" == "none") ? true  : false;
var username = "<?php echo $username; ?>";
var password = "<?php echo $password; ?>";
</script>
<?php echo $this->Html->script(array('login', array('inline' => false))); ?>