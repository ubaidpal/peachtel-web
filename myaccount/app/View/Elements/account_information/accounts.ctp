<div id="addcontactform">
    <?php
        echo $this->Form->create('', array('id' => 'selectcontact'));
        echo $this->Form->input('select_contact', array('options' => $contacts, 'empty' => 'Add new contact'));
        echo $this->Form->end(); 
    ?>
</div>
<br />
<div id="form">
    <h2><?php echo (!empty($contactDetail['ID'])) ? "Edit" : "Add" ?> Contact</h2>
    <?php
        echo $this->Form->create('User', array('action' => 'add_contact'));
        echo $this->Form->input('contactid', array('type' => 'hidden', 'value' => $contactDetail['ID']));
        echo $this->Form->input('firstname', array('type' => 'text', 'placeholder' => 'First Name', 'value' => $contactDetail['FIRSTNAME'], 'class' => 'required'));
        echo $this->Form->input('lastname', array('type' => 'text', 'placeholder' => 'Last Name', 'value' => $contactDetail['LASTNAME'], 'class' => 'required'));
        echo $this->Form->input('companyname', array('type' => 'text', 'placeholder' => 'Company Name', 'value' => $contactDetail['COMPANYNAME'], 'class' => 'required'));
        echo $this->Form->input('email', array('type' => 'text', 'placeholder' => 'Email', 'value' => $contactDetail['EMAIL'], 'class' => 'required email'));
        echo $this->Form->input('address1', array('type' => 'text', 'placeholder' => 'Address No. 1', 'value' => $contactDetail['ADDRESS1'], 'class' => 'required'));
        echo $this->Form->input('address2', array('type' => 'text', 'placeholder' => 'Address No. 2', 'value' => $contactDetail['ADDRESS2']));
        echo $this->Form->input('city', array('type' => 'text', 'placeholder' => 'City', 'value' => $contactDetail['CITY'], 'class' => 'required'));
        echo $this->Form->input('state', array('options' => $states, 'value' => $contactDetail['STATE']));
        echo $this->Form->input('postcode', array('type' => 'text', 'placeholder' => 'Zip Code', 'label' => 'Zip Code', 'value' => $contactDetail['POSTCODE'], 'class' => 'required zipcode'));
        echo $this->Form->input('country', array('options' => $countryList, 'value' => $contactDetail['COUNTRY']));
        echo $this->Form->input('phonenumber', array('type' => 'text', 'placeholder' => 'Phone Number', 'label' => 'Phone Number', 'value' => $contactDetail['PHONENUMBER'], 'class' => 'required phone'));
        echo "<br/>";
        echo $this->Form->input('permissions', array('type' => 'checkbox', 'label' => '&nbsp;&nbsp;Activate Sub-Account'));
        echo "<hr />";
        echo "EMAIL PREFERENCES";
        echo $this->Form->input('generalemails', array('type' => 'checkbox', 'checked' => $contactDetail['GENERALEMAILS'], 'label' => '&nbsp;&nbsp;General Emails - General Announcements & Password Reminders'));
        echo $this->Form->input('productemails', array('type' => 'checkbox', 'checked' => $contactDetail['PRODUCTEMAILS'], 'label' => '&nbsp;&nbsp;Product Emails - Order Details, Welcome Emails, etc...'));
        echo $this->Form->input('domainemails', array('type' => 'checkbox', 'checked' => $contactDetail['DOMAINEMAILS'], 'label' => '&nbsp;&nbsp;Domain Emails - Renewal Notices, Registration Confirmations, etc...'));
        echo $this->Form->input('invoiceemails', array('type' => 'checkbox', 'checked' => $contactDetail['INVOICEEMAILS'], 'label' => '&nbsp;&nbsp;Invoice Emails - Invoices & Billing Reminders'));
        echo $this->Form->input('supportemails', array('type' => 'checkbox', 'checked' => $contactDetail['SUPPORTEMAILS'], 'label' => '&nbsp;&nbsp;Support Emails - Allow this user to open tickets in your account'));
        echo "<br/>";
        echo $this->Form->end('Save Changes');
    ?>
</div>
<?php echo $this->Html->script(array('custom_validations'), array('inline' => false)); ?>