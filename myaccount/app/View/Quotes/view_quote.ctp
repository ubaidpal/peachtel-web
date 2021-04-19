<?php 
/** datacenter */
$dataCenters = array(
    'ATL' => 'Atlanta, GA',
    'CHI' => 'Chicago, IL',
    'DEN' => 'Denver, CO',
    'LON' => 'London, United Kingdom',
    'MIA' => 'Miami, FL',
    'NYC' => 'New York, NY',
    'SEA' => 'Seattle, WA'
);


$productTotal = 0;
$deviceTotal = 0;

if(!empty($quote['WhmcsProduct'])) : 
$WHMCScategories = $quote['WhmcsProduct'];

?>
<div id="main_quote_holder" class="product">
    <div id="review_title_holder"><h3>Products and Services</h3></div>
    <div id="review_content_holder">
        <?php 
            $oTFee = 0;
            $mFee = 0;
            $i = 0;
            foreach($WHMCScategories as $key => $product):
            if($i == 0) : ?>
            <div class="row">
                <label><h5><?php echo ($i == 0) ? 'Category - Product/Service Name' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Quatity' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'One Time Charges' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Monthly Fee' : '&nbsp;' ?></h5></label>
                <label><h5><?php echo ($i == 0) ? 'Total' : '&nbsp;' ?></h5></label>
            </div>
            <?php endif; ?>
            <?php 
                $qty = $product['quantity'];
                $oTFee += $product['Tblproduct']['Tblpricing']['msetupfee'] * $qty;
                $mFee += $product['Tblproduct']['Tblpricing']['monthly'] * $qty;
                $productTotal = $oTFee + $mFee;
                $rowStyle = ($i % 2) ? "background: #fff;" : "background: #FFFFDD;";
                $val = (($product['Tblproduct']['Tblpricing']['msetupfee'] * $qty) + ($product['Tblproduct']['Tblpricing']['monthly'] * $qty) > 0) ? "$".number_format(($product['Tblproduct']['Tblpricing']['msetupfee'] * $qty) + ($product['Tblproduct']['Tblpricing']['monthly'] * $qty), 2, '.', ',') : "Free"; ?>
            <div id="products_container" class="row" style="<?php echo $rowStyle; ?>">
                <label style="text-align: center;">
                    <?php 
                        echo $product['Tblproduct']['Tblproductgroup']['name']." - ".$product['Tblproduct']['name'];
                        if($product['is_pbx']) {
                            $dc = $this->requestAction('quotes/getProductDatacenter/'.$product['data_center'], array('return'));
                            $productTotal += $dc['Datacenter']['value'];
                            echo "<br />";
                            echo "Datacenter - ".$dc['Datacenter']['name'] . " ($".number_format($dc['Datacenter']['value'], 2, '.', ',').")";
                        }
                    ?>
                </label>
                <label style="text-align: center;"><?php echo " (Qty: ".$qty.")"; ?></label>
                <label style="text-align: right;"><?php echo "($".$product['Tblproduct']['Tblpricing']['msetupfee'].") $".$product['Tblproduct']['Tblpricing']['msetupfee'] * $qty; ?></label>
                <label style="text-align: right;"><?php echo "($".$product['Tblproduct']['Tblpricing']['monthly'].") $".$product['Tblproduct']['Tblpricing']['monthly'] * $qty; ?></label>
                <label style="text-align: right; color: red;"><?php echo $val; ?></label>
            </div>
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
    if(!empty($quote['PsCart'])) : 
        $selectedDevices = $quote['PsCart']['PsCartProduct'];
    ?>
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
                        $qty = $device['quantity'];
                        $totalPrice += $device['PsProduct']['price'] * $qty;
                        $deviceTotal = $totalPrice;
                        $rowStyle = ($j % 2) ? "background: #fff;" : "background: #FFFFDD;"; ?>
                        <div id="products_container" class="row" style="<?php echo $rowStyle; ?>">
                            <label><?php echo $device['PsProduct']['PsProductLang']['name']; ?></label>
                            <label><?php echo $qty; ?></label>
                            <label>$<?php echo number_format($device['PsProduct']['price'], 2, '.', ','); ?></label>
                            <label style="text-align: right; color: red;">$<?php echo number_format($device['PsProduct']['price'] * $qty, 2, '.', ','); ?></label>
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