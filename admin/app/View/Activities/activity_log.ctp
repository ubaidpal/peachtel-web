<div id="content">	
    <div id="contentHeader">
        <h1>Activities</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-24">
            <div class="box" id="categories">
                <div id="form_container">
                <?php echo $this->Form->input('provider', array('label' => 'Provider: ', 'options' => array('All' => 'All', 'WHMCS' => 'WHMCS', 'Prestashop' => 'Prestashop'))); ?>
                <br />
                <div class="widget widget-table">
                    <div class="widget-header">
                        <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Activity Log</h3>	
                    </div>
                    <div class="widget-content">
                        
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <th style="width: 220px;">Date</th>
                                <th>User</th>
                                <th>Provider</th>
                                <th>Description</th>
                            </thead>
                            <?php
                            if (!empty($activities) || !empty($whmcsPendingOrders['WHMCSAPI']['ACTIVITY'])) {
                                $flag = TRUE;
                                $counter = 1;
                                foreach ($whmcsPendingOrders['WHMCSAPI']['ACTIVITY'] as $activity): ?>
                                    <tr class="gradeA">
                                    <td> <?php echo ($activity['DATE'] != '0000-00-00 00:00:00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($activity['DATE'])))." Ago" : ''; ?> </td>
                                    <td> <?php echo $activity['USER'] ?> </td>
                                    <td><?php echo 'WHMCS' ?></td>
                                    <td> <?php echo $activity['DESCRIPTION'] ?> </td>
                                </tr>
                                <?php endforeach;
                                
                                $flag = TRUE;
                                $counter = 1;
                                foreach ($activities as $activity): ?>
                                    <tr class="gradeA">
                                    <td> <?php echo ($activity['Activity']['created'] != '0000-00-00 00:00:00') ? $this->requestAction(array('controller' => 'admintools', 'action' => 'getElapseTime', strtotime($activity['Activity']['created'])))." Ago" : ''; ?></td>
                                    <td> <?php echo $adminUser['email'] ?> </td>
                                    <td><?php echo 'Prestashop' ?></td>
                                    <td> <?php echo $activity['Activity']['description'] ?> </td>
                                </tr>
                                <?php endforeach;
                            } else { ?>
                                <tr class="gradeA">
                                    <td>No Activity made.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php }  ?>
                        </table>
                    </div> <!-- .widget-content -->
                </div> <!-- .widget -->
                <div id="paginator">
                    <?php //echo $this->Paginator->numbers(array('separator' => ' ')); ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<script type='text/javascript'>
    $('#provider').live('change', function() {
        var val = $(this).val();
        if(val != 'All') {
            $('table tbody tr').each(function() {
                if(val != $(this).find('td:nth-child(3)').html()) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        } else {
            $('table tbody tr').show();
        }
    });
</script>