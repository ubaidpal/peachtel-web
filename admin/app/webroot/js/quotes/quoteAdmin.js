var returndata;
$(function() {
    var loader = "<img src='../images/loaders/facebook.gif' id='loader' style='float:right; margin-right: 10px;' />";
    $(".field-group select").live('change', function() {
        var selected = $(this).find('option:selected').text();
        $(this).prev("#upper").html(selected);
    });
    
    $("#newGroup").click(function() {
        $("#addGroupForm").slideToggle();
    });
    
    $("#remove").live('click', function() {
        var conf = confirm("Are you sure you want to remove this group?");
        if(conf) {
            var gid = $(this).parents().eq(1).attr('class').split(' ');
            ajaxQuery('removeProductGroup', {gid: gid[2]});
            window.location = "admin";
        }
    });
    
    $("#remove-product").live('click', function() {
        var conf = confirm("Are you sure you want to remove this product?");
        if(conf) {
            var pid = $(this).parents().eq(1).attr('id');
            ajaxQuery('removeWhmcsProduct', {pid: pid});
            window.location = "admin";
        }
    });
    
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

    $('#on_edit select').live('change', function() {
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
        $(this).prev();
    });


    $('#btn_holder select').live('change', function() {
        $(this).parents('#btn_holder').append(loader);
        var wid = $(this).parents().eq(3).attr('id');
        var val = $(this).val();
        if($(this).attr('class') == 'display_type') {
            var data = {id: wid, displayType: val};
        } else {
            var data = {id: wid, visible: val};
        }
        if(wid != '') {
            ajaxQuery('editDiplayType', data);
        }
        $('#loader').remove();
    });

    $('#v_toggle select').live('change', function() {
        var data = {id: $(this).attr('id'), wid: $(this).attr('class'), visible: $(this).val()};
        ajaxQuery('editProductVisibility', data);
    });
    
    $('textarea').live('keyup', function(e) {
    	if(e.keyCode == 13) {
    		var value = $(this).val() + "<br />\n";
    		$(this).val(value);
    		$(this).scrollTop($(this)[0].scrollHeight);
    	}
    });
    
    $('textarea').live('blur', function() {
    	var wid = $(this).parents().eq(2).attr('id');
    	var val = $(this).val();
    	var data = {id: wid, description: val};
    	ajaxQuery('editCategoryDesc', data);
    });
    
    /** Add product popup */
    $("#addProduct").live('click', function() {
        var parent = $(this).parents().eq(2);
        var parentClass = parent.attr('class').split(' ');
        var groupId = parentClass[2];
        var textHeader = parent.find("h3").html();
        
        $("#addProductForm input[name='gid']").val(groupId);
        $("#addProductForm #header").html("Add product to "+textHeader);
        $("#addProductForm").fadeIn();
        $("#overlay").show();
    });
    
    $("#close-btn").live('click', function() {
        $("#addProductForm").fadeOut();
        $("#addDatacenterForm").fadeOut();
        $("#overlay").hide();
    });
    
    $("body").live("keypress", function(e) {
        if(e.keyCode == 27) {
            $("#addProductForm").fadeOut();
            $("#overlay").hide();
        }
    });

    /** datacenter **/

    $("#dcremove").live('click', function() {
        var conf = confirm("Are you sure you want to remove this datacenter?");
        if(conf) {
            var dcid = $(this).attr('did');
            ajaxQuery('removeDatacenter', {dcid: dcid});
            window.location = "admin";
        }
    });
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