<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $checked = ($termRoute['TerminationRoute']['intra_regional'] == 't') ? true : false;
    $checked2 = ($termRoute['TerminationRoute']['active'] == 't') ? true : false;
?>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Term. list', 'index/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<div class="add_trunk_form">
    <div class="form_header">Add Termination Route</div>
    <div class="form_content">
        <?php echo $this->Form->create('TerminationRoute'); ?>
        <?php echo $this->Form->input('prefix', array('type' => 'text', 'value' => $termRoute['TerminationRoute']['prefix'])); ?><br />
        <?php echo $this->Form->input('descr', array('type' => 'text', 'label' => 'Name', 'value' => $termRoute['TerminationRoute']['descr'])); ?><br />
        <?php echo $this->Form->input('minute_cost', array('value' => $termRoute['TerminationRoute']['minute_cost'])); ?><br />
        <?php echo $this->Form->input('min_duration', array('value' => $termRoute['TerminationRoute']['min_duration'])); ?><br />
        <?php echo $this->Form->input('duration_incr', array('value' => $termRoute['TerminationRoute']['duration_incr'])); ?><br />
        <?php echo $this->Form->input('intra_regional', array('type' => 'checkbox', 'value' => $checked)); ?><br />
        <label>Active</label>
        <?php echo $this->Form->input('active', array('type' => 'checkbox', 'checked' => $checked2, 'label' => false)); ?><br />
        <?php echo $this->Form->end('Save Changes'); ?>
    </div> 
</div> 

