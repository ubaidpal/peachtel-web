<?php /* Smarty version Smarty-3.1.8, created on 2013-04-14 21:57:09
         compiled from "D:\web\itaki_prestashop\itaki_adminpanel/themes/default\template\helpers\list\list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25288516b5e7522f1c1-73556989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47d85847846fb6e6f1c9f2e3d84c372fd4d753b2' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\itaki_adminpanel/themes/default\\template\\helpers\\list\\list_action_view.tpl',
      1 => 1350987836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25288516b5e7522f1c1-73556989',
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
  'unifunc' => 'content_516b5e75244ac5_72200975',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516b5e75244ac5_72200975')) {function content_516b5e75244ac5_72200975($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<img src="../img/admin/details.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>