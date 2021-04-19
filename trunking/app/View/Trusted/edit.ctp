<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Edit Trusted</div>
    <div class="form_content">
        <?php echo $this->Form->create('Trusted'); ?>
        <?php echo $this->Form->input('src_ip', array('label' => 'Source IP ', 'value' => $trusted['Trusted']['src_ip'])); ?><br />
        <?php echo $this->Form->input('proto', array('value' => $trusted['Trusted']['proto'])); ?><br />
        <?php echo $this->Form->input('from_pattern', array('value' => $trusted['Trusted']['from_pattern'])); ?><br />
        <?php echo $this->Form->input('tag', array('value' => $trusted['Trusted']['tag'])); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 

