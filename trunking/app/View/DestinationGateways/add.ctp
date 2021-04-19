<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to gateway list', 'index/'.$group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Desitination Gateway</div>
    <div class="form_content">
        <?php echo $this->Form->create('DestinationGateway'); ?>
        <?php echo $this->Form->input('customer_bg_id', array('type' => 'hidden', 'value' => $group_id)); ?>
        <?php echo $this->Form->input('priority', array('type' => 'text')); ?><br />
        <label>Destination Type</label>
        <?php echo $this->Form->input('dest_type', array('type' => 'radio', 'options' => array('0' => 'Static', '1' => 'Registrant'), 'legend' => false)); ?><br />
        <?php echo $this->Form->input('dest', array('type' => 'text', 'label' => 'destination')); ?><br />
        <label>DNIS Override (Yes or No)</label>
        <?php echo $this->Form->input('contact_dnis_override', array('type' => 'checkbox', 'label' => false)); ?><br />
        <?php echo $this->Form->end('Add Dest. Gateway'); ?>
    </div> 
</div> 

