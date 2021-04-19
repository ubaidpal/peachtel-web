<?php /* Smarty version Smarty-3.1.8, created on 2020-04-22 11:58:33
         compiled from "/var/www/itakishop/themes/prestashop_v1/category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3022947285ea069a9b39586-85050188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb03df9ea47088b55c9b1ee1b310723668058d3b' => 
    array (
      0 => '/var/www/itakishop/themes/prestashop_v1/category-count.tpl',
      1 => 1366110670,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3022947285ea069a9b39586-85050188',
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
  'unifunc' => 'content_5ea069a9bd3957_53865841',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea069a9bd3957_53865841')) {function content_5ea069a9bd3957_53865841($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products.'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>