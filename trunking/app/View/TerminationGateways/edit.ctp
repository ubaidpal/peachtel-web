<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($vendorTermGw['TerminationGateway']['proxy_media'] == 't') ? true : false;
?>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', 'add/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Termination Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('TerminationGateway'); ?>
        <?php echo $this->Form->input('priority', array('type' => 'text', 'value' => $vendorTermGw['TerminationGateway']['priority'])); ?><br />
        <?php echo $this->Form->input('addr', array('type' => 'text', 'label' => 'IP Address', 'value' => $vendorTermGw['TerminationGateway']['addr'])); ?><br />
        <?php echo $this->Form->input('port', array('value' => $vendorTermGw['TerminationGateway']['port'])); ?><br />
        <?php echo $this->Form->input('strip_digits', array('value' => $vendorTermGw['TerminationGateway']['strip_digits'])); ?><br />
        <?php echo $this->Form->input('prepend_prefix', array('value' => $vendorTermGw['TerminationGateway']['prepend_prefix'])); ?><br />
        <?php echo $this->Form->input('channel_limit', array('value' => $vendorTermGw['TerminationGateway']['channel_limit'])); ?><br />
        <?php echo $this->Form->input('proxy_media', array('type' => 'checkbox', 'checked' => $checked)); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 


