<style>
#login_panel2 {
    background: none repeat scroll 0 0 #FFFFFF;
    box-shadow: 5px 5px 10px #000000;
    margin-right: -180px;
    max-width: 375px;
    min-height: 271px;
    padding: 30px;
    position: absolute;
    right: 50%;
    top: 80px;
    width: 840px;
    z-index: 99;
}
#login_panel2 #log_form {
    border:none;
}
</style>
<div id="login_panel2" style="display: none;">
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
                <div style="color:red; padding: 3px 10px; margin-bottom: 10px; width: 90%; display: none; background: #f8f6f3;" id="error_msg"></div>
                <?php echo $this->Form->create('User', array('id' => 'loginformAjax', 'name' => 'loginForm', 'action' => 'login')); ?> 	
                <label>Username:</label>
                <br />
                <input type="hidden" name="data[User][type]" value="ajax" />
                <?php echo $this->Form->input('username', array('label' => false, 'style' => 'width: 350px;', 'type' => 'text', 'div' => false, 'id' => 'email!!', 'class' => 'big', 'tabindex' => '1', "placeholder" => "email@example.com")); ?>
                <br /><br />

                <label>Password:</label>
                <br />
                <?php echo $this->Form->input('password', array('label' => false, 'style' => 'width: 350px;', 'type' => 'password', 'div' => false, 'id' => 'password', 'tabindex' => '2', "placeholder" => "Password")); ?>
                <br />
                <label id="signUp">Not registered? Click <a href="javascript:void(0)" id="showAjaxRegForm">here</a> to register.</label>
                <br /><br />
                <button type="submit" id="main_btn" class="ajaxLogin" style="font-size: 20px; padding: 5px 20px;">Login</button>
                <?php echo $this->Form->end(); ?>
            </div>            
        </div>
    </div>
</div> <!-- #login_panel -->	
