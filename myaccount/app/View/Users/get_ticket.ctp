<style>
    #message-container, #edit-pane {
        border: 1px solid #ccc;
        border-radius: 0 0 5px 5px;
        padding: 10px;
        margin-bottom:10px;
    }
    
    #subject {
        background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent;
        padding: 10px 10px 1px 10px;
        border: 1px solid #ccc;
        border-radius: 5px 5px 0 0;
        border-bottom: none;
        position: relative;
    }
    
    .box {
        position: relative;
    }
    
    #message-container hr {
        margin: 1px 0 3px 0;
    }
   
    
    #ticket-info label {
        display: inline-block;
        width: 100px;
    }
    
    #reply-buttons {
        position: absolute;
        top: 15px;
        right: 10px;
    }
    #reply-buttons a {text-decoration:none;}
    #reply-buttons a:nth-child(1) {
        display: inline-block;
        height: 12px;
        width: 12px;
        background: url('<?php echo $this->base; ?>/images/sprite/sprite-12-black.png');
        background-position: 0 -5852px;
        background-repeat: no-repeat;
    }
    
    #reply-buttons a:nth-child(2) {
        display: inline-block;
        height: 12px;
        width: 12px;
        background: url('<?php echo $this->base; ?>/images/sprite/sprite-12-black.png');
        background-position: 0 -7172px;
        background-repeat: no-repeat;
    }
    #edit-pane a {
        border: 1px solid #CCCCCC;
        border-radius: 3px 3px 3px 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15) inset;
        color: #424242;
        font-family: "Open Sans",Verdana,'Helvetica Neue',Helvetica,Arial,Geneva,sans-serif;
        font-size: 13px;
        outline: medium none;
        padding: 3px 6px;
        transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
        text-decoration:none;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Support</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div style="text-align: right;"><a href="<?php echo $this->base; ?>/users/support">&laquo; View  Tickets</a></div>
            <div class="box">
                <h2 style="display:inline-block;">Ticket:</h2>&nbsp;&nbsp;<h3 style="display:inline-block;"><?php echo "#{$ticket['Tblticket']['tid']}"; ?> - Test</h3>
                <div id="ticket-info">
                    <label>Client: </label><?php echo (!empty($ticket['Tblticket']['name'])) ? $ticket['Tblticket']['name'] : $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME']; ?><br />
                    <?php echo $this->Form->input('status', array('type' => 'select', 'value' => $ticket['Tblticket']['status'], 'label' => 'Status: ', 'options' => array('Open' => 'Open', 'Answered' => 'Answered', 'Customer-Reply' => 'Customer-Reply', 'On Hold' => 'On Hold', 'In Progress' => 'In Progress', 'Closed' => 'Closed'))); ?>
                    <label>Priority: </label><?php echo $ticket['Tblticket']['urgency']; ?><br />
                    <label>Date Filed: </label><?php echo date('M d, Y D @ h:i A',  strtotime($ticket['Tblticket']['date'])); ?><br />
                    <label>Last reply: </label><?php echo date('M d, Y D @ h:i A',  strtotime($ticket['Tblticket']['lastreply'])); ?>
                </div>
                <br />
                <div id="subject"><h3>Add Reply</h3></div>
                <div id="message-container">
                    <?php echo  $this->Form->create('users', array('action' => 'addReply')); ?>
                    <?php echo $this->Form->input('Tblticketreply.tid', array('value' => $ticket['Tblticket']['id'], 'type' => 'hidden')); ?>
                    <?php echo $this->Form->input('Tblticketreply.message', array('type' => 'textarea', 'label' => false, 'style' => 'width: 1004px; height: 274px; text-indent: 20px;')); ?>
                    <br />
                    <?php echo $this->Form->end('Add Response')?>
                </div>
                <br />
                <div id="ticket-container">
                    <div id="subject" type="ticket">
                        <h3>Subject: <?php echo ucfirst($ticket['Tblticket']['title']); ?></h3>
                        <label style="margin-bottom: 10px; color: #fff; padding: 1px 5px; display: block; background: green; width: 50px; text-align:center;"><?php echo (!empty($ticket['Tblticket']['admin'])) ? "Staff" : "Client"; ?></label>
                        <?php if(empty($ticket['Tblticket']['admin'])): ?>
                        <div id="reply-buttons" eid="<?php echo $ticket['Tblticket']['id']; ?>">
                            <a href="javascript:void(0);" method="edit">&nbsp;</a>
                            <a href="javascript:void(0);" method="delete">&nbsp;</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div id="message-container">
                        <i>Wrote a ticket:</i>
                        <hr />
                        <p style="text-indent: 15px; margin: 10px 0 10px 0"><?php echo $ticket['Tblticket']['message']; ?></p>
                        <hr />
                        <i style="font-weight: bold; font-size: 10px;">Last <?php echo $this->requestAction(array('controller' => 'users', 'action' => 'getElapseTime', strtotime($ticket['Tblticket']['date'])))." Ago"; ?></i>

                    </div>
                </div>
                <div id="reply-holder">
                    <?php foreach($userTicketsreply as $reply) : ?>
                    <div id="reply-container">
                        <div id="subject" type="reply">
                            <h3><?php echo $reply['Tblticketreply']['name']; ?></h3>
                            <label style="margin-bottom: 10px; color: #fff; padding: 1px 5px; display: block; background: green; width: 50px; text-align:center;"><?php echo (!empty($reply['Tblticketreply']['admin'])) ? "Staff" : "Client"; ?></label>
                            <?php if(empty($reply['Tblticketreply']['admin'])): ?>
                            <div id="reply-buttons" eid="<?php echo $reply['Tblticketreply']['id']; ?>">
                                <a href="javascript:void(0);" method="edit">&nbsp;</a>
                                <a href="javascript:void(0);" method="delete">&nbsp;</a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div id="message-container">
                            <i>Wrote a reply:</i>
                            <hr />
                            <p style="text-indent: 15px; margin: 10px 0 10px 0"><?php echo $reply['Tblticketreply']['message']; ?></p>
                            <hr />
                            <i style="font-weight: bold; font-size: 10px;">Last <?php echo $this->requestAction(array('controller' => 'users', 'action' => 'getElapseTime', strtotime($reply['Tblticketreply']['date'])))." Ago"; ?></i>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div id="paginator">
                        <?php echo $this->Paginator->numbers(array('separator' => ' ')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var globalData = ''
$(function(){
    $('#status').live('change', function() {
        var id = <?php echo $ticket['Tblticket']['id']; ?>;
        var stat = $(this).val();
        var url = '<?php echo $this->base; ?>/users/ticketUpdateStatus';
        var data = {tid: id, status: stat};
        ajaxQuery(url, data);
    });
    
    $('.submit input').live('click', function(e){
        var data = $('#usersAddReplyForm').serialize()
        var url = "<?php echo $this->base; ?>/users/addReply";
        ajaxQuery(url, data);
        if(globalData != false) {
            $('#TblticketreplyMessage').val('');
            $('#ticket-container').after(globalData);
        } else {
            alert('Error: Ajax request failed.');
        }
        return false;
    });
    
    $('#subject a').live('click', function(){
        var id = $(this).parent().attr('eid');
        var url1, url2, data, isTrue, type;
        
        if($(this).parents().eq(1).attr('type') == 'ticket') {
            url1 = '<?php echo $this->base; ?>/users/editTicket';
            url2 = '<?php echo $this->base; ?>/users/deleteTicket';
            type = 'ticket';
        } else {
            url1 = '<?php echo $this->base; ?>/users/editReply';
            url2 = '<?php echo $this->base; ?>/users/deleteReply';
            type = 'reply';
        }
        
        if($(this).attr('method') == 'edit') {
            data = {eid: id};
            ajaxQuery(url1, data);
            $(this).parents().eq(2).append(globalData);
            $(this).parents().eq(1).next('#message-container').hide();
            
        } else {
            
            if(type == 'ticket') {
                isTrue = confirm('Are you sure you want to delete this ticket and all of its replies?');
            } else {
                isTrue = confirm('Are you sure you want to delete this reply?');
            }
            
            if(isTrue) {
                data = {eid: id};
                ajaxQuery(url2, data);
                if(globalData) {
                    if(type == 'ticket') {
                        window.location = "<?php echo $this->base; ?>/users/support";
                    } else {
                        $(this).parents().eq(2).remove();
                    }
                }
            } else {
                exit;
            }
        }
    });
    
    $('#edit-pane #save').live('click', function() {
        var id = $(this).parent().find('#eid').val();
        var msg = $(this).parent().find('#message').val();
        var data = {eid: id, message: msg};
        var url;
        
        if($(this).parent().attr('type') == 'ticket') {
            url = '<?php echo $this->base; ?>/users/saveTicket'
        } else {
            url = '<?php echo $this->base; ?>/users/saveReply'
        }
        ajaxQuery(url, data);
        if(globalData) {
            
            $(this).parent().prev('#message-container').find('p').html(msg);
            $(this).parent().prev('#message-container').show();
            $(this).parent().remove();
        } else {
            alert('Error: Ajax request failed.');
        }
    });
    
    $('#edit-pane #cancel').live('click', function() {
        $(this).parent().prev('#message-container').show();
        $(this).parent().remove();
    });
    
    $('#paginator a').live('click', function() {
        var index = $(this).attr('href').split(':');
        if(index[1][0] != undefined) {
            index[1] = index[1][0];
        }
        var url = '<?php echo $this->base; ?>/users/support/get_ticket/<?php echo $ticketId; ?>?page='+index[1];
        ajaxQuery(url, {});
        $('#reply-holder').html(globalData);
        return false;
    });
});


function ajaxQuery(url, data) {
    $.ajax({
        type: 'POST',
        async: false,
        url: url,
        data: data,
        success: function(response){
            globalData = response;
        },
        failure: function() {
            alert('Error: Ajax request failed.');
        }
    });
}
</script>