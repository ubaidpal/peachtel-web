<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    #toggle-visibility {
        background-image: url("../images/sprite/sprite-16-black.png");
        background-position: 0 -3167px;
        background-repeat: no-repeat;
        display: inline-block;
        height: 16px;
        right: 85px;
        margin-left: 0;
        margin-right: 0;
        top: 12px;
        position: absolute;
        width: 16px;
    }
    #visibility {
        position: absolute;
        right: 0px;
        color: green;
        width: 80px;
        text-align: center; 
        display: inline-block;
    }
    
    
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Quotes</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-16">
            <div class="box" id="categories">
                <?php foreach($WHMCScategories as $category) : ?>
                <div class="widget widget-table <?php echo $category['Tblproductgroup']['id'] ?>" id="<?php echo (isset($category['QbAdminCategory']['id'])) ? $category['QbAdminCategory']['id'] : ''; ?>">
                    <div class="widget-header">
                        <h3 style="margin-top: 10px;color:#454545;font-size: 16px"><?php echo $category['Tblproductgroup']['name']; ?></h3>
                        <label style="float:right; margin-top:13px; margin-right: 13px;" id='sorting2'></label>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Setup Fee</th>
                                    <th>Sort Order</th>
                                    <th>Payment Type</th>
                                    <th>Visible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($category['Tblproduct'] as $product) : ?>
                                <tr class="gradeA" id="<?php echo $product['id'] ?>">
                                    <td id="on_edit" class="Tblproduct <?php echo $product['id'] ?> name">
                                        <input style="width:250px" value="<?php echo $product['name'] ?>" type="text" /></td>
                                    <td id="on_edit" class="Tblpricing <?php echo $product['Tblpricing']['id'] ?> msetupfee">
                                        <input style="width:70px" value="<?php echo $product['Tblpricing']['msetupfee'] ?>" type="text" /></td>
                                    <td id="on_edit" class="Tblpricing <?php echo $product['Tblpricing']['id'] ?> monthly">
                                        <input style="width:70px" value="<?php echo $product['Tblpricing']['monthly'] ?>" type="text" /></td>
                                    <td>
                                        <label style="padding: 10px;"><?php echo $product['order'] ?></label></td>
                                    <td id="on_edit" class="Tblproduct <?php echo $product['id'] ?> paytype">
                                        <?php echo $this->Form->input('', array('type' => 'select', 'options' => array('onetime' => 'One-Time', 'recurring' => 'Recurring', 'free' => 'Free'), 'value' => $product['paytype'])); ?></td>
                                    <td><?php echo (1) ? "Yes" : "No"; ?><label id='sorting'></label></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div style="padding: 10px 10px 0 10px; border-top: 1px solid #D5D5D5;" id="btn_holder">
                            <label style="display:inline-block; width: 160px;">Display Type: <?php echo $this->Form->input('', array('options' => $displayType, 'value' => (isset($category['QbAdminCategory']['displayType'])) ? $category['QbAdminCategory']['displayType'] : "", 'style' => 'display:inline;', 'div' => false)); ?></label>
                            <label style="float:right; display: none; margin-left: 10px;" id="" class="update_btn">Update Sorting</label>
                            <label style="float:right; display: none;" id="" class="save_changes">Save Changes</label>
                        </div>
                        <hr style="margin-bottom: 10px;" />
                        <div style="padding: 0 10px 10px 10px; border-bottom: 1px solid #D5D5D5;">
                            <?php echo !empty($category['QbAdminCategory']['description']) ? $category['QbAdminCategory']['description'] : "No Decsription"; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="grid-8">
            <div class="box form">
                <!---provvv-->
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-article"></span>
                        <h3>Create new product</h3>
                    </div> <!-- .widget-header -->

                    <div class="widget-content">
                        <div id="grid-12" style="margin-left:19px"> 
                            <b>Notes: </b>
                            <hr style="margin:5px 0 5px 0;" />
                            Update Sorting: Drag each item to update sorting.
                            <br />
                            Editing Values: Fields can be edited inline.
                            <hr style="margin: 5px 0 5px 0;" />
                            
                            <div class="field-group">
                                <label for="brandname">Select Type:</label>
                                <div class="field" >
                                    <div class="selector" id="uniform-cardtype"style="width:140px;">
                                        <span id="upper" style="-moz-user-select: none;width:111px;"><?php echo "Hosting Account"; ?></span>
                                        <select>
                                        <option value="hostingaccount">Hosting Account</option>
                                        <option value="reselleraccount">Reseller Account</option>
                                        <option value="server">Dedicated/VPS Server</option>
                                        <option value="other">Other Product/Service</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field-group">
                                <label for="required">Product Name:</label>
                                <div class="field">
                                    <input type="text" id="product" size="20"  placeholder="Enter Product Name" style="width:150; border-radius:5px" /> 	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<script>
var returndata;
var loader = "<img src='../images/loaders/facebook.gif' id='loader' style='float:right; margin-right: 10px;' />";
$('tbody').sortable({
    update: function (e, ui) {
        $(this).parents('.widget-content').find('.update_btn').fadeIn('slow');
    }
});

$('#categories').sortable({
    update: function (e, ui) {
        var data = {};
        $('#categories .widget').each(function(i) {
            var dataOptions = $(this).attr('class').split(' ');
            var pid = dataOptions[2];
            data[i] = {id: pid, order: i + 1};
        });

        ajaxQuery('updateProductSort', data);
    }
});

$('.update_btn').live('click', function() {
    var sorting = {};
    $(this).parents('.widget-content').find('table tbody tr').each(function(i) {
        sorting[i] = {id: $(this).attr('id'), order: i};
        $(this).find('td').eq(3).html(i);
    });
    
        var url = "updateSort",
        data = sorting;
        ajaxQuery(url, data);
        $('.update_btn').fadeOut('slow')
});

$('td input').live('keyup', function() {
    $(this).parents('.widget-content').find('#btn_holder .save_changes').fadeIn('slow')
});

$('td select').live('change', function() {
    $(this).parents('.widget-content').find('#btn_holder .save_changes').fadeIn('slow')
});

$('.save_changes').live('click', function() {
    var input = {},
    dataOptions,
    index = 0;
    $(this).parents('.widget-content').find('table tbody tr').each(function(i) {
            $(this).find('td#on_edit').each(function(j) {
                dataOptions = $(this).attr('class').split(' ');
                input[index] = {model: dataOptions[0], mfield: dataOptions[2], id: dataOptions[1], value: $(this).find('input, select').val()};
                index++;
        });
    });
    $(this).parents('#btn_holder').append(loader);
    ajaxQuery('saveFields', input);
    
    $(this).fadeOut('slow');
    
    $('#loader').remove();
});

$('.field select').live('click', function() {
    $(this).prev()
});


$('#btn_holder select').live('change', function() {
    var wid = $(this).parents().eq(3).attr('id');
    if(wid != '') {
        var val = $(this).val();
        var data = {id: wid, displayType: val};
        ajaxQuery('editDiplayType', data);
    }
});

function ajaxQuery(url, data) {
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        async : false,
        success: function(rdata) {
            returndata = rdata;
        }
    });
}
</script>