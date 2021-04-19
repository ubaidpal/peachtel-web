<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Term. list', 'index/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Termination Route</div>
    <div class="form_content">
        <?php echo $this->Form->create('VendorOriginationRoute'); ?>
        <?php echo $this->Form->input('vendor_id', array('type' => 'hidden', 'value' => $vendor_id)); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text')); ?><br />
        <?php echo $this->Form->input('descr', array('type' => 'text', 'label' => 'Name')); ?><br />
        <?php echo $this->Form->input('minute_cost'); ?><br />
        <?php echo $this->Form->input('min_duration'); ?><br />
        <?php echo $this->Form->input('duration_incr'); ?><br />
        <?php echo $this->Form->input('intra_regional', array('type' => 'checkbox')); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->end('Add Orig. Route'); ?>
    </div> 
</div> 
