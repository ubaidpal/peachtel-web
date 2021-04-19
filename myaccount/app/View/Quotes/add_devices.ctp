<?php    
    $total = 0;
    $totalMFee = 0;
    if(!empty($selectedDevices)) : ?>
    <div>
        <?php foreach($selectedDevices as $device) : ?>
        <div>
            <label style="display: inline-block; width: 96%; padding: 5px;"><b>
                <?php
                    $number = ($device['PsProduct']['price'] * $devices[$device['PsProduct']['id_product']]);
                    $total += $number;
                    $name = (!empty($device['PsProductLang']['name'])) ? $device['PsProductLang']['name'] : "Unnamed";
                    $nameCount =  strlen($name);
                    $name = ($nameCount > 25) ? substr($name, 0, 25)."..." : $name;
                    $val = ($number > 0) ? "$".number_format($number, 2, '.', ',') : " Free";
                    echo "<div style='position: relative;'><label class='icon-remove remove-item' id='{$device['PsProduct']['id_product']}'></label> ".$name."<h4 style='display: inline-block; right: 0; position: absolute;'>".$val."</h4></div>";
                ?></b>
            </label>
            <hr />
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php echo $this->Html->scriptBlock("totalPrice = {$total};"); ?>