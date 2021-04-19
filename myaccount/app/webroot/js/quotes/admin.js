/**
 * Pre Defined variables
 */

var returndata;
var isUrl;
var loader = "<img src='../images/loaders/indicator-big.gif' id='loader' style='margin: 20% 40% 10% 40%; height: 40px' />";
var loader2 = "<img src='../images/loaders/indicator-big.gif' id='loader' style='margin: 30% 40% 10% 47%; height: 40px' />";
var loader3 = "<img src='../images/loaders/indicator-big.gif' id='loader' style='height: 40px; margin:auto; display:block;' />";
var centerloader = "<img src='../images/loaders/facebook.gif' id='loader' style='margin-left: 10px;' />";
var $window = $(window);
var selectedProducts;
var selectedDevices;
var totalMFee = 0;
var totalOTFee = 0;
var totalPrice = 0;
var isValidLoc = false;
var config_index;
/**
 *
 *  ----------------------------------------------------- Quotetool Process -------------------------------------------
 *  
 */

$('#quote_nav li:nth-child(3)').live('click', function() {
    $('#quoteList').toggle('fast');
});

$('#alert3 button').live('click', function() {
    $('#overlay').fadeOut();
    $('#alert3').fadeOut();
    window.location.reload();
});

$('#product-services .remove-item').live('click', function() {
    if($(this).attr('class') == 'icon-remove remove-item') {
        if(confirm('Are you sure you want to remove this item?')) {
            var pid = $(this).attr('id');
            $('#pbx-holder .inputs #'+pid).val('');
            $('#pbx-holder .inputs #'+pid).prop('checked', false);
            $('#pbx-holder .inputs #'+pid+' option').removeAttr('selected');
        } else {
            exit;
        }
    }
    $('#product-services').html(loader);
    var data = Quote.getProducts();
    selectedProducts = data;
    
    ajaxQuery('addProduct', data);
    $('#product-services').html(returndata);

    totalCheckOut();
});

$('#add_devices, #devices .remove-item').live('click', function() {
    if($(this).attr('class') == 'icon-remove remove-item') {
        if(confirm('Are you sure you want to remove this device?')) {
            var did = $(this).attr('id');
            $('#devices-holder .inputs #'+did).val('');
            ajaxQuery('removeProduct', {id: did});
        } else {
            exit;
        }
    }
    addDevices();
});

$('#pbx-holder input[type="text"]').live('blur', function() {
    Quote.updateProductItems();
});

$('#pbx-holder select').live('change', function() {
    $(this).next('label').find('#configHolder').remove();
    /**
    if($(this).hasClass('did') && $(this).val() > 0) {
        Quote.DIDconfig($(this));
    }
    **/
    Quote.updateProductItems();
});

$('#pbx-holder input[type="radio"], input[type="hidden"]').live('click', function() {
    Quote.updateProductItems();
});

/** DID Config */
$("#configDID").live('click', function() {
    config_index = $(".config").index($(this));

    var selectDID = $(this).parents().eq(1).prev("select");
    var DIDid = selectDID.attr('id');
    var data = {did: DIDid, line: selectDID.val()};
    ajaxQuery('configureDid', data);
    $(".grid-16").append(returndata);
    $("#phone_search_form").dialog({
        title: "Select DIDs / Phone Numbers",
        width: 400,
        position: ['50%', 150],
        modal: true,
        draggable: false,
        resizable: false,
        close: Quote.closeDialog
    });
});

$("#search_did").live('change', function() {
    $.ajax({
        url: "getDIDCountries",
        type: "POST",
        data: {did_type: $(this).val()},
        async : false,
        success: function(rdata) {
            $("#search_country").html(rdata);
        }
    });
});

$("#search_country").live('change', function() {
    $.ajax({
        url: "getDIDStates",
        type: "POST",
        data: {country_id: $(this).val(), did_type: $("#search_did").val()},
        async : false,
        success: function(rdata) {
            $("#search_states").html(rdata);
        }
    });
});

$("#findNumberBtn").live('click', function() {
    $("#found-numbers").html(loader3);
    var data = {country: $("#search_country").val(), state: $("#search_states").val(), did: $("#did").val(), did_type: $("#search_did").val()};
    ajaxQuery('setPhoneNumbers', data);
    $("#found-numbers").html(returndata);
    $('#browser').treeview({
        animated: "fast",
		persist: "location",
		collapsed: true,
		unique: true
	});
});

