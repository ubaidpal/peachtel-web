<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($vendorOrigGw['VendorOriginationGateway']['proxy_media'] == 't') ? true : false;
?>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', '/vendors/edit/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Origination Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('VendorOriginationGateway'); ?>
        <?php echo $this->Form->input('addr', array('type' => 'text', 'label' => 'IP Address', 'value' => $vendorOrigGw['VendorOriginationGateway']['addr'])); ?><br />
        <?php echo $this->Form->input('port', array('value' => $vendorOrigGw['VendorOriginationGateway']['port'])); ?><br />
        <?php echo $this->Form->input('ani_strip_digits', array('value' => $vendorOrigGw['VendorOriginationGateway']['ani_strip_digits'])); ?><br />
        <?php echo $this->Form->input('ani_prepend_prefix', array('value' => $vendorOrigGw['VendorOriginationGateway']['ani_prepend_prefix'])); ?><br />
        <?php echo $this->Form->input('dnis_strip_digits', array('value' => $vendorOrigGw['VendorOriginationGateway']['dnis_strip_digits'])); ?><br />
        <?php echo $this->Form->input('dnis_prepend_prefix', array('value' => $vendorOrigGw['VendorOriginationGateway']['dnis_prepend_prefix'])); ?><br />
        <?php echo $this->Form->input('channel_limit', array('value' => $vendorOrigGw['VendorOriginationGateway']['channel_limit'])); ?><br />
        <?php echo $this->Form->input('proxy_media', array('type' => 'checkbox', 'checked' => $checked)); ?>
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 

