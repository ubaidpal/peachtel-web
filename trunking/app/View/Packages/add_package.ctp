<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'package/'.$pkg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Package Term Code Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('Package'); ?>
        <?php echo $this->Form->input('pkg_term_code_group_id', array('type' => 'hidden', 'value' => $pkg_group_id)); ?><br />
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->input('total_min'); ?><br />
        <?php echo $this->Form->input('ovg_minute_cost'); ?><br />
        <?php echo $this->Form->input('ovg_min_duration'); ?><br />
        <?php echo $this->Form->input('ovg_duration_incr'); ?><br />
        <?php echo $this->Form->end('Add Package'); ?>
    </div> 
</div> 


