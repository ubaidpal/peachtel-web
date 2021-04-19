<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to route list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="add_trunk_form">
    <div class="form_header">Add Subscriber</div>
    <div class="form_content">
        <?php echo $this->Form->create('Subscriber'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?>
        <?php echo $this->Form->input('username'); ?><br />
        <?php echo $this->Form->input('domain'); ?><br />
        <?php echo $this->Form->input('password'); ?><br />
        <?php echo $this->Form->end('Add Subscriber'); ?>
    </div> 
</div> 
