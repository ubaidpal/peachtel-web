<?php
    $captcha = $this->Html->image($this->Html->url(array('controller'=>'captcha','action'=>'createCaptcha'),true),array('id'=>'cakecaptcha'));
?>
<style>
    #content p {
        color: #777;
    }

    #content b {
        color: #000;
    }

    #cakecaptcha {
        border: 1px solid #d5d5d5;
        margin-bottom: 10px;
    }
</style>
<div id="contact-us-content">
    <div id="title-container">
        <h1>Contact <span>Us</span></h1>
        <p style="color: #777; font-size: 14px; width: 580px;">
            Reach us easily by using the form below. Use the form below for general contact requests.<br />
            If you are a valuable customer of ours, you can login and use the support page for filing urgent issues and requests.
        </p>
    </div>
    <div style="padding-bottom:10px; margin-top:10px; border-bottom: 2px dotted #d5d5d5;">
        <div id="contact-form-container">
            <?php
                echo $this->Form->create('Contact', array('action' => 'saveRequest', 'id' => 'contact_form'));
                echo $this->Form->input("fullname", array('type' => 'text', "placeholder" => "Fullname", 'class' => 'required'));
                echo $this->Form->input("email", array('type' => 'text', "placeholder" => "Email", 'class' => 'required email'));
                echo $this->Form->input("subject", array('type' => 'text', "placeholder" => "Subject", 'class' => 'required'));
                echo $this->Form->input("message", array('type' => 'textarea', "placeholder" => "Message", 'class' => 'required', 'style' => 'resize: none;'));
                echo $captcha."<br />";
                echo $this->Form->input("captcha", array('type' => 'text', "placeholder" => "input CAPTCHA code here", 'label' => false, 'class' => 'required'));
                echo $this->Form->button("Submit", array("id" => 'main_btn'));
                echo $this->Form->end();
            ?>
        </div>
        <div id="other-contact-container">
            <div id="mail-details">
                <h2>Mailing <span>Address</span></h2>
                <div id="content">
                    <p>
                        <b>PeachTEL</b><br />
                        1234 View Lake St.<br />
                        Las Vegas, Nevada 89110 USA<br />
                    </p>
                </div>
            </div>

            <div id="number-details">
                <h2>Contact <span>Numbers</span></h2>
                <div id="content">
                    <p>
                    Call Us: 123-PeachTELN8<br />
                    Fax: +1 123-456-7890<br />
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var isTrue = true;
    $("#contact_form").validate();
    $("#contact_form #main_btn").live('click', function() {
        $.ajax({
            url: 'captcha/newCaptcha',
            type: 'POST',
            async: false,
            success: function(data) {
                var captcha = $("#ContactCaptcha");
                if(data != $("#ContactCaptcha").val()) {

                    captcha.attr('style', 'border: 1px solid red; background:none repeat scroll 0 0 #FFDACC')
                    .val('')
                    .attr('placeholder', 'Invalid Captcha Code');

                    isTrue = false;
                } else {
                    isTrue = true;
                }
            }
        });

        return isTrue;
    });
</script>
