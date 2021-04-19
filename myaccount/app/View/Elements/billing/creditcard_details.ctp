<br />
<div id="form">
    <h2 style="margin-bottom:10px;">Credit Card Details</h2>
    <p>Below is your existing credit card details.</p>
    <?php
        echo $this->Form->input('card_type', array('type' => 'text', 'value' => $clientDetails['CLIENT']['CCTYPE'], 'disabled' => true));
        echo $this->Form->input('card_number', array('type' => 'text', 'value' => "************".$clientDetails['CLIENT']['CCLASTFOUR'], 'disabled' => true, 'placeholder' => 'Card Number', 'class' => 'required creditcard'));
    ?>
    <br />
    <h3>Change your credit card details below.</h3>
    <?php
        $cardTypes = array(
            'Visa' => 'Visa',
            'MasterCard' => 'MasterCard',
            'Discover' => 'Discover',
            'American Express' => 'American Express',
            'JCB' => 'JCB',
            'EnRoute' => 'EnRoute',
            'Diners Club' => 'Diners Club'
        );
        echo $this->Form->create('User', array('action' => 'update_creditcard'));
        echo $this->Form->input('card_type', array('options' => $cardTypes));
        echo $this->Form->input('card_number', array('type' => 'text', 'placeholder' => 'Card Number', 'class' => 'required creditcard'));
        //echo $this->Form->input('expiry_date', array('type' => 'text', 'placeholder' => 'Expiry Date'));
        echo "<br />";
        echo $this->Form->end('Update Details'); 
    ?>
</div>
<?php echo $this->Html->script(array('custom_validations'), array('inline' => false)); ?>