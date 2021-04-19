<?php
echo $this->Html->css('accinfo', null, array('inline' => false));
$caction = '';
$aaction = '';
$daction = '';
if($action == 'change_password') { $caction = 'selected'; } else if($action == 'accounts') { $aaction = 'selected'; } else { $daction = 'selected'; }
?>
<div id="content">	
    <div id="contentHeader">
        <h1>Account Information</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-20">
            <div id="tab">
                <div id="tab-header">
                    <ul>
                        <li class="<?php echo $daction; ?> details"><?php echo $this->Html->link('My Details', array('action' => "account_information")); ?></li>
                        <li class="<?php echo $aaction; ?> contacts"><?php echo $this->Html->link('Contacts/Sub-Accounts', array('action' => "account_information", 'accounts')); ?></li>
                        <li class="<?php echo $caction; ?> password"><?php echo $this->Html->link('Change Password', array('action' => "account_information", 'change_password')); ?></li>
                    </ul>
                </div>
                <div id="tab-content">
                    <?php if(!empty($daction)) : ?>
                    <div class="tabs details">
                        <?php echo $this->element('account_information/details'); ?>
                    </div>
                    <?php elseif(!empty($aaction)) : ?>
                    <div class="tabs contacts">
                        <?php echo $this->element('account_information/accounts'); ?>
                    </div>
                    <?php else : ?>
                    <div class="tabs password">
                        <?php echo $this->element('account_information/password'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- .grid-24 -->
    </div> <!-- .container -->
</div> <!-- #content -->
<script>
$("#UserSelectContact").live('change', function() {
    $("#selectcontact").submit();
});

$('#UserPassword').live('keyup', function() {
    var strength = 0;
    var password = $(this).val();
    var slide;
    
    if(password.length < 7) {
        slide = '0%';
    }
    
    if(password.length >= 7)  {
        strength += 1;
        slide = '20%';
    }
    
    if(password.length >= 10)  {
        strength += 1;
        slide = '40%';
    }
    
    if(password.length >= 10 && password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
        slide = '60%';
    }
    
    if(password.length >= 10 && password.match(/([a-zA-Z])/) && password.match(/([0-9])/) && password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        slide = '80%';
    }
    
    if(password.length >= 10 && password.match(/([a-zA-Z])/) && password.match(/([0-9])/) && password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        slide = '100%';
    }
    
    
    $('#meter').animate({width: slide}, 150);
    $('#meter').attr('class', "p"+strength);
});
</script>