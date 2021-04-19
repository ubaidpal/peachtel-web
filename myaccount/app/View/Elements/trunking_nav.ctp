<ul class="trunking_nav">
    <?php
    $sH = '';
    $sV = '';
    $sC = '';
    $sO = '';
    $sT = '';
    $sCD = '';
        
    switch($header) {
        case "Home" :
            $sH = "selected";
            break;
        case "Vendors" :
            $sV = "selected";
            break;
        case "Customers" :
            $sC = "selected";
            break;
        case "Origination" :
            $sO = "selected";
            break;
        case "Termination" :
            $sT = "selected";
            break;
    }
    ?>
    <li class='<?php echo $sH; ?>'><?php echo $this->Html->link('Home', '/admintools/trunking'); ?></li>
    <li class='<?php echo $sV; ?>'><?php echo $this->Html->link('Vendors', '/trunking_vendors'); ?></li>
    <li class='<?php echo $sC; ?>'><?php echo $this->Html->link('Customers', '/trunking_customers'); ?></li>
    <li class='<?php echo $sO; ?>'><?php echo $this->Html->link('Origination', '/trunking_originations'); ?></li>
    <li class='<?php echo $sT; ?>'><?php echo $this->Html->link('Termination', '/trunking_terminations'); ?></li>
    <li class='<?php echo $sCD; ?>'><?php echo $this->Html->link("CDR's", 'javascript:void(0)'); ?></li>
</ul>