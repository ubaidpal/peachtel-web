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
                        if(isset($categories[$category['Tblproductgroup']['id']][$product['id']]['datacenter'])) {
                            $total += $this->requestAction('quotes/getDatacenter/'.$categories[$category['Tblproductgroup']['id']][$product['id']]['datacenter'], array('return'));
                        }
                    } else
                        $count =  $categories[$category['Tblproductgroup']['id']][$product['id']];

                    $mFee = $product['Tblpricing']['monthly'] * $count;
                    $number = $product['Tblpricing']['msetupfee'] * $count;
					if($product['paytype'] != 'free') {
						if($product['paytype'] == 'recurring') {
			                $total += $mFee;
			                $totalMFee += $number;
						} else {
							$total += $mFee;
							$total += $number;
						}
					}
                    $name = (!empty($product['name'])) ? $product['name'] : "Unnamed";
                    $name = ($category['Tblproductgroup']['name'] == 'PBX') ? $name." line PBX" : $name;
                    $nameCount =  strlen($name);
                    $name = ($nameCount > 25) ? substr($name, 0, 25)."..." : $name;
                    $val = ($number + $mFee > 0 && $product['paytype'] != 'free') ? "$".number_format(($number + $mFee), 2, '.', ',') : " Free";
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