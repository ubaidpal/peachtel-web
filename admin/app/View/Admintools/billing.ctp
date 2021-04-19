<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$cdetail = $clientDetails['CLIENT'];
//print_r($clientDetails);exit;
?>

<div id="content">	
    <div id="contentHeader">
        <h1>Billing</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-16">
            <div class="box">
                <h3> General Info</h3>
                Account Balance: <?php echo $clientDetails['STATS']['CREDITBALANCE']; ?></br>
                Auto Replenish is set to : On [<a href="#">manage</a>]</br>
                Payment Methods is <font style="color: blue"><?php echo $cdetail['CCTYPE']; ?></font> ending in <font style="color: blue"><?php echo $cdetail['CCLASTFOUR']; ?></font> expiring <font style="color: blue"><?php echo 'N/A'; //$cdetail['expdate'];      ?></font> [<a href="#">manage</a>]</br>
                Make a Payment of $100 [<a href="#">make payment</a>]
            </div>
            <div class="box">
                <h3>Billing Address</h3>
                Address 1: <?php echo $cdetail['ADDRESS1']; ?></br>
                Address 2: <?php echo $cdetail['ADDRESS2']; ?></br>
                City: <?php echo $cdetail['CITY']; ?></br>
                State: <?php echo $cdetail['STATE']; ?></br>
                Postcode: <?php echo $cdetail['POSTCODE']; ?></br>
                Country: <?php echo $cdetail['COUNTRYNAME']; ?></br>
                Phonenumber: <?php echo$cdetail['PHONENUMBER']; ?>
            </div>
            <?php //debug($clientBillingHistory['0']);  ?>
        </div><!-- .grid-16 -->
        <div class="grid-8"  style="display: none;">
            <?php
            if ($this->Session->read("clientDetails") != null) {

                $clientDetails = $this->Session->read("clientDetails");
                if (isset($clientDetails['CLIENT']))
                    $cdetail = $clientDetails['CLIENT'];
                ?>
                <div class="box_side">
                    <h3>Client Info</h3>

                    Customer Name : <?php if (isset($cdetail['FIRSTNAME'])): echo $cdetail['FIRSTNAME'] . " " . $cdetail['LASTNAME'];
            endif; ?> </br>
                    Email : <?php if (isset($cdetail['EMAIL'])): echo $cdetail['EMAIL'];
                endif; ?> </br>
                    Account ID :  <?php if (isset($cdetail['ID'])): echo $cdetail['ID'];
                endif; ?> </br>
                    Last login : <?php if (isset($cdetail["LASTLOGIN"])): echo $cdetail["LASTLOGIN"];
                endif; ?> </br>
                    Account Status :  <label id='status2'><?php if (isset($cdetail["STATUS"])): echo $cdetail["STATUS"];
                endif; ?> </label>&nbsp;[<a href="javascript:;" id="changestatus2">change</a>]
                    <div id="status_loader1"  style="text-align:center;  float: right; margin-top: 5px;margin-left: -2px ; display: none;"> 
                        <?php echo $this->Html->image('/images/loaders/facebook.gif'); ?>  
                    </div>
                <br /><br />
                <li><a href="http://devweb.peachtel.net/myaccount" target="_blank">Login as Client</a></li>
                <li><?php echo $this->Html->link('Add Note', array('action' => 'notes')); ?></li>
                </div>
            <?php } ?>
        </div><!--Grid 8-->
        <div class="grid-24">
            <div class="widget widget-table">
                <div class="widget-header">
    <!--                <span class="icon-list"></span> class="icon chart"-->
                    <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Billing History</h3>		
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped data-table">
                        <thead>
                        <th>S#</th>
                        <th>Invoicenum</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Date Paid</th>
                        <th>Subtotal</th>
                        <th>Credit</th>
                        <th>Tax</th>
    <!--                    <th>Tax2</th>-->
    <!--                    <th>Total</th>-->
                        <th>Tax Rate</th>
    <!--                    <th>Tax Rate2</th>-->
                        <th>Status</th>
    <!--                    <th>Payment Method</th>-->
    <!--                    <th>Notes</th>-->
                        </thead>
                        <?php
                        if ($clientBillingHistory["status"] == "success") {////if
                            $flag = TRUE;
                            $counter = 1;
                            foreach ($clientBillingHistory as $cbRec): if ($cbRec == 'success')
                                    continue;
                                ?>
                                <tr class="gradeA">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $cbRec['invoicenum'] ?> </td>
                                    <td> <?php echo $cbRec['date'] ?> </td>
                                    <td> <?php echo $cbRec['duedate'] ?> </td>
                                    <td> <?php echo $cbRec['datepaid'] ?> </td>
                                    <td> <?php echo $cbRec['subtotal'] ?> </td>
                                    <td> <?php echo $cbRec['credit'] ?> </td>
                                    <td> <?php echo $cbRec['tax'] ?> </td>
            <!--                            <td> <?php //echo $cbRec['tax2']             ?> </td>-->
            <!--                            <td> <?php //echo $cbRec['total']             ?> </td>-->
                                    <td> <?php echo $cbRec['taxrate'] ?> </td>
            <!--                            <td> <?php //echo $cbRec['taxrate2']             ?> </td>-->
                                    <td> <?php echo $cbRec['status'] ?> </td>
            <!--                            <td> <?php //echo $cbRec['paymentmethod']             ?> </td>-->
            <!--                            <td> <?php //echo $cbRec['notes']            ?> </td>-->
                                </tr>
                            <?php endforeach;
                        }//endif  ?>
                    </table>
                </div> <!-- .widget-content -->
            </div> <!-- .widget -->
        </div><!-- .grid-24 -->
    </div> <!-- .container -->
</div> <!-- #content -->