<?php echo $this->Html->css('adminQuotes', null, array('inline' => false)); ?>
<?php echo $this->Html->script('quotes/admin', array('inline' => false)); ?>
<div id="content">	
    
    <div id="contentHeader">
        <h1>Quotes Tool</h1>
    </div>
    
    <div class="container">
        
        <div class="grid-16">
            <div class="box brochure" id="categories">
                <div id="main-product-holder">
                    <div id="pbx-holder">
                        <?php echo $this->element('quotes/product_items'); ?>
                    </div>
                </div>
            </div>
            
			<!--<div id="phone_search_form" style="display:none";>
			    <hr />
			    <a href="javascript:void(0);" id="checkOutBtn">Continue Checkout</a>
			</div>-->
            <?php echo $this->element('quotes/checkout_form'); ?>
            
        </div>
        
        <div class="grid-8">
            <?php echo $this->element('quotes/item_list'); ?>
        </div>
        
    </div>
</div>

<!-- Load Quote dialogs -->
<?php echo $this->element('quotes/quote_alerts'); ?>
<script>
$(".helpBtn").toggle(
    function() {
        $(this).find('label').css('background', 'url("../images/dataTables/sort_both.png") repeat scroll -5px -2px transparent');
        $(this).parent('label').prev().slideToggle();
    },
    function() {
        $(this).find('label').css('background', 'url("../images/dataTables/sort_both.png") repeat scroll -5px -9px transparent');
        $(this).parent('label').prev().slideToggle();
    }
);


Load = {
    createSlider: function () {
        $('.item-slider').each(function() {
            $(this).selectToUISlider({
                tooltip:false,
                sliderOptions: {
                    animate:true,
                    labels: 10,
                    change:function(e, ui) {
                        var selectedOption = $(this).parent('.inputs').find('#item-slider option').eq(ui.values[0]);
                        var slider = $(this).parent('.inputs').find('input.sliderVal');
                        ajaxQuery('getProductDatacenters', {pid: selectedOption.attr('id')});
                        $("#datacenters").html(returndata);
                        slider.attr('id', selectedOption.attr('id'));
                        slider.val(1);
                        if(selectedOption.attr('pricing') == 0.00) {
                            $(this).parents().eq(1).find('label#price-holder').html("Free");
                        } else {
                            $(this).parents().eq(1).find('label#price-holder').html("$"+selectedOption.attr('pricing'));
                        }
                        Quote.updateProductItems();
                        /** toggle datacenters */
                        Load.toggleDatacenters();
                    }
                }
            }).hide();
        });
    },
    continueCheckOut: function() {
        var isCheckOut = "<?php echo $this->Session->read('isCheckout'); ?>";

        if(isCheckOut)
            $('#checkOut').click();
    },
    loadCached: function() {
        var dids = <?php echo json_encode($this->Session->read('dids')); ?>;
        var products = <?php echo json_encode($products) ?>;
        var lastInputId;

        Load.toggleDatacenters();

        if(products != null) {
            $.each(products, function(index, value) {
                $.each(value, function(index2, value2) {
                    $('#pbx-holder .inputs input[type="text"]#'+index2).attr('value', value2);
                    $('#pbx-holder .inputs input[type="radio"]#'+index2).attr('checked', true);
                    $('#pbx-holder .inputs select#'+index2).attr('value', value2);
                    $('#pbx-holder .inputs input[type="hidden"]#'+index2).attr('value', value2.count);
                    
                    if($('#pbx-holder .inputs select#'+index2).hasClass('did')) {
                        var select = $('#pbx-holder .inputs select#'+index2);
                        //Quote.DIDconfig(select);
                        if(dids != null && dids[index2] != undefined && dids[index2].length == value2) {
                            select.next("label").find("#configHolder").append("<label style='background: url(../images/sprite/sprite-12-black.png) repeat scroll 0 -1892px transparent;  display: inline-block; height: 12px; width: 12px; margin: 0 0 -1px 6px;' />");
                            select.addClass('configured');
                        }
                    }
                    
                    lastInputId = index2;
                });
            });
            Quote.updateProductItems();
        }
    },
    toggleDatacenters: function() {
        if($("#item-slider").val() == "None") {
            $("#datacenters .input").attr('style', 'color: #d2d2d2');
            $("#datacenters .input input").attr('disabled', 'true');
        } else {
           $("#datacenters .input").attr('style', 'color: #3d3d3d;');
           $("#datacenters .input input").removeAttr('disabled');
        }
    }
}

Load.createSlider();
Load.loadCached();
Load.continueCheckOut();
addDevices();   
</script>