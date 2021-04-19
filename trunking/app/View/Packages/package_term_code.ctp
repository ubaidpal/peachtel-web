<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'package/'.$pkg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Package Term Code Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('PackageTermCode'); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text', 'value' => $pkgTermCode['PackageTermCode']['prefix'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 