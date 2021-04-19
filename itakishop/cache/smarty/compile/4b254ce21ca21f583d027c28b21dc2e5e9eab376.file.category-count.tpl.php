<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 01:11:00
         compiled from "D:\web\itaki_prestashop\themes\prestashop_v1\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32229516cdd646f7e39-10403989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b254ce21ca21f583d027c28b21dc2e5e9eab376' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\themes\\prestashop_v1\\category-count.tpl',
      1 => 1365414999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32229516cdd646f7e39-10403989',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516cdd6477bad3_35082991',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cdd6477bad3_35082991')) {function content_516cdd6477bad3_35082991($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products.'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>