<?php echo $this->Html->css(array('adminQuotes')); ?>

<div id="content">	
    <div id="contentHeader">
        <h1>Quotes Tool</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-16">
            <div class="box brochure" id="categories">
                <div id="reg_header">
                    <ul>
                        <li class="selected"><h1><a id="pbx-link">Pbx</a></h1></li>
                        <li><h1><a id="product-link">Product / Services</a></h1></li>
                        <li><h1><a id="devices-link">Devices</a></h1></li>
                    </ul>
                </div>
                <div id="main-product-holder">
                    <div id="pbx-holder">
                        <?php foreach($WHMCScategories as $category): ?>
                            <?php if($category['QbAdminCategory']['visible']): ?>
                                <?php if($category['Tblproductgroup']['name'] == 'PBX') : ?>
                                <div class="item-category" id="<?php echo $category['Tblproductgroup']['id']; ?>" style="margin-bottom: 10px; border: 1px solid #d5d5d5;">   
                                    <div style="padding: 10px; border-bottom: 1px solid #d5d5d5; background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent; color: #333333;">
                                        <h4><?php echo $category['Tblproductgroup']['name']; ?></h4>
                                    </div>
                                <?php 
                                    $i = 0; 
                                    if(isset($category['QbAdminCategory']['displayType'])) {
                                        if($category['QbAdminCategory']['displayType'] == 1) {
                                            echo '<div class="inputs" style="background: #fff; border-bottom: 1px solid #D5D5D5; padding: 5px 5px 5px 15px; position: relative;">';

                                            echo "<select id='item-slider' name='".$category['Tblproductgroup']['name']."' id='".$category['Tblproductgroup']['name']."' class='formE ".$category['Tblproductgroup']['name']."'>";
                                                foreach($category['Tblproduct'] as $product) {
                                                    if($product['QbAdminProduct']['visible']) {
                                                        echo "<option id='".$product['id']."' pricing='".$product['Tblpricing']['monthly']."' value='".$product['name']."'>".$product['name']."</option>";
                                                    }
                                                }
                                            echo "</select>";
                                            echo "<input type='text' is_pbx='1' style='display: none;' class='sliderVal' maxlength='3' id='{$category['Tblproduct'][0]['id']}' /> <label>".$category['Tblproduct'][0]['name']."</label><label style='float: right; margin-right: 10px;' id='price-holder'>$ ".$category['Tblproduct'][0]['Tblpricing']['monthly'];
                                            echo "</div>";
                                        }
                                    }
                                ?>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <br />
                        <div>
                            <div id="datacenters" style="display:none;">
                                <h2>Choose your Data Center</h2>
                                <?php
                                    $dataCenters = array(
                                        'ATL' => 'Atlanta, GA',
                                        'CHI' => 'Chicago, IL',
                                        'DEN' => 'Denver, CO',
                                        'LON' => 'London, United Kingdom',
                                        'MIA' => 'Miami, FL',
                                        'NYC' => 'New York, NY',
                                        'SEA' => 'Seattle, WA'
                                    );
                                    $i= 0;
                                    foreach($dataCenters as $key => $value) {
                                        $checked = '';
                                        if($i == 0) {
                                            $checked = array('checked' => 'checked');
                                        }
                                        echo $this->Form->input('datacenter', array($checked, 'class' => 'datacenters', 'type' => 'radio', 'div' => false, 'legend' => false, 'options' => array($key => $value)));
                                        echo "<br />";
                                        $i++;
                                    }
                                ?>
                            </div>
                        </div>
                        
                    </div>
                    <div id="product-holder">
                    <?php foreach($WHMCScategories as $category): ?>
                        <?php if($category['QbAdminCategory']['visible']): ?>
                            <?php if($category['Tblproductgroup']['name'] != 'PBX') : ?>
                            <div class="item-category" id="<?php echo $category['Tblproductgroup']['id']; ?>" style="margin-bottom: 10px; border: 1px solid #d5d5d5;">   
                                <div style="padding: 10px; border-bottom: 1px solid #d5d5d5; background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent; color: #333333;">
                                    <h4><?php echo $category['Tblproductgroup']['name']; ?></h4>
                                </div>
                            <?php 
                                $i = 0; 
                                if(isset($category['QbAdminCategory']['displayType'])) {
                                    if($category['QbAdminCategory']['displayType'] != 1) {
                                        foreach($category['Tblproduct'] as $product):
                                            if(isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) :
                                            $rowStyle = ($i % 2) ? "background: #fff;" : "background: #FFFFDD;"; ?>

                                            <div class="inputs" style="<?php echo $rowStyle; ?> border-bottom: 1px solid #D5D5D5; padding: 5px 5px 5px 15px; position: relative;">
                                                <?php 
                                                    switch($category['QbAdminCategory']['displayType']) {
                                                        case "1":
                                                            echo "<label>".$product['name']." <span>(0)</span></label><br /><div class='slider'></div><input type='hidden' id='{$product['id']}' name='group' /><label style='float: right; margin-right: 10px;' id='price-holder'>$ ".$product['Tblpricing']['monthly'];
                                                            break;
                                                        case "2":
                                                            echo "<input type='radio' id='{$product['id']}' name='group-{$category['Tblproductgroup']['id']}' /> <label>".$product['name']."</label><label style='float: right; margin-right: 10px;' id='price-holder'>$ ".$product['Tblpricing']['monthly'];
                                                            break;
                                                        case "3":
                                                            echo "<input type='text' maxlength='3' id='{$product['id']}' /> <label>".$product['name']."</label><label style='float: right; margin-right: 10px;' id='price-holder'>$ ".$product['Tblpricing']['monthly'];
                                                            break;
                                                        case "4":

                                                            break;
                                                    }
                                                ?>
                                            </div>
                                        <?php 
                                        endif;
                                        $i++; 
                                        endforeach;
                                    }
                                } else {
                                            echo "<div class='inputs' style='$rowStyle border-bottom: 1px solid #D5D5D5; padding: 5px 5px 5px 15px; position: relative;'><input type='text' maxlength='3' id='{$product['id']}' /> <label>".$product['name']."</label><label style='float: right; margin-right: 10px;'>$ ".$product['Tblpricing']['monthly']."</div>";
                                }
                                    ?>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                    <div id="devices-holder">
                        <div style="margin-bottom: 10px; border: 1px solid #d5d5d5; position: relative;">   
                            <div style="padding: 10px; border-bottom: 1px solid #d5d5d5; background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0 0 transparent; color: #333333;">
                                <h4>Devices List</h4>
                            </div>
                            <div>
                                <ul>
                                    <?php foreach($manufacturers as $key => $manufacturer) : ?>
                                    <li class="man_<?php echo $key ?> viewDevices" style="color: green"><?php echo $manufacturer; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php 
                                $quote = array();
                                foreach($manufacturers as $key => $manufacturer) {
                                    $quote[$key] = ''; 
                                }
                                
                                $i = 0;
                                foreach($devices as $device) {
                                    $img = (!empty($device['PsImage']['id_product'])) ? "http://devweb.peachtel.net/prestashop/{$device['PsImage']['id_image']}-home_default/{$device['PsProductLang']['link_rewrite']}.jpg" : "http://localhost/itaki_prestashop/img/p/en-default-home_default.jpg";
                                    $rowStyle = ($i % 2) ? "background: #fff;" : "background: #FFFFDD;";
                                    $quote[$device['PsProduct']['id_manufacturer']] .= "<div class='inputs' style='$rowStyle border-bottom: 1px solid #D5D5D5; padding: 5px 5px 5px 15px; position: relative; min-height: 200px;'>
                                    <b>Qty:</b> 
                                    <input type='text' maxlength='3' id='{$device['PsProduct']['id_product']}' /> 
                                    <label style='display:inline-block; width: 405px; vertical-align:top;'>
                                        <b style='text-decoration: underline;'>{$device['PsProductLang']['name']}</b>
                                        <br />
                                        {$device['PsProductLang']['description']}
     
                                        <label style='margin-right: 10px; color: green;'>
                                            <h4>Price: $". number_format($device['PsProduct']['price'], 2, '.', ',') ."</h4>
                                        </label>
                                    </label>
                                    <img style='border: 1px solid #d5d5d5; position: absolute; right: 30px; top:40px;' src='{$img}' />
                                    </div>";
                                    $i++;
                                }
                                $j = 0;
                                foreach($manufacturers as $key => $manufacturer) {
                                    $display = ($j == 0) ? '' : 'display:none;'; 
                                    echo "<div id='man_$key' class='manufacturer_holder' style='$display'>";
                                    echo (!empty($quote[$key])) ? $quote[$key] : "<div class='' style='background: #fff; border-bottom: 1px solid #D5D5D5; padding: 5px 5px 5px 15px; position: relative; min-height: 200px;'>No Devices available for manufacturer {$manufacturer}</div>";
                                    echo "</div>";
                                    $j++;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box checkout_form" style="display: none;">
                <?php 
                    echo "<h2>Checkout Details</h2>";
                    echo "<div id='err_pane' style='padding: 5px 10px; display: none; background: #FFFFDD; border: 1px solid #D5D5D5;'></div>";
                    echo $this->Form->create('');
                    echo "<div>";
                    echo $this->Form->input('Tblclient.quotes_key', array('type' => 'hidden'));
                    echo $this->Form->input('Tblclient.country', array('options' => $countryList));
                    echo $this->Form->input('Tblclient.state', array('options' => $states));
                    echo "</div><div>";
                    echo $this->Form->input('Tblclient.city', array('type' => 'text'));
                    echo $this->Form->input('Tblclient.postcode', array('type' => 'text'));
                    echo "</div><div>";
                    echo $this->Form->input('Tblclient.address1', array('type' => 'text'));
                    echo $this->Form->input('Tblclient.phonenumber', array('type' => 'text'));
                    echo "</div><br />";
                    
                    echo "<a href='javascript:void(0);' id='validate_location'>Validate Address</a> <label id='addrstatus'></label>";
                    echo "<hr style='margin:10px 0 10px 0;'/>";
                    echo "<h2>Carrier Details</h2>";
                    echo "<div>";
                    echo "<div class='input'>";
                    echo "<label>Purchase insurance?</label>";
                    echo $this->Form->input('Tblclient.insurance', array('type' => 'radio', 'class' => 'insurance', 'value' => 'yes', 'options' => array('yes' => 'Yes', 'no' => 'No'), 'div' => false, 'legend' => false));
                    echo "</div>";
                    echo "</div><div>";
                    echo "<div class='input'>";
                    echo "<label>Carrier</label>";
                    echo $this->Form->input('Tblclient.carrier', array('type' => 'radio', 'class' => 'shippingMethod', 'value' => '1', 'options' => array('1' => 'UPS', '2' => 'FEDEX'), 'div' => false, 'legend' => false));
                    echo "</div>";
                    echo "</div>";
                    echo "<div id='carrier_details' style='width: 100%'></div>";
                    echo "<hr style='margin-top:10px;'/>";
                    echo "<br />";
                    
                    echo $this->Form->input('Checkout (Paypal)', array('type' => 'submit', 'style' => 'float: left;', 'div' => false, 'label' => false));
                    echo "<a href='javascript:void(0);' id='cancel' style='float:left;margin-left: 10px; '>Cancel</a>";
                    echo $this->Form->end();
                    echo "<br />";
                    echo "<br />";
                ?>
            </div>
        </div>
        <div class="grid-8">
            <div class="box form">
                <!---provvv-->
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-article"></span>
                        <h3>Quote Review:</h3>
                    </div> <!-- .widget-header -->

                    <div class="widget-content">
                        <div id="grid-12"> 
                            <div class="field-group">
                                <label for="brandname" id="quote-item-header">Product and Services:</label>
                                <hr />
                                <div class="field" id="product-services">
                                    
                                </div>
                            </div>
                            <div class="field-group">
                                <label for="brandname" id="quote-item-header">Devices:</label>
                                <hr />
                                <div class="field"  id="devices">
                                     
                                </div>
                            </div>
                            <div class="field-group" id="total"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <ul>
                        <li style="list-style: square;"><a href="javascript:void(0);" onclick="location.href='quote_tool'">New Quote</a></li>
                        <li style="list-style: square;">
                            <a href="javascript:void(0);" id="viewQuotes">My Saved Quotes (Toggle)</a>
                            <ul style="margin: 5px 20px 5px 20px; display: none;" id="quoteList">
                                <?php foreach($quotes as $key => $quote) : ?>
                                <li>
                                    <a href="javascript:void(0);" qid="<?php echo $quote['SavedQuote']['id']; ?>" id="viewQuote"><?php echo $quote['SavedQuote']['name']; ?></a>
                                    -
                                    <a href="javascript:void(0);" qid="<?php echo $quote['SavedQuote']['id']; ?>" id="updateShippingMethod">Checkout</a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li style="list-style: square;"><a href="javascript:void(0);" id="print">Print Quote</a></li>
                        <li style="list-style: square;"><a href="javascript:void(0);" id="review">Review Quote</a></li>
                        <li style="list-style: square;"><a href="javascript:void(0);" id="saveQuote">Save Quote</a></li>
                        <li style="list-style: square;"><a href="javascript:void(0);" id="checkOut">CheckOut</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<div id="review_quote_container" style="display:none;"></div>
<div id="overlay" style="display: none"></div>
<div id="alert3" style="background-color: rgb(255, 255, 255); border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.75); left: 50%; position: fixed; z-index: 100; margin-left: -203px; top: 50px; width: 330px; height: 181px; display: none;">
    <div id="alertContent" style="margin-left:18px">
        <h2 style="color: green">Quote has been saved.</h2>
        <hr />
        <li>If you are currently logged in prestashop, </li>
        <li>Please logout your account and relogin.</li>
        <li>This process will update your prestashop cart.</li>
        <hr />
        
        <div id="alertActions" style="margin-top:5px">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="hide_alert2" style="padding-left:19px;padding-right:19px;">OK</button>
        </div>
    </div>
</div>
<?php echo $this->Html->script(array('quotes/admin')); ?>