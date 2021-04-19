<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to route list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="add_trunk_form">
    <div class="form_header">Add Origination Route</div>
    <div class="form_content">
        <?php echo $this->Form->create('OriginationRoute'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text')); ?><br />
        <?php echo $this->Form->input('descr', array('label' => 'Name')); ?><br />
        <?php echo $this->Form->input('orig_rate_id', array('options' => $origRate, 'label' => 'Origination Rate')); ?><br />
        <label>Vm Backup Enable (Yes or No)</label>
        <?php echo $this->Form->input('vm_backup_enable', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->input('vm_backup_email', array('label' => 'Voicemail Backup Email')); ?><br />
        <label>Active (Yes or No)</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->end('Add Group'); ?>
    </div> 
</div> 