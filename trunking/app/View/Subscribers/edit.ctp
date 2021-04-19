<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to gateway list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Subscriber</div>
    <div class="form_content">  
        <?php echo $this->Form->create('Subscriber'); ?>
        <?php echo $this->Form->input('username', array('value' => $subscriber['Subscriber']['username'])); ?>
        <?php echo $this->Form->input('domain', array('value' => $subscriber['Subscriber']['domain'])); ?>
        <?php echo $this->Form->input('password', array('value' => $subscriber['Subscriber']['password'])); ?>
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 