$(".hitarea").live('click', function() {
    var li = $(this).parent('li');
    if($(this).hasClass('collapsable-hitarea') && li.find('ul').html() == '') {
        var type = $("#search_did").val();
        var data = {id: li.attr('id'), did_type: type};
        ajaxQuery('getDIDArea', data);
        li.find('ul').css('display', 'block').html(returndata);
    }
});

$("ul#browser input[type='checkbox']").live('click', function() {
	var did = $("#did").val();
	var select = $(".select-"+did);
	var maxNumber = $("#line").val();
	var selectedNumberCount = 0;
	
	if($(this).prop('checked')) {
		selectedNumberCount = Quote.addRemoveNumber('add', did, $(this).val());
		if(selectedNumberCount > maxNumber) {
			var isPlusOne = confirm("You have reached allowed number, Do you want to add one more number?");
			if(isPlusOne) {
				$("#line, select#"+did).val(selectedNumberCount).change();
				maxNumber++;
			} else {
				$(this).prop('checked', false);
				selectedNumberCount = Quote.addRemoveNumber('remove', did, $(this).val());
			}
		}
	} else {
		selectedNumberCount = Quote.addRemoveNumber('remove', did, $(this).val());
	}

	if(selectedNumberCount == maxNumber) {
		if(select.next("label").find("#configHolder label").attr('style') == undefined) {
			select.next("label").find("#configHolder").append("<label style='background: url(../images/sprite/sprite-12-black.png) repeat scroll 0 -1892px transparent;  display: inline-block; height: 12px; width: 12px; margin: 0 0 -1px 6px;' />");
			select.addClass('configured');
		}
	} else {
		select.next("label").find("#configHolder label").remove();
		select.removeClass('configured');
	}
});

$(".ui-tabs-nav li:last-child").live('click', function() {
    $("#config-numbers").html(loader3);
    var data = {};
    ajaxQuery('configureSelectedDids', data);
    $("#config-numbers").html(returndata);
});

/** Review Quote */
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
        $('#review_quote_container').dialog({title: 'View Quote', width: 875, height: 600, position: 'top', resizable: false, modal: true});
    } else {
        alert('Error: Cannot process, Please try again.');
    }
});

$('#saveQuote').live('click', function() {
    ajaxQuery('checkSession', {});

    if(returndata)
        Quote.savedQuotes('');
    else
    	Quote.showFOrm('quote');

});

$('#visitcheckout-link-holder h1 a').live('mouseover', function() {
    $(this).animate({
        color: '#000'
    }, 300);
}).live('mouseout', function() {
    $(this).animate({
        color: '#0F2EEA'
    }, 300);
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
    $(".checkoutReview").attr("id", "review");
	var isConfig = Quote.checkDIDConfig();
	if(!isConfig) {
		alert("Please configure your DIDs before continuing.");
		return;
	}
	
    ajaxQuery('checkSession', {});
    if(returndata) {
        Quote.savedQuotes('checkout');
        if($('#TblclientQuotesKey').val() != '') {
            $('.brochure').hide();
            $('.checkout_form').fadeIn();
            $('#TblclientQuotesKey').val(returndata);
        }
    } else {
    	Quote.showFOrm('checkout');
    }
});

$("#GoogleCheckOutBtn").live('click', function() {
    if($("#carrier_holder").css('display') == 'block') {
        var selectedMethod = $('#carrier_details input[type="radio"]').filter(':checked');
        if(selectedMethod.val() != undefined)
            Quote.showCheckoutReview(selectedMethod, 'google');
        else
            alert('Please select a shipping method before proceeding.');
    } else {
        Quote.showCheckoutReviewNoShip('google');
    }
})

$('#PaypalCheckOutBtn').live('click', function() {
    if($("#carrier_holder").css('display') == 'block') {
        var selectedMethod = $('#carrier_details input[type="radio"]').filter(':checked');
        if(selectedMethod.val() != undefined)
            Quote.showCheckoutReview(selectedMethod, 'paypal');
        else
            alert('Please select a shipping method before proceeding.');
    } else {
        Quote.showCheckoutReviewNoShip('paypal');
    }

});

