<style>
    /** View tool */
#main_quote_holder {
    border: 1px solid #D5D5D5;
    border-radius: 3px;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#review_title_holder {
    background: #E9E9E9;
    background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent;
    border-bottom: 1px solid #D5D5D5;
    padding: 10px 2px;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#review_title_holder h3{
    padding: 0;
    margin: 0;
    display: table;
    width: 100%;
    -webkit-print-color-adjust: exact;
    -moz-print-color-adjust: exact;
    font-weight: bold;
    margin-left: 10px;
}

#review_content_holder div.row {
    background: #EBEBEB;
    display: table-row;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#review_content_holder div.row label  {
    margin:0;
    display: table-cell;
    padding: 5px;
    border-right: 1px solid #D5D5D5;
    border-bottom: 1px solid #D5D5D5;
    min-width: 8%;
    text-align: center;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}
.product #review_content_holder div.row label:nth-child(1) {
    min-width: 10%;
}


.product #review_content_holder div.row label:nth-child(2) {
    min-width: 18%;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}


.devices #review_content_holder div.row label:nth-child(1) {
    min-width: 30%;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#review_content_holder div.row label:last-child {
    min-width: 1% !important;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}


#review_content_holder div.row label:last-child {
    border-right: none;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#review_content_holder div.row:last-child label {
    border-bottom: none;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

#products_container {
    padding: 3px 10px;
    width: 750px;
    display: table-row;
    border-bottom: 1px solid #D5D5D5;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

