<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'index/'.$customer_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Billing Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('BillingGroup'); ?>
        <?php echo $this->Form->input('customer_id', array('type' => 'hidden', 'value' => $customer_id)); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->input('ingress_dnis_strip_digits'); ?><br />
        <?php echo $this->Form->input('ingress_dnis_prepend_prefix'); ?><br />
        <?php echo $this->Form->input('channel_limit'); ?><br />
        <?php echo $this->Form->input('ingress_ani_strip_digits'); ?><br />
        <?php echo $this->Form->input('ingress_ani_prepend_prefix'); ?><br />
        <?php echo $this->Form->input('notify_email'); ?><br />
        <?php echo $this->Form->input('vendor_term_group_id', array('options' => $terminationGroup)); ?><br />
        <?php echo $this->Form->input('term_rate_plan_id', array('options' => $terminationPlan)); ?><br />
        <?php echo $this->Form->input('proxy_media'); ?><br />
        <?php echo $this->Form->end('Add Group'); ?>
    </div> 
</div> 

