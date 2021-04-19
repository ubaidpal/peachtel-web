<div class="main_container">
    <div class="login_panel">
        <?php echo $this->form->create('User', array('action' => 'login', 'method' => 'post')); ?>
        <?php echo $this->form->input('login');?>
        <?php echo $this->form->input('password'); ?>
        <?php echo $this->form->end('Log In'); ?>
    </div>
</div>