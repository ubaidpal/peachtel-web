var macAddr = '';
var brandName = '';
var friendlyName = '';
var friendlyNameVal = '';
var loader = "<img src='../images/loaders/facebook.gif' alt = 'Loading...' id = 'fr_lodr' style = 'display: none'/>";
var globalData = '';
var isModal = false;

$(function() {
    setAddRegsTabs();
    
    $('#required').live('focus', function() {
        $(this).val('');
        $('#error_display2').fadeOut('slow');
        $('#error_display').fadeOut('slow');
    });
    
    $('select').live('change', function() {
        var name = $(this).val();
        var list = ['frendlyname', 'phone_opt', 'DropDownTimezone', 'registrations', 'nat_traversal', 'rport_enable', 'udp_keep_alive_enable'];
        if($.inArray($(this).attr('id'), list) != -1) {
            name = $(this).find("option:selected").text();
        }
        
        $(this).prev('#upper').html(name);
    });
    
    $('.modalTemplate select').live('change', function() {
        name = $(this).find("option:selected").text();
        $(this).prev('#upper').html(name);
    });
    
    $('#local_port').live('keyup', function() {
        if(!/^[0-9]+$/.test($(this).val())) {
            $('#error_display_local_port').show();
        } else {
            $('#error_display_local_port').hide('slow');
        }
    })
    
    $('.brandname').live('change', function() {
        var url = 'sendFriendlyNames';
        var data = {brand: $(this).val()}
        var opt = '';
        ajaxQuery(url, data);
        
        $('#frendlyname').html('');
        var count = 0;
        $.each($.parseJSON(globalData), function(index, value) {
            if(count == 0) {
                $('#frendlyname').prev('#upper').html(value);
                $('#frendlyname').append("<option value='"+(index)+"' selected='selected'>"+value+"</option>");
            }
            $('#frendlyname').append("<option value='"+(index)+"'>"+value+"</option>");
            count++;
        });
    });
    
    $('#local_port, #extension').live('keyup', function() {
        var provisioned_phones = $('#provisioned_phones').find('div:last-child');
        provisioned_phones.find("."+$(this).attr('id')).html($(this).val()+"&nbsp;");
    });
    
    $('#close, #reset').live('click', function() {
        $("#overlay").hide();
        $("#modal").hide('slow');
        $(".modalEdit").fadeOut('slow');
        $(".modalTemplate").fadeOut('slow');
        $("#modal input[type='text']").val('');
        $("#phone_opt").html('');
        $('#error_display_local_port').hide('slow');
        
        if(isModal) {
            $('#provisioned_phones').find('div:last-child').remove();
        }
        
        $('#div2 input[type="text"], #div2 input[type="password"]').val('');
    });
    
    $('#registrations').live('change', function() {
        
        var div2 = $(this).parents().eq(5).next('#div2');
        var tblCount = div2.find('table').length;
        var childIndex = tblCount + 1;
        var numForm = $(this).val() - 1;
        var tblIndex = 0;
        var newTblIndex = 0;
        var appendForm = '';
        
        if($(this).val() == tblCount) {
            return;
        }
        
        if(numForm < tblCount) {
            var notString = '';
            if($(this).val() > 1) {
                for(var k = 0; k < $(this).val(); k++) {
                    var ind = k + 2;
                    if(ind <= $(this).val())
                        notString += ':nth-child('+ind+'), ';
                    else
                        notString += ':nth-child('+ind+')';

                    appendForm += '<table width="420" border="0" cellspacing="2" cellpadding="2" id="reg_table">'+div2.find('.line-1').html()+'</table>';
                }
            } else {
                notString = ':nth-child(2)';
            }
            div2.find('table').not(notString).remove();

        } else {
            var loop = numForm - tblCount + 1;
            for(var j = 0; j < loop; j++) {
                appendForm += '<table width="420" border="0" cellspacing="2" cellpadding="2" id="reg_table">'+div2.find('.line-1').html()+'</table>';
            }
            appendForm = appendForm.replace(/value=".*?"/g, '');
            div2.append(appendForm);
        }
        
        div2.find('table').each(function(i) {
            $(this).find('#reg_num1').html(i + 1);
            $(this).find('#reg_val').val(i + 1);
            $(this).find('input, select').each(function(j) {
                var newName = $(this).attr('name').replace(/[0-9]+/, i);
                $(this).attr('name', newName);
            });
        });
    });
    
    $('#hide_alert2').live('click', function() {
        $('#alert2').fadeOut('slow');
        $("#overlay").hide();
    });
    
    $('#close_alert, #hide_alert').live('click', function() {
        $("#overlay").hide();
        $("#alert").hide('slow');
    });
    
    $('#submit').live('click', function() {
        var url = 'savePhoneData';
        var data = $(this).closest('#phone_data_form').serialize();
        
        ajaxQuery(url, data);
        if(globalData != false && globalData != true) {
            var provisioned_phone = $('#provisioned_phones').find('div:last-child');
            provisioned_phone.find(".delete-brand").attr('mac_id', globalData);
            $('#div2 input[type="text"], #div2 input[type="password"]').val('');
            $("#overlay").hide();
            $("#modal").hide();

        } else if(globalData == true) {
            $('#div2 input[type="text"], #div2 input[type="password"]').val('');
            $("#overlay").hide();
            $(".modalEdit").hide('slow');
            return;
        } else {
            alert('Failed request.');
        }
    });
    
    $('.edit-mac').live('click', function() {
        var url = "editMac";
        var data = {macId: $(this).attr('mac_id')};
        ajaxQuery(url, data);
        $('.modalEdit').html(globalData);  
        $("#overlay").show();
        $('.modalEdit').show();
    });
    
    
    $('.edit-template').live('click', function() {
        var url = "editTemplate";
        var data = {macId: $(this).attr('mac_id')};
        ajaxQuery(url, data);
        $('.modalTemplate #modalContent').html(globalData);
        $("#overlay").show();
        $('.modalTemplate').show();
        
        $('.modalTemplate table').hide();
        var tables = $('.modalTemplate table');
        tables.hide();
        tables.eq(0).show();
        var j = 1;
        var links = '';
        
        tables.each(function(i) {
            var title = $(this).find('h1').html();
            links += '<li><a href="javascript:void(0);" id="'+title+'">'+title+'</a></li>';
            var title = $(this).attr('id', title);
            $(this).find('h1').remove();
            j++;
        });
        
        $(".modalTemplate #reg_header ul").html(links);
    });
    
    $('.modalTemplate #reg_header a').live('click', function() {
        var table = $(this).attr('id');
        $('.modalTemplate table').hide();
        $('table[id="'+table+'"]').show('slow');
        
    });
    
    $('.delete-brand').live('click', function() {
        $('#alert').show();
        $("#overlay").show();
        $('#delete_mac_id').val($(this).attr('mac_id'));
    });
    
    $('#confirmly_delete').live('click', function() {
        var url = "deleteMac";
        var data = {macId: $('#delete_mac_id').val()};
        ajaxQuery(url, data);
        
        if(globalData) {
            $('#alert').hide('slow');
            $("#overlay").hide();
            $('span[mac_id="'+$('#delete_mac_id').val()+'"]').parent().remove();
        } else {
            alert("Failed request");
        }
    });
    
    $(document).keyup(function(e) {
        if(e.keyCode  == 27) {
            if(isModal) {
                $('#provisioned_phones').find('div:last-child').remove();
                isModal = false;
            }
            
            $("#overlay").hide();
            $('#alert').fadeOut('slow');
            $("#modal").fadeOut('slow');
            $(".modalEdit").fadeOut('slow');
            $(".modalTemplate").fadeOut('slow');
            $('#alert2').fadeOut('slow');
        }
    });
    
    $('.modalAdd #reg_header ul li a').live('click', function() {
        var table = $('.modalAdd #div2 table');
        table.hide();
        table.eq($(this).attr('id')).show('slow');
    });

    $('.modalAdd #registrations').live('change', function() {
        setAddRegsTabs();
    });
    
    $('#displayname').live('keyup', function(){
        var displayName = $(this).val();
        $(this).parents('table').find('#username').val(displayName);
        $(this).parents('table').find('#authname').val(displayName);
    });
});

