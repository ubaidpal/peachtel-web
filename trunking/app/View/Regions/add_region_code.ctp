<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'region_code/'.$reg_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Region Code</div>
    <div class="form_content">
        <?php echo $this->Form->create('RegionCode'); ?>
        <?php echo $this->Form->input('region_id', array('type' => 'hidden', 'value' => $reg_id)); ?><br />
        <?php echo $this->Form->input('prefix', array('type' => 'text')); ?><br />
        <?php echo $this->Form->end('Add Region Code'); ?>
    </div> 
</div> 