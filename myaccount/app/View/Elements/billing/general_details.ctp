<?php $cdetail = $clientDetails['CLIENT']; ?>
<div class="box" style="margin:0; border-radius: 0;">
    <h3>Account Status</h3>
    Account Balance: <?php echo $clientDetails['STATS']['CREDITBALANCE']; ?><br />
    Auto Replenish is set to : On <a href="#">[manage]</a><br />
    Payment Methods is <font style="color: blue"><?php echo $cdetail['CCTYPE']; ?></font> ending in <font style="color: blue"><?php echo $cdetail['CCLASTFOUR']; ?></font><!-- expiring <font style="color: blue"><?php echo 'N/A'; //$cdetail['expdate'];      ?>--></font> <a href="billing/creditcard_details">[manage]</a><br />
    Make a Payment of $100 <a href="#">[make payment]</a>
    <br /><br />
    <h3 style="display: inline-block;">Billing Address</h3>  
    <a href="account_information" style="display: inline-block;">[change]</a>
    <br />
    Address 1: <?php echo $cdetail['ADDRESS1']; ?><br />
    Address 2: <?php echo $cdetail['ADDRESS2']; ?><br />
    City: <?php echo $cdetail['CITY']; ?><br />
    State: <?php echo $cdetail['STATE']; ?><br />
    Postcode: <?php echo $cdetail['POSTCODE']; ?><br />
    Country: <?php echo $cdetail['COUNTRYNAME']; ?><br />
    Phonenumber: <?php echo$cdetail['PHONENUMBER']; ?>
</div>