function savePhone(validate) {
    
    macAddr = $('#required').val();
    brandName = $('#brandname').val();
    friendlyName = $('#frendlyname option:selected').text();
    friendlyNameVal = $('#frendlyname').val();
    isModal = true;
    
    if(validate) {
        
        var url = 'check_mac_addr';
        var data = {mac : macAddr, f_name: friendlyNameVal }
        ajaxQuery(url, data);

        var isRegistered = globalData;
        
        if(macAddr.length < 12) {
            $('#error_display2').fadeIn();

            return false;
        } else if(!$('#required').val().match(/^[a-zA-Z0-9]{12}$/g)) {
            $('#error_display').fadeIn();

            return false;
        } else if(isRegistered == true) {
            
            $('#alert2').show();
            $("#overlay").show();
            return false;
        }
    }

    $("#modal").show();
    $("#overlay").show();

    var provisioned_phones = $('#provisioned_phones').find('div');
    var phone;
    
    $("#phone_opt").append("<option value='0'>"+(brandName +" "+ friendlyName)+"</option>");
    $("#phone_opt").prev('#upper').html(brandName +" "+ friendlyName);
    
    
    provisioned_phones.each(function(index) {
        phone = $(this).find('span:nth-child(3)').html().split(' - ');
        $("#phone_opt").append("<option value='"+(index + 1)+"'>"+phone[0]+"</option>");
    });
    
    phoneCount = provisioned_phones.length;
    var newPhone = '<div id="phone'+phoneCount+'"><span id="'+phoneCount+'" class="icon-trash-fill delete-brand" style="cursor: pointer;"></span>&nbsp&nbsp&nbsp&nbsp<span id="edit'+phoneCount+'" class="icon-pen-alt2" style="cursor: pointer;"> </span>&nbsp&nbsp&nbsp&nbsp&nbsp<span id="text'+phoneCount+'">'+brandName+' '+friendlyName+' - MAC Address: '+macAddr+'</span> - Ext: <span id="ext'+phoneCount+'" class="local_port"></span>on <span id="host'+phoneCount+'" class="extension" ></span></div>';
    $('#provisioned_phones').append(newPhone);
    
    $('#DropDownTimezone').prev('#upper').html($('#DropDownTimezone').find("option[value='5.0']").text());
    $('#DropDownTimezone').find("option[value='5.0']").attr('selected', 'selected');
    
    $('#mac_add').html(macAddr);
    $('#mac_addr').val(macAddr);
    $('#brandname_form').val(brandName);
    $('#friendlyname_form').val(friendlyNameVal);
}

function setAddRegsTabs() {
    var table = $('.modalAdd #div2 table');
    table.hide();
    table.eq(0).show();
    var j = 1;
    var links = '';
    table.each(function(i) {
        links += '<li><a href="javascript:void(0);" id="'+i+'">Registration '+j+'</a></li>';
        j++;
    });
    $(".modalAdd #reg_header ul").html(links);
}


function ajaxQuery(url, data) {
    $.ajax({
        type: 'POST',
        async: false,
        url: url,
        data: data,
        success: function(response){
            globalData = response;
        }
    });
}