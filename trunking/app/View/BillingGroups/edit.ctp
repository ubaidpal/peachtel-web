<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($billingGroup['BillingGroup']['proxy_media'] == 't') ? true : false;
?>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'index/'.$billingGroup['BillingGroup']['customer_id'], array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Billing Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('BillingGroup'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name', 'value' => $billingGroup['BillingGroup']['descr'])); ?><br />
        <?php echo $this->Form->input('ingress_dnis_strip_digits', array('value' => $billingGroup['BillingGroup']['ingress_dnis_strip_digits'])); ?><br />
        <?php echo $this->Form->input('ingress_dnis_prepend_prefix', array('value' => $billingGroup['BillingGroup']['ingress_dnis_prepend_prefix'])); ?><br />
        <?php echo $this->Form->input('channel_limit', array('value' => $billingGroup['BillingGroup']['channel_limit'])); ?><br />
        <?php echo $this->Form->input('ingress_ani_strip_digits', array('value' => $billingGroup['BillingGroup']['ingress_ani_strip_digits'])); ?><br />
        <?php echo $this->Form->input('ingress_ani_prepend_prefix', array('value' => $billingGroup['BillingGroup']['ingress_ani_prepend_prefix'])); ?><br />
        <?php echo $this->Form->input('notify_email', array('value' => $billingGroup['BillingGroup']['notify_email'])); ?><br />
        <?php echo $this->Form->input('vendor_term_group_id', array('options' => $terminationGroup, 'value' => $billingGroup['BillingGroup']['vendor_term_group_id'])); ?><br />
        <?php echo $this->Form->input('term_rate_plan_id', array('options' => $terminationPlan, 'value' => $billingGroup['BillingGroup']['term_rate_plan_id'])); ?><br />
        <?php echo $this->Form->input('proxy_media', array('checked' => $checked)); ?>
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 


