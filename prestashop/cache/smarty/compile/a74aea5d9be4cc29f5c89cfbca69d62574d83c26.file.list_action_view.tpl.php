<?php /* Smarty version Smarty-3.1.8, created on 2012-12-19 01:16:17
         compiled from "/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93232424750d15bb1beffa6-10138235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a74aea5d9be4cc29f5c89cfbca69d62574d83c26' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1355368190,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93232424750d15bb1beffa6-10138235',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50d15bb1c09664_18115752',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d15bb1c09664_18115752')) {function content_50d15bb1c09664_18115752($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<img src="../img/admin/details.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>