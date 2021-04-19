<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'region/'.$reg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="add_trunk_form">
    <div class="form_header">Edit Region</div>
    <div class="form_content">
        <?php echo $this->Form->create('Region'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name', 'value' => $region['Region']['descr'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 