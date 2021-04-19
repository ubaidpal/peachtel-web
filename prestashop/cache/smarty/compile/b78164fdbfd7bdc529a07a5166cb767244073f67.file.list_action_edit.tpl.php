<?php /* Smarty version Smarty-3.1.8, created on 2012-12-18 05:08:53
         compiled from "/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155907969250d040b5a92b25-93426103%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b78164fdbfd7bdc529a07a5166cb767244073f67' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1355368177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155907969250d040b5a92b25-93426103',
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
  'unifunc' => 'content_50d040b5ac5786_51483209',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d040b5ac5786_51483209')) {function content_50d040b5ac5786_51483209($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/edit.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>