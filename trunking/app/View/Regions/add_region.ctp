<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Region Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('Region'); ?>
        <?php echo $this->Form->input('region_group_id', array('type' => 'hidden', 'value' => $reg_group_id)); ?><br />
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->end('Add Region'); ?>
    </div> 
</div> 


