<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="add_trunk_form">
    <div class="form_header">Edit Region Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('RegionGroup'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name', 'value' => $regionGroup['RegionGroup']['descr'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 