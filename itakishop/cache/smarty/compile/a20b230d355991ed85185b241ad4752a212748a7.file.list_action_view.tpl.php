<?php /* Smarty version Smarty-3.1.8, created on 2013-06-16 23:54:29
         compiled from "/var/www/itakishop/itaki_adminpanel/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:178826463951be8875958e82-48616649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a20b230d355991ed85185b241ad4752a212748a7' => 
    array (
      0 => '/var/www/itakishop/itaki_adminpanel/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1366110668,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178826463951be8875958e82-48616649',
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
  'unifunc' => 'content_51be887598daf7_68561660',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51be887598daf7_68561660')) {function content_51be887598daf7_68561660($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<img src="../img/admin/details.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>