<?php /* Smarty version Smarty-3.1.8, created on 2013-04-15 22:18:10
         compiled from "D:\web\itaki_prestashop\themes\prestashop_v1\product-compare.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31189516cb4e2bc2088-22292614%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '161a9ffd550c28c2a97f7ee63d2df9a3906d4137' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\themes\\prestashop_v1\\product-compare.tpl',
      1 => 1365414999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31189516cb4e2bc2088-22292614',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comparator_max_item' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516cb4e2c3bfb6_85844399',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cb4e2c3bfb6_85844399')) {function content_516cb4e2c3bfb6_85844399($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['comparator_max_item']->value){?>
<script type="text/javascript">
// <![CDATA[
	var min_item = '<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
';
	var max_item = "<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
";
//]]>
</script>

	<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('products-comparison');?>
" onsubmit="true">
		<p>
		<input type="submit" id="bt_compare" class="button" value="<?php echo smartyTranslate(array('s'=>'Compare'),$_smarty_tpl);?>
" />
		<input type="hidden" name="compare_product_list" class="compare_product_list" value="" />
		</p>
	</form>
<?php }?>

<?php }} ?>