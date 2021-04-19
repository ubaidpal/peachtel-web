<div class="box form" style="background: #ecf5ff; margin:0 18px 0 0; border: 1px solid #d5d5d5;">
    <div class="widget">
        <div class="widget-header">
            <h3>Quote Cart:</h3>
            <img src="../images/gallery/cartlogo.png" />
        </div>

        <div class="widget-content">
            <div id="grid-12"> 
                <div class="field-group">
                    <div class="field" id="product-services">

                    </div>
                </div>
                <div class="field-group">
                    <div class="field"  id="devices">

                    </div>
                </div>
                <div class="field-group" id="total"></div>
            </div>
        </div>
    </div>
    
    <div>
        <ul id="quote_nav">
            <li>
                <a href="javascript:void(0);" id="checkOut" class="<?php echo !empty($client) ? 'loggedIn' : ''; ?>">
                    <span style="position: relative; padding-right: 45px; display: inline-block;">
                        Check Out
                        <label style="background: url(../images/gallery/cart.png) repeat scroll 0px 0px transparent; display: inline-block; height: 25px; width: 40px; vertical-align: middle; position: absolute; right: 0px;top:-1px;"></label>
                    </span>
                </a>
            </li>
            <li><a href="javascript:void(0);" id="newQuote" url="<?php echo isset($_GET['admin']) ? 1 : 0; ?>">New Quote</a></li>
            <?php if(!empty($userDetails)) : ?>
            <li>
                <a href="javascript:void(0);" id="viewQuotes">My Saved Quotes (Toggle)</a>
                <ul style="margin: 5px 10px; display: none;" id="quoteList">
                    <?php if(!empty($quotes)) : ?>
                        <?php foreach($quotes as $key => $quote) : ?>
                        <?php if(in_array($quote['SavedQuote']['status'], array('saved', 'update_for_shipment'))): ?>

                        <li>
                            <label>#<?php echo $quote['SavedQuote']['name']; ?></label>
                            <a href="javascript:void(0);" qid="<?php echo $quote['SavedQuote']['id']; ?>" id="viewQuote"><?php echo 'View Quote'; ?></a>
                            <a href="javascript:void(0);" qid="<?php echo $quote['SavedQuote']['id']; ?>" id="updateShippingMethod" class="<?php echo !empty($client) ? 'loggedIn' : ''; ?>">Checkout</a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><label style="color: #fff;">No Saved Quotes.</label></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            <li><a href="javascript:void(0);" id="review">Review Quote</a></li>
            <li>
                <a href="javascript:void(0);" id="print">
                    <span style="position: relative; padding-right: 45px; display: inline-block;">
                        Print Quote
                        <label style="background: url(../images/gallery/cart.png) repeat scroll 0px 64px transparent; display: inline-block; height: 28px; width: 40px; vertical-align: middle; position: absolute; right: 0px;top:-2px;"></label>
                    </span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" id="saveQuote" class="<?php echo !empty($client) ? 'loggedIn' : ''; ?>">
                    <span style="position: relative; padding-right: 45px; display: inline-block;">
                        Save Quote
                        <label style="background: url(../images/gallery/cart.png) repeat scroll 0px 98px transparent; display: inline-block; height: 28px; width: 40px; vertical-align: middle; position: absolute; right: 0px;top:-2px;"></label>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>