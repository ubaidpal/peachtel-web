var returndata;
var loader = "<img src='../images/loaders/indicator-big.gif' id='loader' style='margin: 20% 40% 10% 40%; height: 40px' />";
var loader2 = "<img src='../images/loaders/indicator-big.gif' id='loader' style='margin: 30% 40% 10% 47%; height: 40px' />";
var centerloader = "<img src='../images/loaders/facebook.gif' id='loader' />";
var $window = $(window);
var selectedProducts;
var selectedDevices;
var totalMFee = 0;
var totalOTFee = 0;
var totalPrice = 0;
var isValidLoc = false;


/**
 *
 *  ----------------------------------------------------- Quotetool Process -------------------------------------------
 *  
 */

$('#viewQuotes').live('click', function() {
    $('#quoteList').slideToggle('slow');
});

$('#alert3 button').live('click', function() {
    $('#overlay').fadeOut();
    $('#alert3').fadeOut();
    window.location = 'quote_tool';
});

$('#pbx-link').live('click', function() {
    $('#product-holder').hide();
    $('#devices-holder').hide();
    $('#pbx-holder').fadeIn('slow');
});

$('#devices-link').live('click', function() {
    $('#pbx-holder').hide();
    $('#product-holder').hide();
    $('#devices-holder').fadeIn('slow');
});

$('#product-link').live('click', function() {
    $('#devices-holder').hide();
    $('#pbx-holder').hide();
    $('#product-holder').fadeIn('slow');
});

$('#reg_header li a').live('click', function() {
    $('#reg_header ul li').removeClass('selected');
    $(this).parents().eq(1).addClass('selected');
});

$('.viewDevices').live('click', function() {
    var mdiv = $(this).attr('class').split(' ');
    
    $('.manufacturer_holder').hide();
    $('#'+mdiv).fadeIn();
});

$('#add_selected, #product-services .remove-item').live('click', function() {
    if($(this).attr('class') == 'icon-remove remove-item') {
        if(confirm('Are you sure you want to remove this item?')) {
            var pid = $(this).attr('id');
            $('#product-holder .inputs #'+pid).val('');
        } else {
            exit;
        }
    }
    $('#product-services').html(loader);
    var data = getProducts();
    selectedProducts = data;
    
    ajaxQuery('addProduct', data);
    $('#product-services').html(returndata);

    totalCheckOut();
});

$('#add_devices, #devices .remove-item').live('click', function() {
    if($(this).attr('class') == 'icon-remove remove-item') {
        var did = $(this).attr('id');
        $('#devices-holder .inputs #'+did).val('');
    }
    
    $('#devices').html(loader);
    var dData = getDevices();
    selectedDevices = dData;
    
    ajaxQuery('addDevices', {devices: dData});
    $('#devices').html(returndata);
    
    totalCheckOut();
});

$('#product-holder input[type="text"]').live('blur', function() {
    updateProductItems();
});

$('#devices-holder input[type="text"]').live('blur', function() {
    $('#devices').html(loader);
    var dData = getDevices();
    selectedDevices = dData;
    
    ajaxQuery('addDevices', {devices: dData});
    $('#devices').html(returndata);
    updateProductItems();
});

$('#product-holder input[type="radio"]').live('click', function() {
    updateProductItems();
});


$('#review, #print').live('click', function() {
    $('#review_quote_container').html(loader2);
    var pdata = selectedProducts;
    var dData = selectedDevices;
    
    var totalItems = {product: pdata, devices: dData};
    ajaxQuery('reviewQuote', totalItems);
    $('#review_quote_container').html(returndata);
    if(returndata != false) {
        if($(this).attr('id') == 'review') {
            $('#review_quote_container').dialog({
                title: 'Review Quote',
                width: 775,
                height: 600,
                position: 'top',
                resizable: false,
                modal: true
            });
        } else {
            var myWindow = window.open('','');
            myWindow.document.write(returndata);
            myWindow.document.write("<script>window.print()<\/script>");
        }
    } else {
        alert('Please select an item to proceed.');
    }
});

