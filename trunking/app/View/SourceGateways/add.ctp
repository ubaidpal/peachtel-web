<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to gateway list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Source Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('SourceGateway'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?>
        <?php echo $this->Form->input('addr', array('type' => 'text', 'label' => 'IP Address')); ?><br />
        <?php echo $this->Form->input('port', array('label' => 'Port')); ?><br />
        <?php echo $this->Form->end('Add Gateway'); ?>
    </div> 
</div> 
