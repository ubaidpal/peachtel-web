<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Group list', 'package/'.$pkg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Package Term Code Group</div>
    <div class="form_content">
        <?php echo $this->Form->create('Package'); ?>
        <?php echo $this->Form->input('descr', array('label' => 'Name', 'value' => $package['Package']['descr'])); ?><br />
        <?php echo $this->Form->input('total_min', array('value' => $package['Package']['total_min'])); ?><br />
        <?php echo $this->Form->input('ovg_minute_cost', array('value' => $package['Package']['ovg_minute_cost'])); ?><br />
        <?php echo $this->Form->input('ovg_min_duration', array('value' => $package['Package']['ovg_min_duration'])); ?><br />
        <?php echo $this->Form->input('ovg_duration_incr', array('value' => $package['Package']['ovg_duration_incr'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 