$('#AuthorizeCheckOutBtn').live('click', function() {
    if($("#carrier_holder").css('display') == 'block') {
        var selectedMethod = $('#carrier_details input[type="radio"]').filter(':checked');
        if(selectedMethod.val() != undefined)
            Quote.showCheckoutReview(selectedMethod, 'authorize');
        else
            alert('Please select a shipping method before proceeding.');
    } else {
        Quote.showCheckoutReviewNoShip('authorize');
    }

});

$('#proceedCheckout').live('click', function() {
    var type = $(this).attr('paytype');
    var selectedMethod = $('#carrier_details input[type="radio"]').filter(':checked');
    var shipeMethod, shippingCost, shippingDays;
    if(selectedMethod.val() != undefined) {
        shipeMethod = selectedMethod.val();
        shippingCost = selectedMethod.parent('td').next().html().replace(/[\s$]/g, '');
        shippingDays = selectedMethod.parent('td').next().next().html().replace(/[\s$()a-z]/g, '');
    }
    var total_setup;
    var url;
    var data = {
        id: $('#TblclientQuotesKey').val(),
        country: $('#TblclientCountry').val(),
        state: $('#TblclientState').val(),
        city: $('#TblclientCity').val(),
        postcode: $('#TblclientPostcode').val(),
        address1: $('#TblclientAddress1').val(),
        phonenumber: $('#TblclientPhonenumber').val(),
        purchase_insurance: $('.insurance').filter(':checked').val(),
        shipping_carrier: $('.shippingMethod').filter(':checked').val(),
        shipping_method: shipeMethod,
        shipping_cost: shippingCost,
        shipping_days: shippingDays
    };

    ajaxQuery('updateQuote', data);
    if(returndata) {
        $('#alert4').fadeOut();
        $('#overlay').fadeOut();
        $('#review_container').html('');

        if(type == 'paypal')
            url = "processCheckout/"+data.id;
        else if(type == 'google')
            url = "processGoogleCheckout/"+data.id;
        else 
            url = "processAuthorizeCheckout/"+data.id;

        window.open(url, "Ratting", "width = 980, scrollbars = 1, height = 720, 0, status = 0");
    }
});

$('#cancelCheckout').live('click', function() {
    $('#alert4').fadeOut();
    $('#overlay').fadeOut();
    $('#review_container').html('');
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
    $(".checkoutReview").attr("id", "viewQuote");
    $(".checkoutReview").attr("qid", qid);
    ajaxQuery('setShippingMethod', {qid: qid});
    var data = $.parseJSON(returndata);
    var saveData = data.SavedQuote;
    var country = (saveData.country == null) ? 'US' : saveData.country;
    var state = (saveData.state == null) ? 'NV' : saveData.state;
    $('#TblclientQuotesKey').val(saveData.id);
    $('#TblclientCountry').val(country);
    $('#TblclientState').val(state);
    $('#TblclientCity').val(saveData.city);
    $('#TblclientPostcode').val(saveData.postcode);
    $('#TblclientAddress1').val(saveData.address1);
    $('#TblclientAddress2').val(saveData.address_2);
    $('#TblclientPhonenumber').val(saveData.phonenumber);
    $('#TblclientShipCountry').val(saveData.ship_country);
    $('#TblclientShipState').val(saveData.ship_state);
    $('#TblclientShipCity').val(saveData.ship_city);
    $('#TblclientShipPostcode').val(saveData.ship_postcode);
    $('#TblclientShipAddress1').val(saveData.ship_address1);
    $('#TblclientShipAddress2').val(saveData.ship_address_2);
    $('#TblclientShipPhonenumber').val(saveData.ship_phonenumber);
    $('.brochure').hide();
    $('.checkout_form').fadeIn();
    
});

$('#TblclientCountry, #TblclientShipCountry').live('change', function() {
    if($(this).attr('id') == "TblclientCountry") {
        getCountryStates($(this).val());
    } else {
        getCountryStates($(this).val(), '1');
    }
});

