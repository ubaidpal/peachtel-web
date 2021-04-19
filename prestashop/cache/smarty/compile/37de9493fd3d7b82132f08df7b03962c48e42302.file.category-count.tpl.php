<?php /* Smarty version Smarty-3.1.8, created on 2012-12-19 01:16:40
         compiled from "/var/www/prestashop/themes/default/category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50095506850d15bc8049658-90707014%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37de9493fd3d7b82132f08df7b03962c48e42302' => 
    array (
      0 => '/var/www/prestashop/themes/default/category-count.tpl',
      1 => 1355373576,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50095506850d15bc8049658-90707014',
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
  'unifunc' => 'content_50d15bc80794d0_60919436',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d15bc80794d0_60919436')) {function content_50d15bc80794d0_60919436($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products.'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>