.total {
    font-size: 14px;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

.total h3 {
    margin:0;
    font-weight: normal;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial, sans-serif; color: #444;
}

.total label:last-child, .total label:nth-child(3), .total label:nth-child(4) {
    margin:0;
    -webkit-print-color-adjust: exact;
    font: 12px/1.7em "Open Sans", "trebuchet ms", arial,sans-serif;
    color: #444;
}
    
</style>
<?php 
$productTotal = 0;
$deviceTotal = 0;
$dataCenters = array(
    'ATL' => 'Atlanta, GA',
    'CHI' => 'Chicago, IL',
    'DEN' => 'Denver, CO',
    'LON' => 'London, United Kingdom',
    'MIA' => 'Miami, FL',
    'NYC' => 'New York, NY',
    'SEA' => 'Seattle, WA'
);

if(!empty($WHMCScategories)) : ?>
<div id="main_quote_holder" class="product">
    <div id="review_title_holder"><h3>Products and Services</h3></div>
    <div id="review_content_holder">
        <?php 
            $oTFee = 0;
            $mFee = 0;
            $i = 0;
            foreach($WHMCScategories as $key => $category): ?>
            <div class="row">
                <label><h5><?php echo $category['Tblproductgroup']['name']; ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Product/Service Name' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'One Time Charges' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Monthly Fee' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Total' : '&nbsp;' ?></h5></label>
            </div>
            <?php 
                $j = 0; 
                foreach($category['Tblproduct'] as $key2 => $product) : 
                $categoryID = $category['Tblproductgroup']['id'];
                $productID = $product['id'];
                $monthly = $product['Tblpricing']['monthly'];
                $msetup = $product['Tblpricing']['msetupfee'];
                $type = $product['paytype'];
                $dc = $this->requestAction('quotes/getProductDatacenter/'.$products[$categoryID][$productID]['datacenter'], array('return'));
                if(is_array($products[$categoryID][$productID]))
                    $qty = $products[$categoryID][$productID]['count'];
                else
                    $qty = $products[$categoryID][$productID];      
                
                if($product['paytype'] != 'free') {
                    if($product['paytype'] == 'recurring') {
                        $oTFee += $monthly * $qty;
                        $mFee += $msetup * $qty;
                    } else {
                        $mFee += $monthly * $qty;
                        $mFee += $msetup * $qty;
                    }
                } else {
                    $oTFee += 0;
                    $mFee += 0;         
                }
                $mFee += $dc['Datacenter']['value'];
                $productTotal = $oTFee + $mFee;
                $rowStyle = ($j % 2) ? "background: #fff;" : "background: #FFFFDD;"; 
                $val = (($msetup * $qty) + ($monthly * $qty) > 0 && $product['paytype'] != 'free') ? "$".number_format(($msetup * $qty) + ($monthly * $qty), 2, '.', ',') : "Free";
            ?>
        
            <div id="products_container" class="row" style="<?php echo $rowStyle; ?>">
                <label style="text-align: center;"><?php echo " (Qty: ".$qty.")"; ?></label>
                <label style="text-align: center;">
                    <?php 
                        echo $product['name'];
                        if(is_array($products[$categoryID][$productID]))
                            echo "<br />Datacenter - ".$dc['Datacenter']['name'] . " ($".number_format($dc['Datacenter']['value'], 2, '.', ',').")";
                    ?>
                </label>
                <label style="text-align: right;">
                    <?php 
                        if($type == 'recurring')
                            echo "($".$msetup.") $".$msetup * $qty;
                        else if($product['paytype'] == 'onetime')
                            echo "($".($msetup + $monthly).") $".(($msetup + $monthly) * $qty);
                        else
                            echo "Free";
                    ?>  
                
                </label>
                <label style="text-align: right;">
                    <?php 
                        if($type == 'recurring')
                            echo "($".$monthly.") $".($monthly * $qty);
                        else if($product['paytype'] == 'onetime')
                            echo "($0.00) $0.00";
                        else
                            echo "Free";
                    ?>
                </label>
                <label style="text-align: right; color: red;"><?php echo $val; ?></label>
            </div>
            <?php $j++; endforeach; ?>
        <?php $i++; endforeach; ?>
            <div class="row total">
                <label style="text-align: left; color: green;">Sub Total:</label>
                <label></label>
                <label style="text-align: right;"></label>
                <label style="text-align: right;"></label>
                <label style="text-align: right; color: red;  font-size: 18px;">$<?php echo number_format($productTotal, 2, '.', ','); ?></label>
            </div>
    </div>
</div>
<br />
<?php 
    endif;
    if(!empty($selectedDevices)) : ?>
<div id="main_quote_holder" class="devices">
    <div id="review_title_holder"><h3>Devices</h3></div>
    <div id="review_content_holder">
        <?php 
            $totalPrice = 0;
            $i = 0; ?>
            <div class="row">
                <label><h5><?php echo ($i == 0) ? 'Device Name' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Quantity' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Price' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Total' : '&nbsp;' ?></h5></label>
            </div>
            <?php 
                $j = 0; 
                foreach($selectedDevices as $key2 => $device):
                    
                $qty = $devices[$device['PsProduct']['id_product']];
                $totalPrice += $device['PsProduct']['price'] * $qty;
                $deviceTotal = $totalPrice;
                $rowStyle = ($j % 2) ? "background: #fff;" : "background: #FFFFDD;"; 
                $val = (($device['PsProduct']['price'] * $qty) > 0) ? "$".$device['PsProduct']['price'] * $qty : "Free";
                ?>
            <div id="products_container" class="row" style="<?php echo $rowStyle; ?>">
                <label><?php echo $device['PsProductLang']['name']; ?></label>
                <label><?php echo $qty; ?></label>
                <label>$<?php echo number_format($device['PsProduct']['price'], 2, '.', ','); ?></label>
                <label style="text-align: right; color: red;"><?php echo $val; ?></label>
            </div>
            <?php $j++; endforeach; ?>
            <div class="row total">
                <label style="text-align: left; color: green;">Sub Total:</label>
                <label></label>
                <label></label>
                <label style="text-align: right; color: red; font-size: 18px;">$<?php echo number_format($deviceTotal, 2, '.', ','); ?></label>
            </div>
    </div>
</div>
<?php endif; ?>