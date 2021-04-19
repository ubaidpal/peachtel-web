<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('login');?>
<?php echo $this->Form->input('password', array('type' => 'password'));?>
<?php echo $this->Form->input('name');?>
<?php echo $this->Form->end('Register'); ?>