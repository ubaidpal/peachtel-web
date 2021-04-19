<br />
<div id="form">
    <h2>Change Password</h2>
    <?php
        echo $this->Form->create('User', array('action' => 'change_password'));
        echo $this->Form->input('old_password', array('type' => 'password', 'placeholder' => 'Old Password', 'class' => 'required'));
        echo $this->Form->input('password', array('type' => 'password', 'placeholder' => 'New Password', 'class' => 'required'));
        echo $this->Form->input('re_password', array('type' => 'password', 'equalTo' => '#UserPassword', 'placeholder' => 'Re-Type Password'));
        echo "<div id='strength_meter'><b>Password Strength</b><div id='meter' class=''></div></div>";
        echo "<br />";
        echo $this->Form->end('Change Password'); 
    ?>
</div>
<?php echo $this->Html->script(array('custom_validations'), array('inline' => false)); ?>