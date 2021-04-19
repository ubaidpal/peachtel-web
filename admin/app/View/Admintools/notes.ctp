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
    .submit {
        text-align: center;
    }
    td:last-child {
        text-align: center;
    }
    td:last-child a:first-child{
        display:inline-block;
        width: 16px;
        height: 16px;
        background: url('<?php echo $this->base; ?>/images/sprite/sprite-16-black.png');
        background-position: 0 -5852px;
        background-repeat: no-repeat;
        text-decoration:none;
    }
    
    td:last-child a:last-child{
        display:inline-block;
        width: 16px;
        height: 16px;
        background: url('<?php echo $this->base; ?>/images/sprite/sprite-16-black.png');
        background-position: 0 -7172px;
        background-repeat: no-repeat;
        text-decoration:none;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>Support</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div class="widget widget-table">
                <div class="widget-header">
                    <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Notes</h3>		
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <th>Created</th>
                            <th>Note</th>
                            <th>Admin</th>
                            <th>Last Modified</th>
                            <th>Action</th>
                        </thead>
                        <?php
                        if (!empty($notes)) :
                            foreach ($notes as $note): ?>
                                <tr class="gradeA">
                                    <td> <?php echo $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($note['Tblnote']['created'])))." Ago"; ?> </td>
                                    <td> <?php echo $note['Tblnote']['note'] ?> </td>
                                    <td> <?php echo $note['Tbladmin']['firstname']." ".$note['Tbladmin']['lastname'] ?> </td>
                                    <td> <?php echo $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($note['Tblnote']['modified'])))." Ago"; ?>  </td>
                                    <td id="<?php echo $note['Tblnote']['id']; ?>"><a href="javascript:void(0);" id="edit">&nbsp;</a>&nbsp;<a href="javascript:void(0);" id="delete">&nbsp;</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="gradeA">
                                <td> No Ticket Found. </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        <?php  endif;  ?>
                    </table>
                </div>
            </div> <!-- .widget -->
            <div id="paginator">
                <?php echo $this->Paginator->numbers(array('separator' => ' ')); ?>
            </div>
            <br />
                <div class="box">
                <?php echo $this->Form->create('Note'); ?>
                <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('note', array('type' => 'textarea', 'style' => 'width: 922px; height: 159px;', 'label' => 'Note: ')); ?>
                <br />
                <?php echo $this->Form->end('Add Note'); ?>
            </div>
        </div>
    </div> <!-- .container -->
</div> <!-- #content -->
<script>
var globalData = '';
$(function() {
    $('#edit').live('click', function() {
        var nid = $(this).parent().attr('id');
        var note = $(this).parents().eq(1).find('td:nth-child(2)').html();
        $('#NoteId').val(nid);
        $('#NoteNote').val(note);
        $('input[type="submit"]').val('Save Changes');
    });
    
    $('#delete').live('click', function() {
        var isTrue = confirm('Are you sure you want to delete this note?');
        if(isTrue) {
            var id = $(this).parent().attr('id');
            var url = 'deleteNote';
            var data = {nid: id};
            ajaxQuery(url, data);
            if(globalData) {
                $(this).parents().eq(1).remove();
            } else {
                alert('Error: Ajax request failed.');
            }
        }
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