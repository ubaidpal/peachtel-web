<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="content">	
    <div id="contentHeader">
        <h1>Phone System</h1>
    </div> <!-- #contentHeader -->
    <div class="container">

        <div class="grid-24">
            <div class="widget widget-table">
                <div class="widget-header">
                    <h3 style="margin-top: 10px;color:#454545;font-size: 16px">User Hostings</h3>		
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <th>Host Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Status</th>
                        </thead>
                        <?php
                        if (!empty($userActiveHostings)) :
                            foreach ($userActiveHostings as $hosting): ?>
                                <tr class="gradeA">
                                    <td> <?php echo "http://".$hosting['Tblhosting']['domain'] ?> </td>
                                    <td> <?php echo $hosting['Tblhosting']['username'] ?> </td>
                                    <td> <?php echo $hosting['Tblhosting']['password'] ?> </td>
                                    <td> <?php echo $hosting['Tblhosting']['domainstatus'] ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="gradeA">
                                <td> No Hosting Found. </td>
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