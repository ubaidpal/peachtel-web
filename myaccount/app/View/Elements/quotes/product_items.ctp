<?php foreach($WHMCScategories as $category): ?>
    <?php if($category['QbAdminCategory']['visible']) : ?>
        <div class="item-category" id="<?php echo $category['Tblproductgroup']['id']; ?>" style="padding: 10px 15px 10px 15px; background: #f5f5f5; margin-bottom: 10px; border: 2px solid #d5d5d5;">   
            <div style="padding-bottom: 5px;">
                <h4 style="font-size: 14px; color: #3d3d3d; display: inline-block; vertical-align: middle; font-weight: bold;"><?php echo $category['Tblproductgroup']['name']; ?></h4>
                <div style="display: none; margin-top: 5px; font-size: 12px; color: #777; ">
                    <p style="font-size: 12px; color: #777; text-indent: 10px;">  
                        <?php echo $category['QbAdminCategory']['description']; ?>
                    </p>
                </div>
                <label style="font-size: 10px; display: inline-block;">
                    <a href="javascript:void(0);" id="helpBtn" class="helpBtn">
                        -&nbsp;help
                        <label style="background: url(../images/dataTables/sort_both.png) repeat scroll -5px -9px transparent; display: block; height: 7px; width: 10px; float: right; margin-top: 3px;"></label>
                    </a>
                </label>
            </div>
        <?php 
            $i = 0; 
            if(isset($category['QbAdminCategory']['displayType'])) {
                $id = $category['Tblproduct'][0]['id'];
                switch($category['QbAdminCategory']['displayType']) {
                    case "1":
                        echo '<div class="inputs" style="position: relative;">';
                        echo "<select id='item-slider' name='{$category['Tblproductgroup']['name']}' id='{$category['Tblproductgroup']['name']}' class='formE {$category['Tblproductgroup']['name']} item-slider'>";
                            $qty = 0;
                            foreach($category['Tblproduct'] as $product) {
                                $selected = '';
                                if(isset($products[$category['Tblproductgroup']['id']][$product['id']])) {
                                    $id = $product['id'];
                                    $dc = $products[$category['Tblproductgroup']['id']][$product['id']];
                                    $selected = 'selected=selected';
                                    $qty = 1;
                                }
                                if(isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) {
                                    echo "<option ".$selected." id='{$product['id']}' pricing='".($product['Tblpricing']['msetupfee'] + $product['Tblpricing']['monthly'])."' value='".$product['name']."'>".$product['name']."</option>";
                                }
                            }
                        echo "</select>";
                        
                        $isPbx = ($category['Tblproductgroup']['name'] == 'PBX') ? 1 : 0;
                        echo "<input type='hidden' is_pbx='{$isPbx}' class='sliderVal' value='{$qty}' maxlength='3' id='{$id}' />";
                        if($category['Tblproductgroup']['name'] == 'PBX') :
                        echo "<div id='datacenters'>"; ?>
                            <?php
                                $dataCenters = array(
                                    'ATL' => ' Atlanta, GA - Datacenter',
                                    'MIA' => ' Miami, FL - Datacenter',
                                    'NYC' => ' New York, NY - Datacenter',
                                    'SEA' => ' Seattle, WA - Datacenter'
                                );
                                $i = 0;
                                foreach($dataCenters as $key => $value) {
                                    $checked = ($i == 0 || (isset($dc['datacenter']) && $dc['datacenter'] == $key)) ? array("checked" => "checked"): "";
                                    $radio = $this->Form->input('datacenter', array($checked, 'class' => 'datacenter datacenters', 'type' => 'radio', 'label' => false, 'legend' => false, 'options' => array($key => $value)));
                                    echo $radio;
                                    $i++;
                                }
                        echo "</div>";
                        endif;
                        echo "</div>";
                        break;
                    case "2":
                        foreach($category['Tblproduct'] as $product)  {
                            if(isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) {
                                echo '<div class="inputs" style="position: relative; line-height: 25px;">';
                                echo "<input type='radio' id='{$product['id']}' name='group-{$category['Tblproductgroup']['id']}' /> <label style='color: #3d3d3d; font-weight: bold;'>$ ".$product['Tblpricing']['monthly']." - ".$product['name']."</label><br />";
                                echo "</div>";
                            }
                        }
                        break;
                    case "3":
                        foreach($category['Tblproduct'] as $product)  {
                            if(isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) {
                                echo '<div class="inputs" style="position: relative; line-height: 25px;">';
                                echo "<input type='text' maxlength='3' id='{$product['id']}' /> <label style='color: #3d3d3d; font-weight: bold;'>$ ".$product['Tblpricing']['monthly']." - ".$product['name']."</label><br />";
                                echo "</div>";
                            }
                        }
                        break;
                    case "4":
                        foreach($category['Tblproduct'] as $product) {
                            if(isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) {
                                
                                $isDID = ($category['Tblproductgroup']['name'] == "DIDs") ? "did" : "";
                                
                                echo '<div class="inputs select" style="position: relative; line-height: 25px;">';
                                echo '<div id="select_skin"><div id="select_value">0</div></div>';
                                echo "<select id='{$product['id']}' class='product $isDID select-{$product['id']}'>";
                                
                                for($i = 0; $i <= 99; $i++)
                                    echo "<option value='{$i}'>".$i."</option>";
                                
                                echo "</select> <label style='color: #3d3d3d; font-weight: bold;'>$ ".$product['Tblpricing']['monthly']." - ".$product['name']."</label><br />";
                                echo "</div>";
                            }
                        }
                        break;
                }
            }
        ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<div id="visitcheckout-link-holder">
    <!--<h1><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/myaccount/users/trunking">ORDER TELEPHONE NUMBERS!</a></h1>-->
    <h1><a href="http://devweb.peachtel.net/itakishop">VISIT OUR STORE!</a></h1>
    <h1><a href="javascript:void(0);" id="checkOut">CONTINUE CHECKOUT</a></h1>
</div>
