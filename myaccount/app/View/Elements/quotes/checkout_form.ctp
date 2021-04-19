<div class="box checkout_form" style="display: none;">
    
    <h1>Billing Details - <a style="font-size: 16px;" href="javascript:void(0);" class="checkoutReview">Review Quote</a></h1>
    <div id='err_pane' style='padding: 5px 10px; display: none; background: #FFFFDD; border: 1px solid #D5D5D5;'></div>
    
    <?php 
    echo $this->Form->create('');
    echo $this->Form->input('Tblclient.quotes_key', array('type' => 'hidden'));
    echo $this->Form->input('Tblclient.country', array('default' => 'US', 'options' => $countryList, 'class' => 'required'));
    echo $this->Form->input('Tblclient.state', array('options' => $states, 'class' => 'required'));
    echo $this->Form->input('Tblclient.city', array('type' => 'text', 'placeholder' => 'City', 'class' => 'required'));
    echo $this->Form->input('Tblclient.postcode', array('type' => 'text', 'placeholder' => 'Post Code', 'class' => 'required'));
    echo $this->Form->input('Tblclient.address1', array('type' => 'text', 'placeholder' => 'Address 1', 'class' => 'required'));
    echo $this->Form->input('Tblclient.address2', array('type' => 'text', 'placeholder' => 'Address 2 (Optional)'));
    echo $this->Form->input('Tblclient.phonenumber', array('type' => 'text', 'placeholder' => 'Phonenumber', 'class' => 'required', 'minLength' => '10'));
    ?>
    
    <br /><br />
    <a href='javascript:void(0);' id='validate_location'>Validate Address</a></label>&nbsp;&nbsp;
    <br />
    <br />
    <h3 style="margin-bottom: 0; font-size: 14px; font-weight: bold; width: 260px; display: inline-block; vertical-align:middle">or use previous address from below</h3>
    [<a href="javascript:void(0);" style="display:inline-block; text-decoration: none;" onclick="$('#addresses').slideToggle();">Toggle</a>]
    <div id="addresses" style="display:none;">
    <?php 
    $links = array();
    foreach($quotes as $key => $quote) {
        $link = '';
        $data = array('country', 'state', 'city', 'postcode', 'address1', 'phonenumber');
        foreach($data as $field) {
            if(!empty($quote['SavedQuote'][$field]))
                $link .= $quote['SavedQuote'][$field]."/";
        }

        if(!in_array($link, $links)) {
            array_push($links, $link);
            echo $this->Form->input("<b>&nbsp;&nbsp;".$quote['SavedQuote']['address1']."</b>", array('type'=>'checkbox', 'id' => 'useAddr', 'data' => $link));
        }
    }
    ?>  
    </div>
    <hr style='margin: 30px 0;'/>
    <div id="carrier_holder" style="display:none;">
        <h1>Shipping Details</h1>
        <div class='input'>
        <label>Use address above?</label>
        <?php echo $this->Form->input('Tblclient.use_address', array('type' => 'checkbox', 'label' => false, 'value' => 'yes', 'div' => false, 'legend' => false)); ?>
        </div>
        <div id="shipAddress">
        <?php
            echo $this->Form->input('Tblclient.ship_country', array('default' => 'US', 'options' => $countryList, 'class' => ''));
            echo $this->Form->input('Tblclient.ship_state', array('options' => $states, 'class' => ''));
            echo $this->Form->input('Tblclient.ship_city', array('type' => 'text', 'placeholder' => 'City', 'class' => ''));
            echo $this->Form->input('Tblclient.ship_postcode', array('type' => 'text', 'placeholder' => 'Post Code', 'class' => ''));
            echo $this->Form->input('Tblclient.ship_address1', array('type' => 'text', 'placeholder' => 'Address 1', 'class' => ''));
            echo $this->Form->input('Tblclient.ship_address2', array('type' => 'text', 'placeholder' => 'Address 2 (Optional)'));
            echo $this->Form->input('Tblclient.ship_phonenumber', array('type' => 'text', 'placeholder' => 'Phonenumber', 'class' => '', 'minLength' => '10'));
        ?>
        </div>
        <div class='input'>
        <label>Purchase insurance?</label>
        <?php echo $this->Form->input('Tblclient.insurance', array('type' => 'radio', 'class' => 'insurance', 'value' => 'yes', 'options' => array('yes' => 'Yes', 'no' => 'No'), 'div' => false, 'legend' => false)); ?>
        </div>
        <div class='input'>
        <label>Carrier</label>
        <?php echo $this->Form->input('Tblclient.carrier', array('type' => 'radio', 'class' => 'shippingMethod', 'value' => '1', 'options' => array('1' => 'UPS', '2' => 'FEDEX'), 'div' => false, 'legend' => false)); ?>
        </div>
        <div id='carrier_details' style='width: 100%'></div>
        <hr style='margin: 20px 0;'/>
    </div>
    <div id="checkout-btn-holder" style="display:none;">
    <a href="javascript:void(0);" id="GoogleCheckOutBtn"><img src="http://<?php echo $_SERVER['HTTP_HOST']?>/myaccount/images/gallery/checkout.png" /></a><br /><br />
    <a href="javascript:void(0);" id="PaypalCheckOutBtn"><img src="http://<?php echo $_SERVER['HTTP_HOST']?>/myaccount/images/gallery/checkoutpaypal.png" /></a><br /><br />
    <a href="javascript:void(0);" id="AuthorizeCheckOutBtn"><img src="http://<?php echo $_SERVER['HTTP_HOST']?>/myaccount/images/gallery/checkoutauthorize.png" /></a><br /><br />
    <?php //echo $this->Form->input('Checkout (Paypal)', array('type' => 'submit', 'style' => 'float: left;', 'div' => false, 'label' => false)); ?>
    </div>
    <a href="javascript:void(0);" id="cancel"><img src="http://<?php echo $_SERVER['HTTP_HOST']?>/myaccount/images/gallery/checkoutcancel.png" /></a>
    <?php echo $this->Form->end(); ?>
    
</div>