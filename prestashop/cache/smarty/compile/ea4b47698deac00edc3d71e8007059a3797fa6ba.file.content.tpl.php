<?php /* Smarty version Smarty-3.1.8, created on 2012-12-19 01:16:17
         compiled from "/var/www/prestashop/admin123807/themes/default/template/controllers/cms_content/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212852127850d15bb1c2a3a8-44660421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea4b47698deac00edc3d71e8007059a3797fa6ba' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/controllers/cms_content/content.tpl',
      1 => 1355367360,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212852127850d15bb1c2a3a8-44660421',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_breadcrumb' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50d15bb1c41e49_12571767',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d15bb1c41e49_12571767')) {function content_50d15bb1c41e49_12571767($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['cms_breadcrumb']->value)){?>
	<div class="cat_bar">
		<span style="color: #3C8534;"><?php echo smartyTranslate(array('s'=>'Current category'),$_smarty_tpl);?>
 :</span>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['cms_breadcrumb']->value;?>

	</div>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }} ?>