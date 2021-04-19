<?php
echo $this->Html->css('accinfo', null, array('inline' => false));
$gaction = '';
$caction = '';
$baction = '';
if($action == 'billing_history') { $baction = 'selected'; } else if($action == 'creditcard_details') { $caction = 'selected'; } else { $gaction = 'selected'; }
?>

<div id="content">	
    <div id="contentHeader">
        <h1>Billing</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div id="tab">
                <div id="tab-header">
                    <ul>
                        <li class="<?php echo $gaction; ?> details"><?php echo $this->Html->link('General Info', 'billing'); ?></li>
                        <li class="<?php echo $caction; ?> contacts"><?php echo $this->Html->link('Credit Card Details', array('action' => "billing", 'creditcard_details')); ?></li>
                        <li class="<?php echo $baction; ?> password"><?php echo $this->Html->link('Billing History', array('action' => "billing", 'billing_history')); ?></li>
                    </ul>
                </div>
                <div id="tab-content">
                    <?php if(!empty($gaction)) : ?>
                    <div class="tabs details">
                        <?php echo $this->element('billing/general_details'); ?>
                    </div>
                    <?php elseif(!empty($caction)) : ?>
                    <div class="tabs contacts">
                        <?php echo $this->element('billing/creditcard_details'); ?>
                    </div>
                    <?php else : ?>
                    <div class="tabs password">
                        <?php echo $this->element('billing/billing_history'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- .grid-24 -->
    </div> <!-- .container -->
</div> <!-- #content -->