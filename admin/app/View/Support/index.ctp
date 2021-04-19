<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
    
    label {
        display: inline-block;
        width: 100px !important;
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
   
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Support</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div id="form-holder" style="display:none;"></div>
            <div style="text-align: right;">
                <?php echo $this->Html->link('&#43; Open New Ticket', array('controller' => 'support', 'action' => 'open_ticket'), array('escape' => false)); ?>
            </div>
            <div class="widget widget-table">
                <div class="widget-header">
                    <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Tickets</h3>		
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <th>Date Submitted</th>
                            <th>Department</th>
                            <th>Subject</th>
                            <th>Submitter</th>
                            <th>Status</th>
                            <th>Last Reply</th>
                        </thead>
                        <?php
                        if (!empty($userTickets)) :
                            foreach ($userTickets as $ticket): ?>
                                <tr class="gradeA">
                                    <td> <?php echo $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($ticket['Tblticket']['date'])))." Ago"; ?> </td>
                                    <td> <?php echo $ticket['Tblticketdepartment']['name'] ?> </td>
                                    <td> 
                                        <?php 
                                            $link = (!empty($ticket['Tblticket']['name'])) ? "#".$ticket['Tblticket']['tid']." - ".$ticket['Tblticket']['name'] : "#".$ticket['Tblticket']['tid']." - ".$ticket['Tblticket']['status'];
                                            echo $this->Html->link($link, array('controller' => 'support', 'action' => 'get_ticket', $ticket['Tblticket']['id']), array('escape' => false));
                                        ?>
                                    </td>
                                    <td> <?php echo (!empty($ticket['Tblticket']['name'])) ? $ticket['Tblticket']['name'] : $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME']; ?> </td>
                                    <td> <?php echo $ticket['Tblticket']['status'] ?> </td>
                                    <td> <?php echo ($ticket['Tblticket']['lastreply'] != '0000-00-00 00:00:00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($ticket['Tblticket']['lastreply'])))." Ago" : 'No reply.'; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="gradeA">
                                <td> No Ticket Found. </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        <?php  endif;  ?>
                    </table>
                </div> <!-- .widget-content -->
            </div> <!-- .widget -->
            <div id="paginator">
                <?php echo $this->Paginator->numbers(array('separator' => ' ')); ?>
            </div>
        </div>
    </div> <!-- .container -->
</div> <!-- #content -->
<script>
var globalData = '';
$(function() {
    $('.view-ticket').live('click', function() {
        var ticketId = $(this).attr('id');
        var url = "getTicket";
        var data = {ticket_id: ticketId};
        var id;
        ajaxQuery(url, data);
        $('#form-holder').fadeOut('fast');
        $('#form-holder').fadeIn('slow');
        $('#form-holder').html(globalData);
    });
    
    $('#close a').live('click', function() {
        $(this).parents().eq(2).fadeOut('slow');
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