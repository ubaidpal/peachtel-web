<div class="widget widget-table">
    <div class="widget-header">
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
            <th>Tax Rate</th>
            <th>Status</th>
            </thead>
            <?php
            if ($clientBillingHistory["status"] == "success") {
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
                        <td> <?php echo $cbRec['taxrate'] ?> </td>
                        <td> <?php echo $cbRec['status'] ?> </td>
                    </tr>
                <?php endforeach;
            }//endif  ?>
        </table>
    </div> <!-- .widget-content -->
</div> <!-- .widget -->