$('#viewQuote').live('click', function() {
    var qid = $(this).attr('qid');
    ajaxQuery('view_quote/'+qid, {});
    if(returndata) {
        $('#review_quote_container').html(returndata);
        $('#review_quote_container').dialog({
            title: 'View Quote',
            width: 875,
            height: 600,
            position: 'top',
            resizable: false,
            modal: true
        });
    } else {
        alert('Error: Cannot process, Please try again.');
    }
});

$('#saveQuote').live('click', function() {
    savedQuotes('');
});

$('#item-slider').selectToUISlider({
    tooltip:false,
    sliderOptions: {
        animate:true,
        change:function(e, ui) {
            var selectedOption = $(this).parent('.inputs').find('#item-slider option').eq(ui.values[0]);
            if(ui.values[0] == 0) {
                $(this).parent('.inputs').find('input.sliderVal').val(0);
                $('#datacenters').fadeOut();
            } else {
                $(this).parent('.inputs').find('input.sliderVal').val(1);
                $('#datacenters').fadeIn();
            }
            $(this).parent('.inputs').find('input.sliderVal').attr('id', selectedOption.attr('id'));
            $(this).parent('.inputs').find('label').html(selectedOption.text());
            $(this).parent('.inputs').find('label#price-holder').html("$ "+selectedOption.attr('pricing'));
            updateProductItems();
        }
    }
}).hide();


$('#datacenters input').live('click', function() {
    updateProductItems();
});
/**
 *
 *  ----------------------------------------------------- Checkout process -------------------------------------------
 *  
 */

$('#TblclientCountry, #TblclientState, #TblclientCity, #TblclientPostcode, #TblclientAddress1').live('change', function() {
    isValidLoc = false;
});

$('#checkOut').live('click', function() {
    savedQuotes('checkout');
    if($('#TblclientQuotesKey').val() != '') {
        $('.brochure').hide();
        $('.checkout_form').fadeIn();
        $('#TblclientQuotesKey').val(returndata);
    }
});

$('.checkout_form .submit input').live('click', function() {
    var selectedMethod = $('#carrier_details input[type="radio"]').filter(':checked');
    
    if(selectedMethod.val() != undefined) {
        var total_setup;
        var data = {
            id: $('#TblclientQuotesKey').val(),
            country: $('#TblclientCountry').val(),
            state: $('#TblclientState').val(),
            city: $('#TblclientCity').val(),
            postcode: $('#TblclientPostcode').val(),
            address1: $('#TblclientAddress1').val(),
            phonenumber: $('#TblclientPhonenumber').val(),
            purchase_insurance: $('.insurance').filter(':checked').val(),
            onetime_fee: totalOTFee,
            total_price: totalPrice,
            recurring_fee: totalMFee,
            shipping_carrier: $('.shippingMethod').filter(':checked').val(),
            shipping_method: selectedMethod.val(),
            shipping_cost: selectedMethod.parent('td').next().html().replace(/[\s$]/g, ''),
            shipping_days: selectedMethod.parent('td').next().next().html().replace(/[\s$()a-z]/g, '')
        };

        ajaxQuery('updateQuote', data);
        if(returndata) {
            window.open("processCheckout/"+data.id, "Ratting", "width = 980, height = 720, 0, status = 0");
        }
    } else {
        alert('Please select a shipping method before proceeding.');
    }
    return false;
});

$("#updateQuote").live('click', function() {
    var data = {
        id: $('#TblclientQuotesKey').val(),
        country: $('#TblclientCountry').val(),
        state: $('#TblclientState').val(),
        city: $('#TblclientCity').val(),
        postcode: $('#TblclientPostcode').val(),
        address1: $('#TblclientAddress1').val(),
        phonenumber: $('#TblclientPhonenumber').val(),
        purchase_insurance: $('.insurance').filter(':checked').val(),
        onetime_fee: totalOTFee,
        total_price: totalPrice,
        recurring_fee: totalMFee,
        shipping_carrier: $('.shippingMethod').filter(':checked').val(),
        status: "update_for_shipment"
    };
    ajaxQuery('updateQuote', data);
    if(returndata) {
        $('#err_pane').hide();
        $('#err_pane').html('Quote has been updated, You can continue the checkout process after maintenance. Thank You.');
        $('#err_pane').fadeIn();
    }
    
    setTimeout(function(){window.location = 'quote_tool';}, 3000);
});

