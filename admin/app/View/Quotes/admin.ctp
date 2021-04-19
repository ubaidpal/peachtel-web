<?php echo $this->Html->css(array('quote/admin')); ?>
<div id="content">	
    <div id="contentHeader">
        <h1>Quotes Admin</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-16">
            <div class="box" id="categories">
                <?php foreach($WHMCScategories as $key => $category) : ?>
                <div class="widget widget-table <?php echo $category['Tblproductgroup']['id'] ?>" id="<?php echo (isset($category['QbAdminCategory']['id'])) ? $category['QbAdminCategory']['id'] : ''; ?>">
                    <div class="widget-header">
                        <h3 style="margin-top: 10px;color:#454545;font-size: 16px; margin-right: 1em;"><?php echo $category['Tblproductgroup']['name']; ?></h3>
                        <label style="float:right; margin-top:13px; margin-right: 13px;" id='remove'></label>
                        <label style="float:right; margin-top:13px; margin-right: 13px;" id='sorting2'></label>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Setup Fee</th>
                                    <th>Sort Order</th>
                                    <th>Payment Type</th>
                                    <th>Visible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($category['Tblproduct'] as $product) : ?>
                                <tr class="gradeA" id="<?php echo $product['id'] ?>">
                                    <td id="on_edit" class="Tblproduct <?php echo $product['id'] ?> name">
                                        <label id='sorting'></label>
                                        <label id='remove-product'></label>
                                        <input style="width:200px" value="<?php echo $product['name'] ?>" type="text" /></td>
                                    <td id="on_edit" class="Tblpricing <?php echo $product['Tblpricing']['id'] ?> monthly">
                                        <input style="width:70px" value="<?php echo $product['Tblpricing']['monthly'] ?>" type="text" /></td>
                                    <td id="on_edit" class="Tblpricing <?php echo $product['Tblpricing']['id'] ?> msetupfee">
                                        <input style="width:70px" value="<?php echo $product['Tblpricing']['msetupfee'] ?>" type="text" /></td>
                                    <td>
                                        <label style="padding: 10px;"><?php echo $product['order'] ?></label></td>
                                    <td id="on_edit" class="Tblproduct <?php echo $product['id'] ?> paytype">
                                        <?php echo $this->Form->input('', array('type' => 'select', 'options' => array('onetime' => 'One-Time', 'recurring' => 'Recurring', 'free' => 'Free'), 'value' => $product['paytype'])); ?></td>
                                    <td id="v_toggle">
                                        <?php 
                                            $val = (isset($product['QbAdminProduct']['visible']) && $product['QbAdminProduct']['visible']) ? "1" : "0";
                                            echo $this->Form->input('', array('id' => (isset($product['QbAdminProduct']['id'])) ? $product['QbAdminProduct']['id'] : '', 'class' => (isset($product['id'])) ? $product['id'] : '', 'value' => $val, 'options' => array('1' => 'Yes', '0' => 'No'), 'div' => false, 'label' => false));
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div id="addProductPane">
                            <a href="javascript:void(0);" id="addProduct">+ Add New Product</a>
                            <?php if($category['Tblproductgroup']['name'] == "PBX"): ?>
                            &nbsp;&nbsp;
                            <a href="javascript:void(0);" id="addDatacenter" key="<?php echo $key; ?>">+ Add Datacenters</a>
                            <?php endif; ?>
                        </div>
                        <?php if($category['Tblproductgroup']['name'] == "PBX"): ?>
                            <div id="datacenters">
                            <div id="wrap">
                                <div>Datacenter Name</div>
                                <div>Code</div>
                                <div>Product</div>
                                <div>Price</div>
                                <div>Action</div>
                            </div>
                            <div style="max-height: 250px; overflow-y: auto;">
                            <?php foreach($category['QbAdminCategory']["Datacenter"] as $datacenter): ?>
                                <div id="wrap">
                                    <div><?php echo $datacenter["name"]; ?></div>
                                    <div><?php echo $datacenter["code"]; ?></div>
                                    <div><?php echo $datacenter["Tblproduct"]["name"]; ?></div>
                                    <div>$<?php echo $datacenter["value"]; ?></div>
                                    <div>
                                        <label id="dcremove" did="<?php echo $datacenter["id"] ?>"></label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            </div>
                        <?php endif; ?>
                        <div style="padding: 10px 10px 0 10px; border-top: 1px solid #D5D5D5;" id="btn_holder">
                            <label style="display:inline-block; width: 160px;">Display Type: <?php echo $this->Form->input('', array('options' => $displayType, 'value' => (isset($category['QbAdminCategory']['displayType'])) ? $category['QbAdminCategory']['displayType'] : "", 'style' => 'display:inline;', 'class' => 'display_type', 'div' => false)); ?></label>
                            <label style="display:inline-block; width: 160px;">Visibility: <?php echo $this->Form->input('', array('options' => array('1' => 'Visible', '0' => 'Hidden'), 'value' => (isset($category['QbAdminCategory']['visible'])) ? $category['QbAdminCategory']['visible'] : "", 'style' => 'display:inline;', 'class' => 'visibility', 'div' => false)); ?></label>
                            <label style="float:right; display: none; margin-left: 10px;" id="" class="update_btn">Update Sorting</label>
                            <label style="float:right; display: none;" id="" class="save_changes">Save Changes</label>
                        </div>
                        <hr style="margin-bottom: 10px;" />
                        <div style="padding: 0 10px 10px 10px; border-bottom: 1px solid #D5D5D5;">
                        	<label>Description:</label>
                        	<textarea><?php echo !empty($category['QbAdminCategory']['description']) ? $category['QbAdminCategory']['description'] : "No Decsription"; ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="grid-8">
            <div class="box form">
                <!---provvv-->
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-article"></span>
                        <h3>Create new product</h3>
                    </div> <!-- .widget-header -->

                    <div class="widget-content">
                        <div id="grid-12" style="margin-left:19px"> 
                            <b>Notes: </b>
                            <hr style="margin:5px 0 5px 0;" />
                            Update Sorting: Drag each item to update sorting.
                            <br />
                            Editing Values: Fields can be edited inline.
                            <br /><br />    
                            <div style="text-align: right;"><h4><a href="javascript:void(0);" id="newGroup" style="color: #3d3d3d">+ Add New Group</a></h4></div>
                            <form method="POST" id="addGroupForm" action="createProductGroup" style="background: #fff; padding: 15px; border: 1px solid #d5d5d5;">
                                <div class="field-group">
                                    <label for="required">Group Name:</label>
                                    <div class="field">
                                        <input type="text" name="name" id="product" size="20"  placeholder="Enter Group Name" style="width:150; border-radius:5px" /> 	
                                    </div>
                                </div>
                                
                                <div class="field-group" style="text-align:left;">
                                    <button class="btn btn-grey btn-teal" style="width: 145px;">Add Group</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<div id="overlay" style="display: none;"></div>
