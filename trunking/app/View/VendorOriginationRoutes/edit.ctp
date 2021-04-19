<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($vendorOrigR['VendorOriginationRoute']['active'] == 't') ? true : false;
?>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to orig. list', 'index/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Origination Route</div>
    <div class="form_content">
        <?php echo $this->Form->create('VendorOriginationRoute'); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text', 'value' => $vendorOrigR['VendorOriginationRoute']['prefix'])); ?><br />
        <?php echo $this->Form->input('descr', array('type' => 'text', 'label' => 'Name', 'value' => $vendorOrigR['VendorOriginationRoute']['descr'])); ?><br />
        <?php echo $this->Form->input('minute_cost', array('value' => $vendorOrigR['VendorOriginationRoute']['minute_cost'])); ?><br />
        <?php echo $this->Form->input('min_duration', array('value' => $vendorOrigR['VendorOriginationRoute']['min_duration'])); ?><br />
        <?php echo $this->Form->input('duration_incr', array('value' => $vendorOrigR['VendorOriginationRoute']['duration_incr'])); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'checked' => $checked, 'label' => false)); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 