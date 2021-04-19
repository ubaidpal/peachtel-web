<?php 
echo $this->Html->script('jquery.validate');
?>
<style>
    #form_container {
        border-radius: 5px 5px 0 0;
        border: 1px solid #D5D5D5;
    }
    #form_header {
        background: -moz-linear-gradient(center top , #FFFFFF 0%, #EEEEEE 100%) repeat scroll 0 0 transparent;
        border-radius: 5px 5px 0 0;
        padding: 10px 10px;
        border-bottom: 1px solid #D5D5D5;
    }
    
    #form_header h2 {
        padding: 0;
        margin: 0;
    }
    
    #form_content {
        padding: 15px;
    }
    .input input {
      margin-right: 10px; 
    }
    .input label:nth-child(1) {
        display: inline-block;
        width: 100px;
        margin-bottom: 10px;
    }
    .error {
        color: red;
    }
    
    .error-handler {
        display:none;
        background: none repeat scroll 0 0 #FFFFDD;
        padding: 2px 5px;
        margin-bottom: 10px;
        border: 1px solid #D5D5D5;
    }
    
    label.error {
        background: none repeat scroll 0 0 #FFFFDD;
        border: 1px solid #D5D5D5;
        padding: 2px;
    }
    
    #flashMessage {
        margin-left: 256px;
        position: absolute;
        z-index: 9999;
        color: red;
    }
    
    select {
        width: 170px;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Accounts</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-16">
            <div class="box" id="categories">
                <div id="form_container">
                    <div id="form_header"><h2>Create New Account</h2></div>
                    <div id="form_content">
                        <br />
                        <h2>Personal Information</h2>
                        <?php echo $this->Form->create(); ?>
                        <?php echo $this->Form->input('firstname', array('type' => 'text', 'class' => 'required letters')); ?>
                        <?php echo $this->Form->input('lastname', array('type' => 'text', 'class' => 'required letters')); ?>
                        <?php echo $this->Form->input('companyname', array('type' => 'text', 'class' => 'required', 'minLength' => 10)); ?>
                        <?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'required email')); ?>
                        <?php echo $this->Form->input('phonenumber', array('type' => 'text', 'class' => 'required number')); ?>
                        <?php echo $this->Form->input('password2', array('type' => 'password', 'class' => 'required', 'minLength' => 8)); ?>
                        <hr />
                        <h2>Address Information</h2>
                        <div class="error-handler"></div>
                        <?php echo $this->Form->input('address1', array('type' => 'text', 'class' => 'required')); ?>
                        <?php echo $this->Form->input('city', array('type' => 'text', 'class' => 'required')); ?>
                        <?php echo $this->Form->input('state', array('type' => 'select', 'class' => 'required', 'empty' => '-- State --', 'options' => $states)); ?>
                        <?php echo $this->Form->input('postcode', array('type' => 'text', 'class' => 'required', 'minLength' => 5)); ?>
                        <hr />
                        <?php echo $this->Form->end('Create'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<script>
    
    jQuery.validator.addMethod("letters", function(value, element) {
        var validFormat;
        validFormat = /^[a-zA-Z]+$/.test(value)
        return this.optional(element) || validFormat;
    }, "Only letters are allowed");
    
    $('form').validate();
    $('.submit input').click(function() {
        var isError = false;
        if($('form').valid()) {
            $.ajax({
                type: "POST",
                url: "validateLocation",
                data: $('form').serialize(),
                async: false,
                success: function(returndata) {
                    returndata = returndata.replace(/"/g, '');
                    var ret = returndata.split(':');
                    if(ret[0] == 'ERROR') {
                        $('.error-handler').fadeOut();
                        $('.error-handler').html(ret[1] + " - <a href='javascript:void(0);' id='saveForm'>Continue</a> saving information.");
                        $('.error-handler').fadeIn();
                        isError = true;
                    } else {
                        var addInfo = ret[0].split('&');
                        var newInfo = {};
                        for(var i = 0; i < addInfo.length; i++) {
                            var add = addInfo[i].split('=');
                            newInfo[i] = {};
                            newInfo[i]['field'] = add[0];
                            newInfo[i]['value'] = add[1];
                        }
                        
                        $("#TblclientAddress1").val(newInfo[0]['value']);
                        $("#TblclientCity").val(newInfo[2]['value']);
                        $("#TblclientState").val(newInfo[3]['value']);
                        $("#TblclientPostcode").val(newInfo[4]['value']);

                        isError = false;
                    }
                }
            });
            if(isError) {
                return false;
            }
            return true;
        }
    });
    
    $('#saveForm').live('click', function() {
        $('form').submit();
    });
</script>