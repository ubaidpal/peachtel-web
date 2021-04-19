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
                            <th>Created</th>
                            <th>Action</th>
                        </thead>
                        <?php
                        if (!empty($userActiveHostings)) :
                            foreach ($userActiveHostings as $hosting): ?>
                                <tr class="gradeA">
                                    <td> 
                                        <?php if($hosting['Server']['status']) : ?>
                                        <a target="_blank"href="<?php echo "https://".$hosting['Server']['domain']?>"><?php echo "https://".$hosting['Server']['domain'] ?></a>
                                        <?php else: ?>
                                        <?php echo "https://".$hosting['Server']['domain'] ?>
                                        <?php endif; ?>
                                     </td>
                                    <td> maint </td>
                                    <td> <?php echo $hosting['Server']['password'] ?> </td>
                                    <td> <?php echo ($hosting['Server']['status']) ? "Active" : "Inactive"; ?> </td>
                                    <td> <?php echo $hosting['Server']['created'] ?> </td>
                                    <td> 
                                        <?php if(!$hosting['Server']['status']): ?>
                                            <a href="pbx_provision/<?php echo $hosting['Server']['id'] ?>">Provision</a>
                                        <?php else: ?>
                                            [ <a href="pbx_restart/<?php echo $hosting['Server']['id'] ?>">Restart</a> ]
                                            [ <a href="pbx_start/<?php echo $hosting['Server']['id'] ?>">Start</a> ]
                                            [ <a href="pbx_stop/<?php echo $hosting['Server']['id'] ?>">Stop</a> ]
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="gradeA">
                                <td> No Hosting Found. </td>
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