<div id="addProductForm">
    <div id="close-btn"></div>
    <div id="header"></div>
    <form method="POST" action="createWhmcsProduct">
        <input type="hidden" name="type" value="other" /> 	
        <input type="hidden" name="gid"  /> 

        <div class="field-group">
            <label for="required">Product Name:</label>
            <div class="field">
                <input type="text" name="name" id="product" size="20"  placeholder="Enter Product Name" style="width:150; border-radius:5px" /> 	
            </div>
        </div>
        <br />
        <div class="field-group" style="text-align:left;">
            <button class="btn btn-grey btn-teal" style="width: 100px;">Add</button>
        </div>
    </form>
</div>
<div id="addDatacenterForm">
    <div id="close-btn"></div>
    <div id="header"></div>
    <form method="POST" action="addDatacenter">
        <input type="hidden" name="category_id"  /> 
        <div class="field-group">
            <label for="required">To Product:</label>
            <div class="field">
                <select id="product_id" name="product_id" style="width: 150px;"></select>    
            </div>
        </div>
        <div class="field-group">
            <label for="required">Product Name:</label>
            <div class="field">
                <input type="text" name="name" id="product" size="20"  placeholder="Enter Datacenter Name" style="width:150; border-radius:5px" />     
            </div>
        </div>

        <div class="field-group">
            <label for="required">Product Code:</label>
            <div class="field">
                <input type="text" name="code" id="product" size="20"  placeholder="Enter Datacenter Code" style="width:150; border-radius:5px" />     
            </div>
        </div>
        <div class="field-group">
            <label for="required">Product price:</label>
            <div class="field">
                <input type="text" name="value" id="product" size="20"  placeholder="Enter Datacenter Price" style="width:150; border-radius:5px" />
            </div>
        </div>
        <br />
        <div class="field-group" style="text-align:left;">
            <button class="btn btn-grey btn-teal" style="width: 100px;">Add</button>
        </div>
    </form>
</div>
<script>

    $("#addDatacenter").live('click', function() {
        var product = <?php echo json_encode($WHMCScategories); ?>;
        var product = product[$(this).attr('key')].Tblproduct;
        var options = "";
        $.each(product, function(index, pd) {
            options += "<option value='"+pd.id+"'>"+pd.name+"</option>";
        });
        $("#product_id").html(options);
        var parent = $(this).parents().eq(2);
        var parentClass = parent.attr('id');
        var groupId = parentClass;
        var textHeader = parent.find("h3").html();
        
        $("#addDatacenterForm input[name='category_id']").val(groupId);
        $("#addDatacenterForm #header").html("Add Datacenter to "+textHeader);
        $("#addDatacenterForm").fadeIn();
        $("#overlay").show();
    });
</script>
<?php echo $this->Html->script('quotes/quoteAdmin', array('inline' => false)); ?>