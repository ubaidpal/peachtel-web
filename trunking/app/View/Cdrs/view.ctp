<style>
    label {
        display: inline-block;
    }
</style>
<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to Cdr List', '/', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div>
    <div class="content_holder">
        <div class="info_holder">
            <h3>Cdr : Information Below</h3>
            <hr />
            <label style="width: 300px">ID</label><label><?php echo $cdr['Cdr']['id']; ?></label>
            <hr />
            <label style="width: 300px">Source</label><label><?php echo $cdr['Cdr']['src']; ?></label>
            <hr />
            <label style="width: 300px">Destination</label><label><?php echo $cdr['Cdr']['dest']; ?></label>
            <hr />
            <label style="width: 300px">CallID</label><label><?php echo $cdr['Cdr']['call_id']; ?></label>
            <hr />
            <label style="width: 300px">SipCode</label><label><?php echo $cdr['Cdr']['sip_code']; ?></label>
            <hr />
            <label style="width: 300px">SipReason</label><label><?php echo $cdr['Cdr']['sip_reason']; ?></label>
            <hr />
            <label style="width: 300px">StartTime</label><label><?php echo $cdr['Cdr']['start_time']; ?></label>
            <hr />
            <label style="width: 300px">AnswerTime</label><label><?php echo $cdr['Cdr']['answer_time']; ?></label>
            <hr />
            <label style="width: 300px">ProgressIndTime</label><label><?php echo $cdr['Cdr']['progress_ind_time']; ?></label>
            <hr />
            <label style="width: 300px">EndTime</label><label><?php echo $cdr['Cdr']['end_time']; ?></label>
            <hr />
            <label style="width: 300px">Duration</label><label><?php echo $cdr['Cdr']['duration_sec']." sec"; ?></label>
            <hr />
            <label style="width: 300px">PostAnswerDuration</label><label><?php echo $cdr['Cdr']['post_answer_duration_sec']." sec"; ?></label>
            <hr />
            <label style="width: 300px">Vector</label><label><?php echo $cdr['Cdr']['vector']; ?></label>
            <hr />
            <label style="width: 300px">RoutingTarget</label><label><?php echo $cdr['Cdr']['routing_target']; ?></label>
            <hr />
            <label style="width: 300px">AppliedRateID</label><label><?php echo $cdr['Cdr']['applied_rate_id']; ?></label>
            <hr />
            <label style="width: 300px">VendorRouteID</label><label><?php echo $cdr['Cdr']['vendor_route_id']; ?></label>
            <hr />
            <label style="width: 300px">Customer</label><label><?php echo $cdr['Customer']['descr']; ?></label>
            <hr />
            <label style="width: 300px">Customer BG</label><label><?php echo $cdr['BillingGroup']['descr']; ?></label>
            <hr />
            <label style="width: 300px">Vendor</label><label><?php echo $cdr['Vendor']['descr']; ?></label>
            <hr />
        </div>
    </div>
</div>
