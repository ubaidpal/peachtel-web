<div class="form_dialog" style="display:none;">
    <?php echo $this->form->create('admintool', array('action' => 'add_billing_group')); ?>
    <?php echo $this->form->input('BillingGroup.customer_id', array('type' => 'hidden', 'value' => $clientTrunkData['Customer']['id'])); ?>
    <?php echo $this->form->input('BillingGroup.customer_bg_billing_target_id', array('type' => 'hidden', 'value' => $clientTrunkData['MasterBillingGroup']['id'])); ?>
    <br />
    <?php echo $this->form->end('Add'); ?>
</div>
<div id="form_dialog_pref" style="display:none;">
    <?php echo $this->form->create('admintool', array('action' => 'addDeletePrefix')); ?>
    <?php echo $this->form->input('id', array('type' => 'hidden')); ?>
    <?php echo $this->form->input('method', array('type' => 'hidden', 'value' => 'add')); ?>
    <?php echo $this->form->input('prefix', array('label' => 'Prefix: ')); ?>
    <div><p>or you can select from below.</p></div>
    <?php echo $this->form->input('vpref', array('options' => $vendor_prefs, 'empty' => '-Select-', 'label' => false)); ?>
    <br />
    <?php echo $this->form->end('Add'); ?>
</div>
<div id="form_dialog_credit" style="display:none;">
    <?php echo $this->form->create('admintool', array('action' => 'add_credit')); ?>
    <?php echo $this->form->input('bg_id', array('type' => 'hidden', 'label' => false)); ?>
    <?php echo $this->form->input('bal', array('type' => 'hidden', 'label' => false)); ?>
    <?php echo $this->form->input('method', array('type' => 'select', 'label' => false, 'options' => array('add' => 'Credit', 'debit' => 'Debit'))); ?>
    <br />
    <?php echo $this->form->input('Credit', array('label' => 'Amount: ')); ?>
    <br />
    <?php echo $this->form->end('Save'); ?>
</div>
<div id="form_dialog_fraud" style="display:none;"></div>