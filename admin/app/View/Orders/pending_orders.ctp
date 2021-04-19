<Style>
    .input {
        margin-bottom: 5px;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Orders</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-24">
            <div class="box" id="categories">
                <?php echo $this->Form->input('provider', array('label' => 'Provider: ', 'options' => array('All' => 'All', 'WHMCS' => 'WHMCS', 'Prestashop' => 'Prestashop'))); ?>
                <div class="widget widget-table">
                    <div class="widget-header">
                        <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Pending Orders</h3>	
                    </div>
                    <div class="widget-content">

                        <table class="table table-bordered table-striped data-table">
                            <thead>
                            <th>Order Number</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Provider</th>
                            <th>Date</th>
                            </thead>
                            <?php
                            if (!empty($whmcsPendingOrders['WHMCSAPI']['ORDERS']) || !empty($psPendingOrders)) {
                                $flag = TRUE;
                                $counter = 1;
                                if(isset($whmcsPendingOrders['WHMCSAPI']['ORDERS'])) :
                                foreach ($whmcsPendingOrders['WHMCSAPI']['ORDERS'] as $order): ?>
                                    <tr class="gradeA">
                                    <td> <?php echo $order['ORDERNUM'] ?> </td>
                                    <td>  </td>
                                    <td> $<?php echo $order['AMOUNT'] ?> </td>
                                    <td> <?php echo $order['STATUS'] ?> </td>
                                    <td><?php echo 'WHMCS' ?></td>
                                    <td> <?php echo ($order['DATE'] != '0000-00-00 00:00:00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($order['DATE'])))." Ago" : ''; ?> </td>
                                </tr>
                                <?php endforeach;
                                endif;
                                
                                $flag = TRUE;
                                $counter = 1;
                                foreach ($psPendingOrders as $order): ?>
                                    <tr class="gradeA">
                                    <td> <?php echo $order->reference ?> </td>
                                    <td> <?php echo $order->module ?> </td>
                                    <td> $<?php echo $order->total_paid_tax_incl ?> </td>
                                    <td> <?php echo 'Pending' ?> </td>
                                    <td><?php echo 'Prestashop' ?></td>
                                    <td> <?php echo ($order->date_add != '0000-00-00 00:00:00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($order->date_add)))." Ago" : ''; ?> </td>
                                </tr>
                            <?php 
                                endforeach;
                            } else { ?>
                                <tr class="gradeA">
                                    <td>No Pending Order</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php }  ?>
                        </table>
                    </div> <!-- .widget-content -->
                </div> <!-- .widget -->
            </div>
        </div>
    </div>
</div> <!-- #content -->

<script type='text/javascript'>
    $('#provider').live('change', function() {
        var val = $(this).val();
        if(val != 'All') {
            $('table tbody tr').each(function() {
                if(val != $(this).find('td:nth-child(5)').html()) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        } else {
            $('table tbody tr').show();
        }
    });
</script>