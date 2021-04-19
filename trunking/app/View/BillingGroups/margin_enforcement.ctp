<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $useMarginEnf = ($margin['MarginEnforcement']['margin_enforce'] == 't') ? true : false;
    $MarginEnfMinDur = ($margin['MarginEnforcement']['margin_enforce_min_duration'] == 't') ? true : false;
?>

<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to billing group', '/trunking_billing_groups/edit/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Credit Controll</div>
    <div class="form_content">
        <?php echo $this->Form->create('MarginEnforcement'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?><br />
        <label>Use Margin Enforcement?<br />(Yes or No)</label>
        <?php echo $this->Form->input('margin_enforce', array('label' => false, 'checked' => $useMarginEnf)); ?><br />
        <?php echo $this->Form->input('margin_minimum', array('value' => $margin['MarginEnforcement']['margin_minimum'])); ?><br />
        <label>Enforce Minimum Duration?<br />(Yes or No)</label>
        <?php echo $this->Form->input('margin_enforce_min_duration', array('label' => false, 'checked' => $MarginEnfMinDur)); ?><br />
        <?php echo $this->Form->input('margin_min_duration_minimum', array('value' => $margin['MarginEnforcement']['margin_min_duration_minimum'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 