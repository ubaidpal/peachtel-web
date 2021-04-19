<style>
    label {
        display: inline-block;
    }
</style>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Cdr List', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div>
    <div class="content_holder">
        <div class="info_holder">
            <h3>Cdr : Information Below</h3>
            <hr />
            <label style="width: 300px">Rate Prefix</label><label><?php echo $cdr['CdrRate']['rate_prefix']; ?></label>
            <hr />
            <label style="width: 300px">Rate Name</label><label><?php echo $cdr['CdrRate']['rate_descr']; ?></label>
            <hr />
            <label style="width: 300px">Rate Min Duration</label><label><?php echo $cdr['CdrRate']['rate_min_duration']; ?></label>
            <hr />
            <label style="width: 300px">Rate Increment</label><label><?php echo $cdr['CdrRate']['rate_duration_incr']; ?></label>
            <hr />
            <label style="width: 300px">Rate Minute Cost</label><label><?php echo $cdr['CdrRate']['rate_minute_cost']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Prefix</label><label><?php echo $cdr['CdrRate']['vendor_route_prefix']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Name</label><label><?php echo $cdr['CdrRate']['vendor_route_descr']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Min Duration</label><label><?php echo $cdr['CdrRate']['vendor_route_min_duration']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Increment</label><label><?php echo $cdr['CdrRate']['vendor_route_duration_incr']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Minute Cost</label><label><?php echo $cdr['CdrRate']['vendor_route_minute_cost']; ?></label>
            <hr />
            <label style="width: 300px">Rate Billable Sec:</label><label><?php echo $cdr['CdrRatePostProc']['rate_bill_sec']; ?></label>
            <hr />
            <label style="width: 300px">Rate Cost:</label><label><?php echo $cdr['CdrRatePostProc']['rate_cost']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Billable Sec:</label><label><?php echo $cdr['CdrRatePostProc']['vendor_bill_sec']; ?></label>
            <hr />
            <label style="width: 300px">Vendor Route Cost:</label><label><?php echo $cdr['CdrRatePostProc']['vendor_cost']; ?></label>
            <hr />
        </div>
    </div>
</div>

