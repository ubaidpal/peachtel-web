<?php 
    $total = 0;
    $totalMFee = 0;
    if(!empty($WHMCScategories)) : ?>
<?php 
    foreach($WHMCScategories as $category) : ?>
    <div>
        <?php foreach($category['Tblproduct'] as $product) : ?>
        <div>
            <label style="display: inline-block; width: 96%; padding: 5px;">
                <b>
                <?php
                    if(is_array($categories[$category['Tblproductgroup']['id']][$product['id']])) {
                        $count = $categories[$category['Tblproductgroup']['id']][$product['id']]['count'];
                    } else {
                        $count =  $categories[$category['Tblproductgroup']['id']][$product['id']];
                    }
                    $number = $product['Tblpricing']['monthly'] * $count;
                    $mFee = $product['Tblpricing']['msetupfee'] * $count;
                    $total += $number;
                    $totalMFee += $mFee;
                    $name = (!empty($product['name'])) ? $product['name'] : "Unnamed";
                    $nameCount =  strlen($name);
                    $name = ($nameCount > 25) ? substr($name, 0, 25)."..." : $name;
                    $val = ($number > 0) ? "$".number_format(($number + $mFee), 2, '.', ',') : " Free";
                    echo "<div style='position: relative;'><label class='icon-remove remove-item' id='{$product['id']}'></label> ".$name."<h4 style='display: inline-block; right: 0; position: absolute;'>".$val."</h4></div>";
                
                ?>
                </b>
            </label>
            <hr />
        </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php else: ?>
<?php endif; ?>
<?php echo $this->Html->scriptBlock("totalMFee = {$total}; totalOTFee = {$totalMFee};"); ?>