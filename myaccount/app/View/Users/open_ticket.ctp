<style>
    
    label {
        display: inline-block;
        width: 100px !important;
    }
    
    label[for="TicketMessage"] {
        vertical-align: top;
    }
    
    #add-ticket-header {
        text-align: center;
        font-size: 25px;
        padding: 15px;
        background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent;
        border: 1px solid #ccc;
        border-radius: 5px 5px 0 0;
    }
    hr {
        margin:3px;
    }
    
    textarea {
        width: 600px;
        height: 300px;
    }
    
    #save-button {
        margin-top:20px;
        text-align: center;
    }
    
    #save-button div {
        display:inline-block;
    }
    
    #close {
        border: 1px solid #CCCCCC;
        border-radius: 3px 3px 3px 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15) inset;
        color: #424242;
        font-family: "Open Sans",Verdana,'Helvetica Neue',Helvetica,Arial,Geneva,sans-serif;
        font-size: 13px;
        outline: medium none;
        padding: 4px 7px;
        transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
        text-decoration: none;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Support</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div style="text-align: right;"><a href="<?php echo $this->base; ?>/users/support">&laquo; View  Tickets</a></div>
            <div class="box" style="padding: 0 !important;">
                <div id="add-ticket-header">Open New Ticket</div>
                <div style="padding: 10px;">
                    <?php echo $this->Form->create('Ticket'); ?>
                    <?php echo $this->Form->input('to', array('label' => 'To: ', 'disabled' => 'disabled', 'value' => $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME'])); ?>
                    <hr />
                    <?php echo $this->Form->input('email', array('label' => 'Email Address: ', 'disabled' => 'disabled', 'value' => $currentClient['CLIENT']['EMAIL'])); ?>
                    <hr />
                    <?php echo $this->Form->input('did', array('label' => 'Department: ', 'type' => 'select', 'options' => $depts)); ?>
                    <hr />
                    <?php echo $this->Form->input('priority', array('label' => 'Priority: ', 'type' => 'select', 'options' => array('High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'))); ?>
                    <hr />
                    <?php echo $this->Form->input('subject', array('label' => 'Subject: ', 'style' => 'width: 500px;', 'class' => 'required')); ?>
                    <hr style="margin-bottom: 10px;" />
                    <?php echo $this->Form->input('message', array('label' => 'Message: ', 'type' => 'textarea', 'class' => 'required')); ?>
                    <div id="save-button">
                        <?php echo $this->Form->end('Save'); ?>
                        <div><a href="<?php echo $this->base; ?>/users/support" id="close">Close</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script(array('custom_validations'), array('inline' => false)); ?>
<script type="text/javascript">
    /**
    tinyMCE.init({
        theme : "advanced",
        mode : "textareas",
        convert_urls : false,
        plugins : "advhr,advlink,spellchecker,",
        theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,spellchecker",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
        
    });
    **/
</script> 