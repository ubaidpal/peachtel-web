<style>
    div.input {
        display: inline-block;
    }
    div.input {
        margin-top: 10px;
    }
    .submit {
        margin-top:20px;
    }
</style>
<?php echo $this->form->create('admintool', array('action' => 'save_fraud')); ?>
<?php echo $this->form->input('id', array('type' => 'hidden', 'value' => $fraud['FraudCtrlPref']['customer_bg_id'])); ?>
<div style="display: inline-block; width: 115px;">Thresh Cost Min:</div>
<?php echo $this->form->input('hc_minute_cost_thresh', array('label' => false, 'value' => $fraud['FraudCtrlPref']['hc_minute_cost_thresh'])); ?>
<div style="display: inline-block; width: 115px;">Max Calls: </div>
<?php echo $this->form->input('max_hc_calls_simult', array('label' => false, 'value' => $fraud['FraudCtrlPref']['max_hc_calls_simult'])); ?>
<?php echo $this->form->end('Save'); ?>