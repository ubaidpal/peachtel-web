<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to gateway list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Edit Source Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('SourceGateway'); ?>
        <?php echo $this->Form->input('addr', array('type' => 'text', 'label' => 'IP Address', 'value' => $sourceGateway['SourceGateway']['addr'])); ?><br />
        <?php echo $this->Form->input('port', array('label' => 'Port', 'value' => $sourceGateway['SourceGateway']['port'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 

