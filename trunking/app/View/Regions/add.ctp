<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Region Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('RegionGroup'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->end('Add Group'); ?>
    </div> 
</div> 


