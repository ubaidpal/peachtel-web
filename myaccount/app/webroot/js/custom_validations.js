$(function() {
    $("label.error img").live('mouseover', function() {
        var errorText = $(this).attr('title');
        $(this).parent().append("<div id='error'>"+errorText+"</div>");
    }).live('mouseout', function() {
        $(this).parent().find("div#error").remove();
    });
    
    $.validator.addMethod("zipcode", function(value, element) {
        var pattern = /^[0-9]{5}$/;
        var valid = true;
        if (!pattern.test(value)) {
            valid = false;
        }
        return (valid);
    }, "<img src='/myaccount/images/icons/warning.png' title='Invalid Zip Code.' />");
    
    $.validator.addMethod("phone", function(value, element) {
        var pattern = /^[0-9-]+$/;
        var valid = true;
        if (!pattern.test(value)) {
            valid = false;
        }
        return (valid);
    }, "<img src='/myaccount/images/icons/warning.png' title='Please insert a valid phone number.' />");
    
    /** datepicker for creditcard expiration date */
    $("#UserExpiryDate").datepicker({
        showOn: "button",
        buttonImage: "../../js/images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: 'm/y'
    });
    
    $("#UserAddContactForm, #UserChangePasswordForm, #UserAccountInformationForm, #UserUpdateCreditcardForm, #TicketOpenTicketForm").validate();
});