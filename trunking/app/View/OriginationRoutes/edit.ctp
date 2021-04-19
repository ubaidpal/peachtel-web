<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($origRoute['OriginationRoute']['vm_backup_enable'] == 't') ? true : false;
    $checked2 = ($origRoute['OriginationRoute']['active'] == 't') ? true : false;
?>

<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to route list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Origination Route</div>
    <div class="form_content">
        <?php echo $this->Form->create('OriginationRoute'); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text', 'value' => $origRoute['OriginationRoute']['prefix'])); ?><br />
        <?php echo $this->Form->input('descr', array('label' => 'Name', 'value' => $origRoute['OriginationRoute']['descr'])); ?><br />
        <?php echo $this->Form->input('orig_rate_id', array('options' => $origRate, 'value' => $origRoute['OriginationRoute']['orig_rate_id'])); ?><br />
        <label>Voicemail Backup (On or Off)</label>
        <?php echo $this->Form->input('vm_backup_enable', array('type' => 'checkbox', 'label' => false, 'checked' => $checked)); ?><br />
        <?php echo $this->Form->input('vm_backup_email', array('label' => 'Voicemail Backup Email', 'value' => $origRoute['OriginationRoute']['vm_backup_email'])); ?><br />
        <label>Active (Yes or No)</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false, 'checked' => $checked2)); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 