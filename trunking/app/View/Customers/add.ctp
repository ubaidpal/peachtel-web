<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Customer</div>
    <div class="form_content">
        <?php echo $this->Form->create('Customer'); ?>
        <?php echo $this->Form->input('descr'); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->end('Add Customer'); ?>
    </div> 
</div> 

