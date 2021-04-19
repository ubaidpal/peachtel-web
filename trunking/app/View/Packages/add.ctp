<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Package Term Code Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('PackageTermCodeGroup'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->end('Add Group'); ?>
    </div> 
</div> 


