<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($vendor['CustomerVendor']['active'] == 't') ? true : false;
?>
                    
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor list', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div>

<div class="add_trunk_form">
    <div class="form_header">Add Vendor</div>
    <div class="form_content">
        <?php echo $this->Form->create('CustomerVendor'); ?>
        <?php echo $this->Form->input('descr', array('value' => $vendor['CustomerVendor']['descr'])); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'checked' => $checked, 'label' => false)); ?><br />
        <?php echo $this->Form->input('region_group_id', array('type' => 'select', 'options' => $regionGroup, 'value' => $vendor['CustomerVendor']['region_group_id'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 
