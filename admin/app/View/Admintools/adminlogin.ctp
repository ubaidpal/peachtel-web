<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="login">
    <h1>Dashboard</h1>
    <div >
    </div>
    <?php echo '<center style="color:red">'.$this->Session->flash().'</center>'; ?>
    <div id="login_panel">
        <?php echo $this->Form->create('Admin', array('id' => 'loginfrm', 'class' => 'form-login', 'name' => 'loginForm')); ?> 	
        <div class="login_fields">
            <div class="field">
                <label for="email">Username</label>
                <?php echo $this->Form->input('username', array('label' => false, 'type' => 'text', 'div' => false, 'id' => 'email!!', 'class' => 'big', 'tabindex' => '1', "placeholder" => "email@example.com")); ?>

            </div>

            <div class="field">
                <label for="password">Password <small><a href="javascript:;">Forgot Password?</a></small></label>
                <?php echo $this->Form->input('password', array('label' => false, 'type' => 'password', 'div' => false, 'id' => 'password', 'tabindex' => '2', "placeholder" => "password")); ?>
            </div>
        </div> <!-- .login_fields -->

        <div class="login_actions">
            <button type="submit" class="btn btn-primary" tabindex="3">Login</button>
        </div>
        </form>
    </div> <!-- #login_panel -->		
</div> <!-- #login -->

