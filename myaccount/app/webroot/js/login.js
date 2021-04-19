$('#loginfrm').validate();
$('#signfrm').validate();
$('.signinAjax button').live('click', function() {
    $('.signinAjax').validate();
});

$(".regWindowClose").live('click', function() {
    $.ajax({
        url: "/myaccount/users/login",
        type: "POST",
        data: {User: {username: username, password: password, type : "ajax"}},
        async: false, 
        success: function(ret) {
            window.location = "/myaccount";
            $('#alert5').fadeOut();
            $('#overlay').hide();
        }
    });
});

$("#close_btn a").live('click', function() {
    $('#login_panel').hide('slow');
    $('#login_panel2').hide('slow');
    $('#reg_panel3').hide('slow');
    $('body #overlay').hide();
});

$('#login').live('click', function() {
    $('#login_panel input[type=text], #login_panel input[type=password]').val('');
    $('#login_panel').fadeIn();
    $('#overlay').show();
});

$('body').live('keypress', function(e) {
    if(e.keyCode  == 27 && showOverlay) {
        $("#close_btn a").click();
    }
});

$('#showAjaxRegForm').live('click', function() {
    $('#login_panel2').hide();
    $('#reg_panel3').fadeIn();
});

$("#showAjaxLoginForm").live('click', function() {
    $('#reg_panel3').hide();
    $('#login_panel2').fadeIn();
});

$('.ajaxLogin').live('click', function() {
    $.ajax({
        url: "/myaccount/users/login",
        type: "POST",
        data: $('#loginformAjax').serialize(),
        async: false, 
        success: function(ret) {
            if(ret != '') {
                $('#title_login_holder').find('label:nth-child(2)').remove();
                $('#title_login_holder').append("<label style='color: #fff;'>Signed in as:<label style='margin-left: 5px; background: #fff; padding: 5px 10px;'><a href='/myaccount/users/billing' style='text-decoration: none;'>"+ ret +"</a></label></label>");
                $('#login_panel2').hide('slow');
                $('#overlay').hide();
            } else {
                $('#error_msg').html('<img src="../images/icons/info_8x16.png" style="display: inline-block;" /> Incorrect username or password.');
                $('#error_msg').fadeIn();
            }
        }
    });

    return false;
});

$.validator.addMethod("phone", function(value, element) {
    var pattern = /^([0-9\(\)\/\+ \-]*)$/;
    var valid = true;
    if (!pattern.test(value) || !(value.length > 5 && value.length <= 15)) {
        valid = false;
    }
    return (valid);
}, "Please insert a valid phone number.");