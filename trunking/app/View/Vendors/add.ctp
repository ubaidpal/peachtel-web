<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor list', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Vendor</div>
    <div class="form_content">
        <?php echo $this->Form->create('CustomerVendor'); ?>
        <?php echo $this->Form->input('descr'); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->input('region_group_id', array('type' => 'select', 'options' => $regionGroup)); ?><br />
        <?php echo $this->Form->end('Add Vendor'); ?>
    </div> 
</div> 


