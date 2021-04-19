<div id="form">
    <br />
    <h2>Edit Details</h2>
    <?php
        echo $this->Form->create();
        echo $this->Form->input('firstname', array('type' => 'text', 'placeholder' => 'First Name', 'value' => $clientDetail['CLIENT']['FIRSTNAME'], 'class' => 'required'));
        echo $this->Form->input('lastname', array('type' => 'text', 'placeholder' => 'Last Name', 'value' => $clientDetail['CLIENT']['LASTNAME'], 'class' => 'required'));
        echo $this->Form->input('companyname', array('type' => 'text', 'placeholder' => 'Company Name', 'value' => $clientDetail['CLIENT']['COMPANYNAME'], 'class' => 'required'));
        echo $this->Form->input('email', array('type' => 'text', 'placeholder' => 'Email', 'value' => $clientDetail['CLIENT']['EMAIL'], 'class' => 'required email'));
        echo $this->Form->input('paymentmethod', array('label' => 'Payment Method', 'options' => array("none" => "Use Default (Set Per Order)", "paymentsgateway" => "ACHDirect")));
        echo $this->Form->input('billingcid', array('label' => 'Default Billing Contact', 'options' => $contacts, 'empty' => 'Use Default Contact (Details Above)', 'value' => $clientDetail['CLIENT']['BILLINGCID']));
        echo $this->Form->input('address1', array('type' => 'text', 'placeholder' => 'Address No. 1', 'value' => $clientDetail['CLIENT']['ADDRESS1'], 'class' => 'required'));
        echo $this->Form->input('address2', array('type' => 'text', 'placeholder' => 'Address No. 2', 'value' => $clientDetail['CLIENT']['ADDRESS2']));
        echo $this->Form->input('city', array('type' => 'text', 'placeholder' => 'City', 'value' => $clientDetail['CLIENT']['CITY'], 'class' => 'required'));
        echo $this->Form->input('state', array('options' => $states, 'value' => $clientDetail['CLIENT']['STATE']));
        echo $this->Form->input('postcode', array('type' => 'text', 'placeholder' => 'Zip Code', 'label' => 'Zip Code', 'value' => $clientDetail['CLIENT']['POSTCODE'], 'class' => 'required zipcode'));
        echo $this->Form->input('country', array('options' => $countryList, 'value' => $clientDetail['CLIENT']['COUNTRY']));
        echo $this->Form->input('phonenumber', array('type' => 'text', 'placeholder' => 'Phone Number', 'label' => 'Phone Number', 'value' => $clientDetail['CLIENT']['PHONENUMBER'], 'class' => 'required phone'));
        echo "<br/>";
        echo $this->Form->end('Save Changes');
    ?>
</div>
<?php echo $this->Html->script(array('custom_validations'), array('inline' => false)); ?>