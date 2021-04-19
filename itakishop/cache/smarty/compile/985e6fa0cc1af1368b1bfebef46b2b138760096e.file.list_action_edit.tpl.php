<?php /* Smarty version Smarty-3.1.8, created on 2013-06-07 02:01:39
         compiled from "/var/www/itakishop/itaki_adminpanel/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93157168851b1774316f602-17593667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '985e6fa0cc1af1368b1bfebef46b2b138760096e' => 
    array (
      0 => '/var/www/itakishop/itaki_adminpanel/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1366110668,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93157168851b1774316f602-17593667',
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
  'unifunc' => 'content_51b1774317dff0_18222034',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51b1774317dff0_18222034')) {function content_51b1774317dff0_18222034($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/edit.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>