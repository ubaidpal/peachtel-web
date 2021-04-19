<style>
.bg_main_container {
    padding: 10px;
    border: 3px solid #d5d5d5;
}
    
th {
    line-height: 25px !important;
    height: 25px !important;
}

td {
    padding: 5px !important;
}

.ui-datepicker td {
    padding: 1px !important;
}

.search_date input {
    width: 100px;
}
    
.search_date {
    width: 99%;
}
.table_title h4 {
    display: inline-block;
    line-height:0;
}

#editCostDestDialog label {
    display: inline-block;
    width: 100px;
}

.did_form {
    border-left:1px solid #d2d2d2;
    border-right: 1px solid #d2d2d2;
    padding: 10px;
    display:none;
}

.did_form .input {
    margin-top: 10px;
}

.did_form label{
    display: inline-block;
    width: 120px;
    vertical-align: top;
}

.did_form input{
    display: inline-block;
    vertical-align: top;
}
</style>
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $header = "Home";
    $status = (!empty($clientTrunkData['Customer']['active'])) ? '1' : '0';
    $countActive = 0;
    $countInActive = 0;
?>
<div id="content">	
    
    <div id="contentHeader">
        <h1>Trunking</h1>
    </div> <!-- #contentHeader -->
    
    <div class="container">
        
        <div class="trunking_main_holder">
            
            <div class="trunking_content">
                
                <div class="box">
                    
                    <div class="label_capt table_title"><h4>Trunking Status:</h4>
                        <label class="activeInactiveImg"><?php echo $this->itaki->isActive($clientTrunkData['Customer']['active']); ?> <span class="activeInactive">[<?php echo $this->Html->link('Change', 'javascript:void(0)', array('id' => 'changeStatus', 'status' => $status)); ?>]</span></label>
                    </div>
                    
                    <!-- Credit Balance's table -->
                    <div class="label_capt table_title"><h4>Credit Balance:</h4>
                        <label class="credit_ctrl_bal">

                            <?php 
                                $val1 = $clientTrunkData['MasterBillingGroup']['id'];
                                if(!empty($clientTrunkData['MasterBillingGroup']['CreditControll'])) {
                                    $val3 = $clientTrunkData['MasterBillingGroup']['CreditControll']['credit_bal'];
                                } else {
                                    $val3 = '';
                                }
                            ?>
                            <?php echo (!empty($clientTrunkData['MasterBillingGroup']['CreditControll'])) ? $clientTrunkData['MasterBillingGroup']['CreditControll']['credit_bal'] : "0.00"; ?>&nbsp;
                            <?php echo $this->Html->link('[Credit/Debit]', 'javascript:void(0);', array('id' => 'addDebitBal', 'bg_id' => $val1, 'c_bal' => $val3)); ?>
                        </label>
                    </div>
                    <!-- End Credit Balance's -->
                        
                    <div class="label_capt table_title table_capt" style="border-bottom:none; padding-top: 10px"><h4>Billing Group's List:</h4> [<?php echo $this->Html->link('Add', 'javascript:void(0)', array('id' => 'addBillingGroupBtn')); ?>]</div>
                    
                    <div style="min-height: 300px; max-height: 576px;overflow: auto;">
                    <?php foreach($clientTrunkData['MasterBillingGroup']['BillingGroup'] as $bg) : ?>
                    <div class="bg_main_container">
                        <!-- Billing Group table -->
                        <table cellspacing="0" id="bg_container">
                            <tr>
                                <th>Name</th>
                                <th width="200px">Channel Limit</th>
                                <th width="250px">Proxy Media</th>
                            </tr>
                            <tr id="bg_id_<?php echo $bg['id']; ?>">
                                <td id="descr"><?php echo $bg['descr']; ?></td>
                                <td id="c_limit"><?php echo $bg['channel_limit']; ?></td>
                                <td id="p_media" class="<?php echo ($bg['proxy_media'] == 1) ? 1: 0; ?>"><?php echo $this->itaki->isActive($bg['proxy_media'])." ".$this->Html->link('Change', 'javascript:void(0);', array('id' => 'changeProxyStatus')); ?></td>
                            </tr>

                        </table>
                        (Note: Double Click the selected cell to change the value.)
                        <!-- End Billing Group table -->
                        
                        <!-- Subscriber's table -->
                        <div class="label_capt table_title table_capt"><h4>Subcriber's List:</h4> [<?php echo $this->Html->link('Toggle', 'javascript:void(0);', array('class' => 'subs')); ?>]</div>
                        <table cellspacing="0" id="subs_table">
                            <tr>
                                <th>Username</th>
                                <th width="250px">Password</th>
                                <th width="250px">Domain</th>
                            </tr>
                            <?php if(!empty($bg['Subscriber'])) : ?>
                            <?php foreach($bg['Subscriber'] as $subcr) : ?>
                            <tr id="sb_id_<?php echo $subcr['id']; ?>">
                                <td id="uname"><?php echo ($subcr['username']) ? $subcr['username'] : '&nbsp;'; ?></td>
                                <td id="pass"><?php echo ($subcr['password']) ? $subcr['password'] : '&nbsp;'; ?></td>
                                <td id="domain"><?php echo ($subcr['domain']) ? $subcr['domain'] : '&nbsp;'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr id="nodata">
                                <td>No Data Found.</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php endif; ?>
                        </table>
                        (Note: Double Click the selected cell to change the value.)
                        <!-- End Subscriber's table -->
                        
                        <!-- Fraud Control's -->
                        <div class="label_capt table_title"><h4>Fraud Control:</h4> <?php echo (!empty($bg['FraudCtrlPref'])) ? "Thresh Cost: ".$bg['FraudCtrlPref']['hc_minute_cost_thresh']." - Max Calls: ".$bg['FraudCtrlPref']['max_hc_calls_simult']." [".$this->Html->link('edit', 'javascript:void(0);', array('onClick' => 'edit_fraud('.$bg['FraudCtrlPref']['customer_bg_id'].');'))."]" : 'Thresh Cost: 0.00 - Max Calls: 0'?></div><!-- label_capt table_title -->
                        <!-- End Fraud Control's -->
                    </div>
                    <br />
                    <?php endforeach; ?>
                    </div>

                    <hr />
                    <!-- DID Routes table -->
                    <div class="label_capt table_title table_capt">
                        <h4>DID Routes:</h4>&nbsp;
                        [<span><a href="javascript:void(0);" id="show_did_form">Add DID</a></span>]
                    </div>
                    <div class="did_form">
                        <?php
                            echo $this->form->create('admintool', array('action' => 'addDID'));
                            echo $this->form->input('prefix', array('type' => 'textarea', 'label' => 'DID:<br />One per Line.<br /> Format:<br />eg: 1XXXXXXXXXX'));
                            //echo $this->form->input('did_type', array('type' => 'select', 'options' => array("LI" => "LI", "ELS" => "ELS","TOLLFREE" => "Toll Free","CANADIAN" => "Canadian")));
                            echo $this->form->input('per_min', array('type' => 'text'));
                            echo $this->form->input('monthly_fee', array('type' => 'text'));
                            echo $this->form->input('setup_fee', array('type' => 'text'));
                            echo $this->form->input('trunk', array('type' => 'select', 'options' => $customerBGs));
                            echo $this->form->end("Add");
                        ?>
                    </div>
                    <div style="min-height: 100px; max-height: 500px;overflow: auto;">
                    <table cellspacing="0" style="margin:0;">
                        <tr>
                            <th>Name</th>
                            <th width="200px">Billing Group</th>
                            <th width="250px">Prefix</th>
                            <th width="150px">Active</th>
                            <th width="150px">Cost Destination</th>
                        </tr>
                        <?php if(!empty($routes)) { ?>
                        <?php foreach($routes as $route) {
                            if($route['OriginationRoute']['active'] == "t") {
                                $countActive++;
                            } else { 
                                $countInActive++;
                            }
                        ?>
                        <tr orid="<?php echo $route['OriginationRoute']['id']?>">
                            <td><?php echo $route['OriginationRoute']['descr']; ?></td>
                            <td class="changeBilling"><?php echo $route['BillingGroup']['descr']; ?></td>
                            <td><span class="pref"><?php echo $route['OriginationRoute']['prefix']; ?></span> [<?php echo $this->Html->link('Add', 'javascript:void(0);', array('onClick' => 'addDeletePrefix("add", "'.$route['OriginationRoute']['id'].'", this)'))." - ".$this->Html->link('Delete', 'javascript:void(0);', array('onClick' => 'addDeletePrefix("delete", "'.$route['OriginationRoute']['id'].'", this)')); ?>]</td>
                            <td><span><?php echo $this->itaki->isActive($route['OriginationRoute']['active']); ?></span> (<a href="javascript:void(0);" id="didStatusBtn">Change</a>)</td>
                            <?php if(isset($route['OriginationRouteCostDest'])): ?>
                            <td><a id="editCostDest" cid="<?php echo $route['OriginationRouteCostDest']['orig_route_id']; ?>" href="javascript:void(0);">Edit</a></td>
                            <?php endif; ?>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td>No Data Found.</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php } ?>
                    </table>
                    </div>
                    <div style="font-weight: bold;">
                        <?php echo "(".$countActive." active - ".$countInActive." inactive".")" ?>
                        <br />
                        (Note: Double Click Billing Group cell to change the Billing Group.) 
                    </div>
                    <!-- End DID Routes table -->
                        
                    <!-- Cdr's table -->
                    <div class="label_capt table_title" style="margin-top:20px;"><h4>Call Detail Records:</h4>&nbsp;</div><!-- label_capt table_title -->
                    <div class="search_date">
                        <?php echo $this->form->input('start_time', array('div' => false, 'label' => 'Start Date: ', 'value' => date('Y/m/d'))); ?>
                        <?php echo $this->form->input('end_time', array('div' => false, 'label' => 'End Date: ', 'value' => date('Y/m/d'))); ?>
                        <?php echo $this->form->input('search', array('type' => 'button', 'id' => 'search_btn','div' => false, 'label' => false)); ?>
                        <?php echo $this->form->input('billing_groups', array('type' => 'select', 'options' => $customerBGs, 'empty' => '-All-', 'id' => 'bg_select', 'div' => false, 'label' => 'Billing Groups: ')); ?>
                        <?php echo $this->form->input('vector', array('type' => 'select', 'options' => array('1' => 'Inbound', '2' => 'Outbound'), 'empty' => '-All-', 'id' => 'vec_select', 'div' => false, 'label' => 'Call Type: ')); ?>
                    </div><!-- search_date -->
                    <div style="min-height: 100px; max-height: 500px;overflow: auto;">
                    <table style="min-height: 100px;" cellspacing="0" id="cdr_container">
                        <tr>
                            <th>Start Time</th>
                            <th>Billing Group</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th>Duration</th>
                            <th>Sip Reason</th>
                        </tr><!-- cdr_container -->
                        
                        <?php if(!empty($clientTrunkData['Cdr'])) : ?>
                        
                        <?php foreach($clientTrunkData['Cdr'] as $cdr) : ?>
                        <tr>
                            <td><?php echo ($cdr['start_time']) ? $cdr['start_time'] : '&nbsp;'; ?></td>
                            <td vector="<?php  echo $cdr['vector'] ;?>"><?php echo ($cdr['customer_bg_id']) ? $cdr['customer_bg_id'] : '&nbsp;'; ?></td>
                            <td><?php echo ($cdr['src']) ? $cdr['src'] : '&nbsp;'; ?></td>
                            <td><?php echo ($cdr['dest']) ? $cdr['dest'] : '&nbsp;'; ?></td>
                            <td><?php echo ($cdr['duration_sec']) ? $cdr['duration_sec'] : '&nbsp;'; ?></td>
                            <td><?php echo ($cdr['sip_reason']) ? $cdr['sip_reason'] : '&nbsp;'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php else: ?>
                        <tr>
                            <td>No Data Found.</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    </div>
                    <!-- End Cdr's table -->
                    
                </div> <!-- .box -->
            </div> <!-- .trunking_content -->
        </div> <!-- .trunking_main_holder -->
    </div> <!-- .container -->
    
</div> <!-- #content -->
<?php echo $this->element('dialog'); ?>
<div id="editCostDestDialog" style="display: none;">
    <?php 
        echo $this->Form->create('admintool', array('action' => 'updateCostDest'));  
        echo $this->Form->input('orig_route_id', array('type' => 'hidden'));
        echo $this->Form->input('priority');
        echo $this->Form->input('class_dest');
        echo $this->Form->input('final');
        echo $this->Form->end('Update');
    ?>
</div>
<script>
    
var globalData;
var loader = "<img src='../images/loaders/facebook.gif' id='loader' />";
$(function() {
    $('.subs').live('click', function(e) {
        var subsTable = $(this).parents().eq(0).next('#subs_table');
        subsTable.slideToggle();
    });
    
    $('#start_time, #end_time').datepicker({
        showOn: "button",
        buttonImage: "../js/images/calendar.gif",
        buttonImageOnly: true
    });
    
    $('#search_btn').live('click', function(e) {
        
        var startTime   = $('#start_time').val();
        var endTime     = $('#end_time').val();
        if((new Date(startTime).getTime() <= new Date(endTime).getTime()) && (startTime != '' && endTime != '')) {
            $('.search_date').append(loader);
            globalAjaxQuery('search_by_date', {cid: <?php echo $clientTrunkData['Customer']['id']; ?>, start: startTime, end : endTime});
            $("#cdr_container").html(globalData); 
            $('#loader').remove()
            
        } else {
            alert('Invalid time range.');
        }
    });
    
    $('#bg_select').change(function(e) {
        var customerBG = $(this).val();
        if(customerBG == '') {
            $("#cdr_container tbody tr").show();
        } else {
            if(<?php echo $clientTrunkData['Cdr']; ?> != '') {
                $("#cdr_container tbody tr").each(function(i) {
                    if((i > 0) && ($(this).find("td:nth-child(1)").html() != "No Data Found.")) {
                        if($(this).find("td:nth-child(2)").html() != customerBG) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    }
                });
            }
        }
    });
    
    $('#vec_select').change(function(e) {
        var vector = $(this).val();
        if(vector == '') {
            $("#cdr_container tbody tr").show();
        } else {
            if(<?php echo $clientTrunkData['Cdr']; ?> != '') {
                $("#cdr_container tbody tr").each(function(i) {
                    if((i > 0) && ($(this).find("td:nth-child(1)").html() != "No Data Found.")) {
                        if($(this).find("td:nth-child(2)").attr('vector') != vector) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    }
                });
            }
        }
    });
    
    $("#changeStatus").live("click", function() {
        var stat = ($(this).attr('status') == 1) ? '0' : '1';
        $(this).parent().append(loader);
        globalAjaxQuery('set_status', {cid: <?php echo $clientTrunkData['Customer']['id']; ?>, status: stat});
        if(globalData) {
            if(stat == 1) {
                $(".activeInactiveImg").html('Active <span class="activeInactive">[<a id="changeStatus" status="1" href="javascript:void(0)">Change</a>]</span>');
                //$(".activeInactiveImg img").attr('src', '../images/icons/active.png');
                $(this).attr('status', '1');
            } else {
                $(".activeInactiveImg").html('Inactive <span class="activeInactive">[<a id="changeStatus" status="0" href="javascript:void(0)">Change</a>]</span>');
                //$(".activeInactiveImg img").attr('src', '../images/icons/inactive.png');
                $(this).attr('status', '0');
            }
        } else {
            alert('Error: Unable to update status.');
        }
        $("#loader").remove();
    });
    
    $('#addBillingGroupBtn').live('click', function(e) {
        var confirmed = confirm("Create new Billing Group?");
        if(confirmed) {
            $(this).parent().append(loader);
            var data = {cid: <?php echo $clientTrunkData['Customer']['id']; ?>, billing_target_id : <?php echo $clientTrunkData['MasterBillingGroup']['id']; ?>};
            globalAjaxQuery('add_billing_group', data);
            if(globalData) {
                alert("New Billing Group Added.");
            } else {
                alert("Failed to add new Billing Group.");
            }
            window.location.reload();
        }
    });
    
    /** Field Edit Billing Group's Table */
    $('#bg_container tr td').live('dblclick', function(e) {
        var eValue;
        var input;
        
        if($(this).attr('class') != 'on-select') {
            switch($(this).attr('id')) {
                //case "descr" :
                case "c_limit" :
                    eValue = $(this).html();
                    input = "<input type='text' class='edit_input' value='"+eValue+"'>";
                    break;
            }

            $(this).html(input);
            $('.edit_input').focus();
            $(this).addClass('on-select');
        }
    });
    
    $('.edit_input').live('blur', function(e) {
        var eValue;
        var bgId; 
        var fdata;
        var elem;
        var appendData;
        if($(this).attr('type') == 'text') {
            eValue  = $(this).val();
            bgId    = $(this).parents().eq(1).attr('id').split('_');
            elem    = $(this);

            if($(this).parent().attr('id') == 'descr') {
                appendData = eValue;
                fdata = {id: bgId[2], descr: eValue};
            } else {
                appendData = eValue;
                fdata = {id: bgId[2], channel_limit : eValue};
            }
            
            globalAjaxQuery('bg_update_field', fdata);
            if(globalData) {
                elem.parent().removeClass('on-select');
                elem.parent().html(appendData);
            } else {
                alert('Error: Unable to update status.');
            }
        }
    });
    
    $('#subs_table tr td').live('dblclick', function() {
        if($(this).attr('class') != 'on-select') {
            if($(this).parent().attr('id') != 'nodata') {
                var eValue = $(this).html();
                var input = "<input type='text' class='subs_edit_input' value='"+eValue+"'>";
                $(this).html(input);
                $('.subs_edit_input').focus();
                $(this).addClass('on-select');
            }
        }
    });
    
    $('.subs_edit_input').live('blur', function(e) {
        var fdata;
        
        var eValue  = $(this).val();
        var sbId    = $(this).parents().eq(1).attr('id').split('_');
        var elem    = $(this);

        if($(this).parent().attr('id') == 'uname') {
            fdata = {id: sbId[2], username: eValue};
        } else if($(this).parent().attr('id') == 'pass') {
            fdata = {id: sbId[2], password : eValue};
        } else {
            fdata = {id: sbId[2], domain : eValue};
        }

        globalAjaxQuery('subs_update_field', fdata);
        if(globalData) {
            elem.parent().removeClass('on-select');
            elem.parent().html(eValue);
        } else {
            alert('Error: Unable to update status.');
        }
    });
    
    $('#changeProxyStatus').live('click', function(e) {
        
        var pMediaVal   = ($(this).parent().attr('class') == 1) ? 0 : 1;
        var bgId        = $(this).parents().eq(1).attr('id').split('_');
        var data        = {id: bgId[2], proxy_media : pMediaVal};
        $(this).parent().append(loader);
        globalAjaxQuery('bg_update_field', data);
        if(globalData) {
            if(pMediaVal == 1) {
                $(this).parent().attr('class', 1);
                $(this).parent().html('Active <a id="changeProxyStatus" href="javascript:void(0);">Change</a>');
                //$(this).parent().find('img').attr('src', '../images/icons/active.png');
            } else {
                $(this).parent().attr('class', 0);
                $(this).parent().html('Inactive <a id="changeProxyStatus" href="javascript:void(0);">Change</a>');
               // $(this).parent().find('img').attr('src', '../images/icons/inactive.png');
            }
        } else {
            alert('Failed to update billing group.');
        }
        $('#loader').remove();
    });
    
    $("#admintoolVpref").live('change', function(e) {
        $("#admintoolPrefix").val($("#admintoolVpref option:selected").text());
    });
    
    $("#addDebitBal").click(function(){
        if($(this).attr('class') != '') {
            var bgid = $(this).attr('bg_id');
            var cbal = $(this).attr('c_bal');
            
            $('#admintoolBgId').val(bgid);
            $('#admintoolBal').val(cbal);
        }
        $('#form_dialog_credit').dialog({
            title: "Credit / Debit",
            draggable : false,
            resizable: false,
            position: "top"
        });
    });
    
    $('#editCostDest').live('click', function() {
        var cid = $(this).attr('cid');
        globalAjaxQuery('getCostDest', {id: cid});
        var data = $.parseJSON(globalData);
        $('#admintoolOrigRouteId').val(cid);
        $('#admintoolPriority').val(data.priority);
        $('#admintoolClassDest').val(data.class_dest);
        $('#admintoolFinal').val(data.final);
        
        $("#editCostDestDialog").dialog({
            title: "Edit Origination Route Cost Destination",
            draggable : false,
            resizable: false,
            position: "top"
        })
    });

    $("#show_did_form").live('click', function() {
        $(".did_form").slideToggle();
    });

    $(".changeBilling").live("dblclick", function() {
        var select = $("#admintoolTrunk").clone();
        $(this).html(select);
    });

    $(".changeBilling select").live("change", function() {
        var bgId = $(this).val();
        var bgName =$(this).find("option:selected").text();
        var orId = $(this).parent().parent().attr("orid");

        ajaxQuery("updateDidBg", {customer_bg_id: bgId, id: orId});
        $(this).parent().html(bgName);
    });

    $("#didStatusBtn").live('click', function() {
        var orId = $(this).parent().parent().attr("orid");
        var did = $(this).parent().parent().find("td .pref").html();
        var status = $(this).prev("span").html();
        var didStatus = "f";

        if(status == "Active") {
            $(this).prev("span").html("Inactive");
        } else {
            didStatus = "t";
            $(this).prev("span").html("Active");
        }
        ajaxQuery("updateDidBg", {withVendor: 1, id: orId, did: did, active: didStatus});
    });
    
    function globalAjaxQuery(url, data) {
        $.ajax({
            url: url,
            type: "POST",
            async: false,
            data: data,
            success: function(returnData) {
                globalData = returnData;
            }
        });
    }
   
});

function ajaxQuery(url, data) {
    $.ajax({
        url: url,
        type: "POST",
        async: false,
        data: data,
        success: function(returnData) {
            globalData = returnData;
        }
    });
}

function addDeletePrefix(mode, rid, ev) {
    if(mode == "delete") {
        var data = {rid: rid, method : mode};
        ajaxQuery('addDeletePrefix', data);
        if(globalData) {
            $(ev).parents().eq(1).find('.pref').html('');
        } else {
            alert('Prefix deletion failed');
        }
    } else {
        $('#admintoolId').val(rid);
        $('#form_dialog_pref').dialog({
            title: "Add Prefix:",
            draggable : false,
            resizable: false,
            position: "top"
        });
    }
}

function edit_fraud(id) {
    var data = {id: id};
    ajaxQuery('edit_fraud', data);
    $('#form_dialog_fraud').html(globalData);
    $('#form_dialog_fraud').dialog({
        title: "Fraud Controll Edit:",
        draggable : false,
        resizable: false,
        position: "center",
        width: 320
    });
}
</script>