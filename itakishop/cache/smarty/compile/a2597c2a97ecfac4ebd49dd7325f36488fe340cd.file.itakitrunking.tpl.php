<?php /* Smarty version Smarty-3.1.8, created on 2013-04-15 03:23:12
         compiled from "D:\web\itaki_prestashop\modules\itakitrunking\itakitrunking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29854516baae0276782-91220733%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a2597c2a97ecfac4ebd49dd7325f36488fe340cd' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\modules\\itakitrunking\\itakitrunking.tpl',
      1 => 1357529612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29854516baae0276782-91220733',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userData' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516baae0340a14_01762609',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516baae0340a14_01762609')) {function content_516baae0340a14_01762609($_smarty_tpl) {?><link rel="stylesheet" href="/prestashop/modules/itakitrunking/css/style.css" type="text/css">
<script>
    $(function(){
        $("#trunking_tabs ul li a").click(function(){
            var tab = $(this).attr("href");

            $("#trunking_tabs ul li").attr("class", "");
            $(this).parent().attr("class", "active");

            $("#trunking_tabs div").attr("class", "");
            $(tab).attr("class", "selected");

            return false;
        });
    });
</script>

<div class="block">
    <div id="trunking_tabs">
        <ul>
            <li class="active"><a href="#tabs-1">Billing</a></li>
            <li><a href="#tabs-2">PBX</a></li>
            <li><a href="#tabs-3">Provisioning</a></li>
            <li><a href="#tabs-4">Store</a></li>
            <li><a href="#tabs-5">Support</a></li>
            <li><a href="#tabs-6">Quotes</a></li>
        </ul>
        <div id="tabs-1" class="selected">
            <h4 style="color: #fff;">General Info</h4>
            <br />
            <p>Account Balance: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['STATS']['CREDITBALANCE'];?>
</p>
            <p>Auto Replenish is set to : On</p>
            <p>Payment Methods is <label style="color: blue;"><?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['CCTYPE'];?>
</label> ending in <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['CCLASTFOUR'];?>
 expiring N/A</p>
            <p>Make a Payment of $100</p>
            
            <hr />
            <br />
            
            <h4 style="color: #fff;">Billing Address</h4>
            <br />
            <p>Address 1: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['ADDRESS1'];?>
</p>
            <p>Address 2: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['ADDRESS2'];?>
</p>
            <p>City: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['CITY'];?>
</p>
            <p>State: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['STATE'];?>
</p>
            <p>Postcode: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['POSTCODE'];?>
</p>
            <p>Country: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['COUNTRYNAME'];?>
</p>
            <p>Phonenumber: <?php echo $_smarty_tpl->tpl_vars['userData']->value['WHMCSAPI']['CLIENT']['PHONENUMBER'];?>
</p>
        </div>
        
        <div id="tabs-2">2</div>
        <div id="tabs-3">3</div>
        <div id="tabs-4">4</div>
        <div id="tabs-5">5</div>
        <div id="tabs-6">6</div>
    </div>
</div><?php }} ?>