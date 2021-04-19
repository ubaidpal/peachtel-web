<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $useCredBal = ($credit['CreditControll']['use_credit_bal'] == 't') ? true : false;
    $useCredHold = ($credit['CreditControll']['use_credit_hold'] == 't') ? true : false;
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
        <?php echo $this->Form->create('CreditControll'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?>
        <label>Use Credit Balance? (Yes or No)</label>
        <?php echo $this->Form->input('use_credit_bal', array('label' => false, 'checked' => $useCredBal, 'type' => 'checkbox')); ?><br />
        <?php echo $this->Form->input('credit_bal', array('label' => 'Credit Balance', 'value' => $credit['CreditControll']['credit_bal'])); ?><br />
        <?php echo $this->Form->input('credit_bal_min_thresh', array('label' => 'Credit Balance Minimum Threshold', 'value' => $credit['CreditControll']['credit_bal_min_thresh'])); ?><br />
        <?php echo $this->Form->input('credit_bal_notify_thresh', array('label' => 'Credit Balance Notify Threshold', 'value' => $credit['CreditControll']['credit_bal_notify_thresh'])); ?><br />
        <label>Use Credit Hold? (Yes or No)</label>
        <?php echo $this->Form->input('use_credit_hold', array('label' => false, 'checked' => $useCredHold, 'type' => 'checkbox')); ?><br />
        <?php echo $this->Form->input('credit_hold_min', array('label' => 'Credit Hold Minimum', 'value' => $credit['CreditControll']['credit_hold_min'])); ?><br />
        <?php echo $this->Form->input('credit_hold_bal', array('label' => 'Credit Hold Balance', 'disabled' => 'disabled', 'value' => $credit['CreditControll']['credit_hold_bal'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 