$('#updateShippingMethod').live('click', function(){
    var qid = $(this).attr('qid');
    
    ajaxQuery('setShippingMethod', {qid: qid});
    var data = $.parseJSON(returndata);
    
    $('#TblclientQuotesKey').val(data.SavedQuote.id);
    $('#TblclientCountry').val(data.SavedQuote.country);
    $('#TblclientState').val(data.SavedQuote.state);
    $('#TblclientCity').val(data.SavedQuote.city);
    $('#TblclientPostcode').val(data.SavedQuote.postcode);
    $('#TblclientAddress1').val(data.SavedQuote.address1);
    $('#TblclientPhonenumber').val(data.SavedQuote.phonenumber);
    
    $('.brochure').hide();
    $('.checkout_form').fadeIn();
});

$('#TblclientCountry').live('change', function() {
    
    getCountryStates($(this).val());
});

$('#validate_location').live('click', function() {
    $(this).append(centerloader);
    var status;
    var url = 'validateCheckoutAddress';
    var data = $('form').serialize();
    ajaxQuery(url, data);
    
    returndata = returndata.replace(/"/g, '');
    var ret = returndata.split(':');
    if(ret[0] == 'ERROR') {
        
        $('#err_pane').hide();
        $('#err_pane').html(ret[1]);
        $('#err_pane').fadeIn();
        
        isValidLoc = false;
        status = ' (Invalid)';
    } else {
        
        var addInfo = ret[0].split('&');
        var newInfo = {};
        for(var i = 0; i < addInfo.length; i++) {
            var add = addInfo[i].split('=');
            newInfo[i] = {};
            newInfo[i]['field'] = add[0];
            newInfo[i]['value'] = add[1];
        }

        getStateCountry(newInfo[3]['value']);
        $("#TblclientCountry").val(returndata);
        getCountryStates(returndata);
        $("#TblclientAddress1").val(newInfo[0]['value']);
        $("#TblclientCity").val(newInfo[2]['value']);
        $("#TblclientState").val(newInfo[3]['value']);
        $("#TblclientPostcode").val(newInfo[4]['value']);
        $('#err_pane').hide();
        isValidLoc = true;
        status = ' (Ok)';
    }
    $('#loader').remove();
    $('#addrstatus').html(status);
    return false;
});

$('.shippingMethod').live('click', function() {
    if(isValidLoc == true) {    
        $("#carrier_details").prepend(centerloader);
        var url = 'getShippingMethod';
        var addr1 = $('#TblclientAddress1').val();
        var city = $('#TblclientCity').val();
        var state = $('#TblclientState').val();
        var postcode = $('#TblclientPostcode').val();
        var country = $('#TblclientCountry').val();
        var insurance = $('.insurance').filter(':checked').val();
        var phonenumber  = $('#TblclientPhonenumber').val();
        var quotekey  = $('#TblclientQuotesKey').val();
        
        ajaxQuery(url, {address: addr1, city: city, state: state, postcode: postcode, country: country, insurance: insurance, phonenumber: phonenumber, quotekey: quotekey, shipper: $(this).val()});
        
        $("#carrier_details").html(returndata);
    } else {
        alert('Please validate your address before proceeding.');
    }
});

$('#cancel').live('click', function() {
    $('.checkout_form').hide();
    $('.brochure').fadeIn();
});

/**
 *
 *  ----------------------------------------------------- functions -------------------------------------------
 *  
 */

function savedQuotes(method) {
    if(selectedProducts != undefined || selectedDevices != undefined) {
        var totalItems = {
            product: selectedProducts, 
            devices: selectedDevices, 
            method: method,
            onetime_fee: totalOTFee,
            total_price: totalPrice,
            recurring_fee: totalMFee
        };
        ajaxQuery('saveQuote', totalItems);
        if(returndata) {
            if(method != '') {
                $('#TblclientQuotesKey').val(returndata);
            } else {
                $('#alert3').show();
                $('#overlay').show();
            }
        } else {
            alert('Error: Cannot process, Please try again.');
        }
    } else {
        alert('Please select atleast one item to proceed.');
    }
}

function updateProductItems() {
    $('#product-services').html(loader);
    var data = getProducts();
    selectedProducts = data;

    ajaxQuery('addProduct', data);
    $('#product-services').html(returndata);
    totalCheckOut();
}

function getProducts() {
    var data = {};
    $('.item-category').each(function(i) {
        var categoryId = $(this).attr('id');
        //data[i][categoryId] = 12;
        var pData = {};
        $(this).find('.inputs').each(function() {
            if($(this).find('input').val() != 0 && $(this).find('input').val() != '') {
                switch($(this).find('input').attr('type')) {
                    
                    case "text":
                    case "hidden":
                        var pid = $(this).find('input').attr('id');
                        var count = $(this).find('input').val();
                        pData[pid] = count;
                        
                        if($(this).find('input').attr('is_pbx') == true)  {
                            var selected = 'ATL';
                            selected = $('#datacenters input').filter(':checked').val();
                            pData[pid] = {count: 1, datacenter: selected};
                        }
                        
                    break;
                    case "radio":
                        var value = $(this).find('#price-holder').html().replace(/[\s$]/g, '');
                        if(value != '0.00') {
                            if($(this).find('input').attr('checked') == "checked") {
                                var pid = $(this).find('input').attr('id');
                                var count = 1;
                                pData[pid] = count;
                            }
                        }
                        
                    break;
                }
            }
        });
        data[categoryId] = pData;
    });
    
    return data;
}

function getDevices() {
    var dData = {};
    $('#devices-holder div .inputs').each(function(i) {
        var did = $(this).find('input').attr('id');
        var count = $(this).find('input').val();
        
        if(count > 0 && count != '') {
            dData[did] = count;
        }
    });
    
    return dData;
}

function totalCheckOut() {
    var tPrice = parseFloat(totalPrice),
        tFee = parseFloat(totalMFee),
        tCharge = parseFloat(totalOTFee),
        total,
        totalPayment;
        
    $('#total').html(loader);
    $('#total').attr('style', 'padding: 10px; border-top: 1px solid #D5D5D5; text-align: right; background: #fff;');
    
    /** Total Payment*/
    totalPayment = tPrice + tFee + tCharge;
    totalPayment = Math.round(totalPayment * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = totalPayment.toFixed(2).split(".");
    totalPayment = "$" + p[0].split("").reverse().reduce(function(acc, totalPayment, i, orig) {
        return  totalPayment + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    /** Total Monthly*/
    total = tPrice + tFee;
    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = total.toFixed(2).split(".");
    var total = "$" + p[0].split("").reverse().reduce(function(acc, total, i, orig) {
        return  total + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    /** Total One time*/
    tCharge = Math.round(tCharge * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = tCharge.toFixed(2).split(".");
    var tCharge = "$" + p[0].split("").reverse().reduce(function(acc, tCharge, i, orig) {
        return  tCharge + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    
    if(tCharge != '$0.00' || total != '$0.00') {
        $('#total').html("<label>Total Set Up Fee: <h3 style='color: green;'>"+tCharge+"</h3></label><hr />\n\
                        <label>Total Item Fee: <h3 style='color: green;'>"+total+"</h3></label>\n\
                        <hr />\n\
                        <div style='text-align:center; margin-top:10px;'>\n\
                        <label>Total Due</label>\n\
                        <h2 style='color: green;'>"+totalPayment+"</h2>\n\
                        </div>");
    } else {
        $('#total').html('');
        $('#total').attr('style', '');
    }
}

function getCountryStates(cid) {
    ajaxQuery('getCountryStates', {cid: cid});
    $('#TblclientState').html(returndata);
}

function getStateCountry(siso) {
    ajaxQuery('getStateCountry', {siso: siso});
}

function closeWindow() {
    window.location = 'quotes_tool';
}

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