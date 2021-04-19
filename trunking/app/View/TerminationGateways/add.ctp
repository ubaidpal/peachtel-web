<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', 'index/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Termination Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('VendorOriginationGateway'); ?>
        <?php echo $this->Form->input('vendor_id', array('type' => 'hidden', 'value' => $vendor_id)); ?>
        <?php echo $this->Form->input('priority', array('type' => 'text')); ?><br />
        <?php echo $this->Form->input('addr', array('type' => 'text', 'label' => 'IP Address')); ?><br />
        <?php echo $this->Form->input('port'); ?><br />
        <?php echo $this->Form->input('strip_digits'); ?><br />
        <?php echo $this->Form->input('prepend_prefix'); ?><br />
        <?php echo $this->Form->input('proxy_media', array('type' => 'checkbox')); ?><br />
        <?php echo $this->Form->end('Add Term. Gateway'); ?>
    </div> 
</div> 


