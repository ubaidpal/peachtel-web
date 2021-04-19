<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="content">	
    <div id="contentHeader">
        <h1>Client List</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div>
                <?php 
                    echo $this->Form->create();
                    echo $this->Form->input('name_email', array('label' => false, 'div' => false, 'placeholder' => 'Search : Name or Email', 'style' => 'margin: 0 10px 10px 0;'));
                    echo $this->Form->submit('Search', array('div' => false));
                    echo $this->Form->end();
                ?>
            </div>
            <div class="widget widget-table">
                <div class="widget-header">
                    <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Clients</h3>		
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Company Name</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Created	Status</th>
                        </thead>
                        <?php
                        if (!empty($clients)) :
                            foreach ($clients as $client): ?>
                                <tr class="gradeA">
                                    <td> <?php echo $client['ID'] ?> </td>
                                    <td> <?php echo $client['FIRSTNAME'] ?> </td>
                                    <td> <?php echo $client['LASTNAME'] ?> </td>
                                    <td> <?php echo $client['COMPANYNAME'] ?> </td>
                                    <td> <?php echo $client['EMAIL'] ?> </td>
                                    <td> <?php echo $client['STATUS'] ?> </td>
                                    <td> <?php echo ($client['DATECREATED'] != '0000-00-00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($client['DATECREATED'])))." Ago" : ''; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="gradeA">
                                <td> No Clients Found. </td>
                                <td> </td>
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
        </div>
    </div> <!-- .container -->
</div> <!-- #content -->