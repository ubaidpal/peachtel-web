<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Customer List', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Edit Customer</div>
    <div class="form_content">
        <?php echo $this->Form->create('Customer'); ?>
        <?php echo $this->Form->input('descr', array('value' => $customer['Customer']['descr'])); ?>
        <br />
        <label>Active: </label>
        <?php echo $this->Form->input('active', array('label' => false, 'type' => 'checkbox', 'checked' => $customer['Customer']['active'])); ?>
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 
