<ul class="trunking_nav">
    <?php
    $sH = '';
    $sV = '';
    $sC = '';
    $sO = '';
    $sT = '';
    $sCD = '';
    $pkg = '';  
    $reg = '';
    $trsd = '';
    $uri = '';
    switch($header) {
        case "Dashboard" :
            $sH = "selected";
            break;
        case "VendorOriginationRoutes" :
        case "VendorOriginationGateways" :
        case "TerminationRoutes" :
        case "TerminationGateways" :
        case "Vendors" :
            $sV = "selected";
            break;
        case "BillingGroups" :
        case "Customers" :
            $sC = "selected";
            break;
        case "Origination" :
            $sO = "selected";
            break;
        case "Terminations" :
            $sT = "selected";
            break;
        case "Cdrs" :
            $sCD = "selected";
            break;
        case "Packages" :
            $pkg = "selected";
            break;
        case "Regions" :
            $reg = "selected";
            break;
        case "Trusted" :
            $trsd = "selected";
            break;
        case "Uri" :
            $uri = "selected";
            break;
    }
    ?>
    <li class='<?php echo $sH; ?>'><?php echo $this->Html->link('Home', '/'); ?></li>
    <li class='<?php echo $sV; ?>'><?php echo $this->Html->link('Vendors', '/vendors'); ?></li>
    <li class='<?php echo $sC; ?>'><?php echo $this->Html->link('Customers', '/customers'); ?></li>
    <li class='<?php echo $sO; ?>'><?php echo $this->Html->link('Origination', '/originations'); ?></li>
    <li class='<?php echo $sT; ?>'><?php echo $this->Html->link('Termination', '/terminations'); ?></li>
    <li class='<?php echo $sCD; ?>'><?php echo $this->Html->link("CDR's", '/cdrs'); ?></li>
    <li class='<?php echo $pkg; ?>'><?php echo $this->Html->link("Packages", '/packages'); ?></li>
    <li class='<?php echo $reg; ?>'><?php echo $this->Html->link("Regions", '/regions'); ?></li>
    <li class='<?php echo $trsd; ?>'><?php echo $this->Html->link("Trusted", '/trusted'); ?></li>
    <li class='<?php echo $uri; ?>'><?php echo $this->Html->link("Uri", '/uri'); ?></li>
</ul>