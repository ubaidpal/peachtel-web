<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Trusted</div>
    <div class="form_content">
        <?php echo $this->Form->create('Trusted'); ?>
        <?php echo $this->Form->input('src_ip', array('label' => 'Source IP ')); ?><br />
        <?php echo $this->Form->input('proto'); ?><br />
        <?php echo $this->Form->input('from_pattern'); ?><br />
        <?php echo $this->Form->input('tag'); ?><br />
        <?php echo $this->Form->end('Add Trusted'); ?>
    </div> 
</div> 

