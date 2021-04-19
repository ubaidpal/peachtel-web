<style>
    .widget {
        margin-top: 10px;
    }
    td:nth-child(2), td:nth-child(3) {
        width: 100px;
    }
</style>
<div class="widget widget-table">
    <div class="widget-header">
<!--                <span class="icon-list"></span> class="icon chart"-->
        <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Select shipping method.</h3>		
    </div>
    <div class="widget-content">
        
        <table class="table table-bordered table-striped data-table">
            <?php if(!isset($err)) : ?>
            
            <thead>
                <?php 
                $i = 0;
                foreach($response as $resp) : 
                    if($i == 0) :
                        foreach($resp as $titles) : ?>
                <th><?php echo Inflector::humanize($titles); ?></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php $i++; endforeach; ?>
            </thead>
            <?php 
            $i = 0;
            foreach($response as $resp) :
                if($i > 0 && !empty($resp[0])) : 
                $selected = ($i == 1) ? 'checked' : '';
                ?>
                <tr>
                    <td><?php echo $this->Form->input('carrier_method', array('type' => 'radio', 'div' => false, 'checked' => $selected, 'options' => array($resp[0] => $resp[0]))); ?></td>
                    <td><?php echo "$ ".$resp[1] ?></td>
                    <td><?php echo $resp[2]." day(s)" ?></td>
                </tr>
                <?php endif; ?>
            <?php $i++; endforeach; ?>
                
            <?php else : ?>
                <thead>
                    <th>Notice:</th>
                </thead>
                <tr>
                    <td>Sorry for the inconvinience. <?php echo $err[2]; ?> <?php if($err[0] == 300) : ?>.
                   	<br />
                   	One of our team will contact you and complete the check out for you.- <a href="javascript:void(0);" id="updateQuote">Update Quote (Save Details)</a><?php endif; ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div> <!-- .widget-content -->
</div> <!-- .widget -->