$('#validate_location').live('click', function() {
    
    if($("form").valid() == false)
        exit();
    
    var status;
    var url = 'validateCheckoutAddress';
    var data = $('form').serialize();
    
    $(this).append(centerloader);
    ajaxQuery(url, data);
    
    returndata = returndata.replace(/"/g, '');
    var ret = returndata.split(':');
    if(ret[0] == 'ERROR') {
        
        $('#err_pane').hide();
        $('#err_pane').html(ret[1]+" (<a href='javascript:void(0);' id='validateLoc'>Use this location anyway</a>)");
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

    if(Quote.hasDevices() == true) {
        $("#carrier_holder").fadeIn();
    }
    $("#checkout-btn-holder").fadeIn();
    $('#loader').remove();
    $('#addrstatus').html(status);
    return false;
});

$('#validateLoc').live('click', function() {
    var isUse = confirm('Are you sure you want to use this address?');
    if(isUse) {
        $('#err_pane').fadeOut();
        isValidLoc = true;
        $('#addrstatus').html(' (Ok)');
    }
});

$('.shippingMethod').live('click', function() {
    if(isValidLoc == true) {    
        var url = 'getShippingMethod';
        var data = $("#DatacenterQuoteToolForm").serialize();
        $("#carrier_details").prepend(centerloader);
        ajaxQuery(url, $("#DatacenterQuoteToolForm").serialize());
        //ajaxQuery(url, {addData: data, address: $('#TblclientAddress1').val(), city: $('#TblclientCity').val(), state: $('#TblclientState').val(), postcode: $('#TblclientPostcode').val(), country: $('#TblclientCountry').val(), insurance: $('.insurance').filter(':checked').val(), phonenumber: $('#TblclientPhonenumber').val(), quotekey: $('#TblclientQuotesKey').val(), shipper: $(this).val()});
        $("#carrier_details").html(returndata);
    } else {
        alert('Please validate your address before proceeding.');
    }
});

$("#TblclientUseAddress").live("click", function() {
    if($(this).is(":checked")) {
        $("#shipAddress").fadeOut();
        $("#shipAddress .text input").val("");
    } else {
        $("#shipAddress").fadeIn();
    }
});

$('#cancel').live('click', function() {
    $('.checkout_form').hide();
    $('.brochure').fadeIn();
});

$('#newQuote').live('click', function() {
    $("#overlay").show();
    $("#alert6").fadeIn();
    isUrl = ($(this).attr('url') == true) ? '?admin=1' : '';
});

$("#newcancel").live('click', function() {
   $("#overlay").hide();
   $("#alert6").fadeOut();
});

$("#proceed").live('click', function() {
   Quote.newQuote();
});

$('#useAddr').live('click', function() {
    $("#addresses .checkbox input").prop("checked", false);
    $(this).prop("checked", true);
    var addr = $(this).attr('data').split('/');
    
    $('#TblclientCountry').val(addr[0]);
    $('#TblclientCity').val(addr[2]);
    $('#TblclientState').val(addr[1]);
    $('#TblclientPostcode').val(addr[3]);
    $('#TblclientAddress1').val(addr[4]);
    $('#TblclientPhonenumber').val(addr[5]);
    
    $("#validate_location").click();
});

$("#orderNumbers").live('click', function() {
    var data = {};
    ajaxQuery('configureDid', data);
    $(".grid-16").append(returndata);
    $("#phone_search_form").dialog({
        title: "Select DIDs / Phone Numbers",
        width: 700,
        position: ['50%', 80],
        modal: true,
        resizable: false,
        close: Quote.closeDialog
    });
});

/******************************************** TEMPORARY FUNCTION ************/
$("#checkOutBtn").live('click', function() {
	$('#checkOut').click();
	$("#phone_search_form").dialog('close');
});

/******************************************** END TEMPORARY FUNCTION ************/

/** function JQUERY */

Quote = {
    newQuote: function() {
        ajaxQuery('psLogDelete', {});
        location.href = 'quote_tool'+isUrl;
    },
    hasDevices: function() {
        ajaxQuery('checkHasDevices', {qid: $("#TblclientQuotesKey").val()});
        return returndata;
    },
    DIDconfig: function(select) {
        var didId = select.attr('id');
        select.next('label').append("<span id='configHolder'> - <a href='javascript:void(0);' id='configDID' class='config'>Configure</a></span>")
    },
    getProducts: function() {
        var data = {};
        $('.item-category').each(function(i) {
            var categoryId = $(this).attr('id');
            var pData = {};
            $(this).find('.inputs').each(function() {
                if($(this).find('input').val() != '' || $(this).find('select').val() != '') {
                    var type = $(this).find('.product, input').prop('tagName');
                    if(type == 'INPUT') {
                        switch($(this).find('input').attr('type')) {

                            case "text":
                            case "hidden":
                                var input = $(this).find('input');
                                if(input.val() != 0) {
                                    var pid = input.attr('id');
                                    var count = input.val();
                                    pData[pid] = count;

                                    if(input.attr('is_pbx') == 1)  {
                                        var selected = 'ATL';
                                        selected = $('.datacenter').filter(':checked').val();
                                        pData[pid] = {count: 1, datacenter: selected};
                                    }
                                }
                            break;
                            case "radio":
                                var value = $(this).find('label').html().split(' ');
                                var input = $(this).find('input');
                                if(value[1] != '0.00') {
                                    if(input.attr('checked') == "checked") {
                                        var pid = input.attr('id');
                                        var count = 1;
                                        pData[pid] = count;
                                    }
                                }

                            break;
                        }
                    } else {
                        switch(type) {
                            case "SELECT":
                                var select = $(this).find('select');
                                select.prev("div#select_skin").find("div#select_value").html(select.val());
                                if(select.val() != 0) {
                                    var pid = select.attr('id');
                                    var count = select.val();
                                    pData[pid] = count;
                                }
                            break;
                        }
                    }
                }
            });
            data[categoryId] = pData;
        });

        return data;
    },
    updateProductItems: function() {
        $('#product-services').html(loader);
        var data = Quote.getProducts();
        selectedProducts = data;

        ajaxQuery('addProduct', data);
        $('#product-services').html(returndata);
        totalCheckOut();
    },
    savedQuotes: function(method) {
    	var isConfig = Quote.checkDIDConfig();
    	if(!isConfig) {
    		alert("Please configure your DIDs before continuing.");
    		return;
    	}
    		
        var totalItems = {method: method, onetime_fee: totalOTFee, total_price: totalPrice, recurring_fee: totalMFee};
        
        ajaxQuery('saveQuote', totalItems);

        if(returndata == 'invalid') {
            alert('Please select an item to proceed.');
        } else if(returndata) {
            if(method != '') {
                $('#TblclientQuotesKey').val(returndata);
            } else {
                $('#alert3').show();
                $('#overlay').show();
            }
        } else {
            alert('Error: Cannot process, Please try again.');
        }
    },
    closeDialog: function() {
        $("#phone_search_form").remove();
    },
    addRemoveNumber: function(method, did, nid) {
    	var data = {method: method, did: did, nid: nid};
    	ajaxQuery('addRemoveNumber', data);
    	
    	return parseInt(returndata);
    },
    checkDIDConfig: function() {
    	var isDIDsConfigured = true;
    	$("select.did").each(function() {
    		if($(this).val() > 0) {
	    		if($(this).hasClass('configured')) 
	    			isDIDsConfigured = true;
	    		else {
	    			isDIDsConfigured = false;
	    			return false;
	    		}
    		}
    	});
    	
    	return true;
    	/** DISABLED TEMPORARILY **/
    	//return isDIDsConfigured;
    },
    showFOrm: function(redirect) {
        $('#error_msg').hide();
        $('#login_panel2 input[type=text], #login_panel2 input[type=password]').val('');
        $('#UserRedirect').val(redirect);
        $('#login_panel2').fadeIn();
        $('#overlay').show();
    },
    showCheckoutReview: function(selectedMethod, paytype) {
        var sMethod = ($('.shippingMethod').filter(':checked').val() == 1) ? "UPS" : "Fedex";
        var append = "<div>\n\
                    <label>Country: </label><br />\n\
                        <label>"+$('#TblclientCountry').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>State: </label><br />\n\
                        <label>"+$('#TblclientState').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>City: </label><br />\n\
                        <label>"+$('#TblclientCity').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Post Code: </label><br />\n\
                        <label>"+$('#TblclientPostcode').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Address: </label><br />\n\
                        <label>"+$('#TblclientAddress1').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Phonenumber: </label><br />\n\
                        <label>"+$('#TblclientPhonenumber').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Purchase Insurance: </label><br />\n\
                        <label>"+$('.insurance').filter(':checked').val()+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Shipping Carrier: </label><br />\n\
                        <label>"+sMethod+"</label>\n\
                    </div>\n\
                    <div>\n\
                        <label>Shipping Method: </label><br />\n\
                        <label>"+selectedMethod.val()+"</label>\n\
                    </div>";
            
        $('#review_container').html(append);
        $('#alert4 #alertActions #proceedCheckout').attr('paytype', paytype);
        $('#alert4').show();
        $('#overlay').show();
    },
    showCheckoutReviewNoShip: function(paytype) {
        var append = "<div>\n\
            <label>Country: </label><br />\n\
                <label>"+$('#TblclientCountry').val()+"</label>\n\
            </div>\n\
            <div>\n\
                <label>State: </label><br />\n\
                <label>"+$('#TblclientState').val()+"</label>\n\
            </div>\n\
            <div>\n\
                <label>City: </label><br />\n\
                <label>"+$('#TblclientCity').val()+"</label>\n\
            </div>\n\
            <div>\n\
                <label>Post Code: </label><br />\n\
                <label>"+$('#TblclientPostcode').val()+"</label>\n\
            </div>\n\
            <div>\n\
                <label>Address: </label><br />\n\
                <label>"+$('#TblclientAddress1').val()+"</label>\n\
            </div>\n\
            <div>\n\
                <label>Phonenumber: </label><br />\n\
                <label>"+$('#TblclientPhonenumber').val()+"</label>\n\
            </div>";
        $('#review_container').html(append);
        $('#alert4 #alertActions #proceedCheckout').attr('paytype', paytype);
        $('#alert4').show();
        $('#overlay').show();
    }
}

/**
 *
 *  ----------------------------------------------------- functions -------------------------------------------
 *  
 */

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

function addDevices() {
    $('#devices').html(loader);
    ajaxQuery('addDevices', {});
    $('#devices').html(returndata);
    
    totalCheckOut();
}

function totalCheckOut() {
    var tPrice = parseFloat(totalPrice),
        tFee = parseFloat(totalMFee),
        tCharge = parseFloat(totalOTFee),
        total,
        totalPayment;
        
    $('#total').html(loader);
    $('#total').attr('style', 'padding: 10px 0; text-align: right;');
    
    /** Total Payment*/
    totalPayment = tPrice + tFee + tCharge;
    totalPayment = Math.round(totalPayment * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = totalPayment.toFixed(2).split(".");
    totalPayment = "$" + p[0].split("").reverse().reduce(function(acc, totalPayment, i, orig) {
        return  totalPayment + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    /** Total Monthly*/
    total =  tFee;
    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = total.toFixed(2).split(".");
    var total = "$" + p[0].split("").reverse().reduce(function(acc, total, i, orig) {
        return  total + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    /** Total One time*/
    tCharge = tPrice + tCharge;
    tCharge = Math.round(tCharge * Math.pow(10, 2)) / Math.pow(10, 2);
    
    var p = tCharge.toFixed(2).split(".");
    var tCharge = "$" + p[0].split("").reverse().reduce(function(acc, tCharge, i, orig) {
        return  tCharge + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
    
    
    if(1) {//tCharge != '$0.00' || total != '$0.00') {
        $('#total').html("<label>Total One Time: <h3 style='color: green;'>"+tCharge+"</h3></label>\n\
                        <label>Total Monthly: <h3 style='color: green;'>"+total+"</h3></label>\n\
                        <div style='text-align:center; margin-top:10px; padding-top:10px;border-top:1px solid #d5d5d5;'>\n\
                        <label>Total Due Now: </label>\n\
                        <h2 style='color: green;'>"+totalPayment+"</h2>\n\
                        </div>");
    } else {
        /** Changed display of Free products */
        //$('#total').html('');
        //$('#total').attr('style', '');
    }
}

function getCountryStates(cid, isShip = 0) {
    ajaxQuery('getCountryStates', {cid: cid});
    if(isShip) {
        $('#TblclientShipState').html(returndata);
    } else {
        $('#TblclientState').html(returndata);
    }
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