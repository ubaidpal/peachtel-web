<?php /* Smarty version Smarty-3.1.8, created on 2013-02-21 12:08:53
         compiled from "D:\web\itaki_prestashop\itaki_adminpanel\themes\default\template\helpers\list\list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16011512654a5b09ac4-52316067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e0862b48a2cdf6732f76e99fa31a3dedb1cfc6f' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\itaki_adminpanel\\themes\\default\\template\\helpers\\list\\list_action_delete.tpl',
      1 => 1350987836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16011512654a5b09ac4-52316067',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'confirm' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_512654a5b57aa5_83817551',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512654a5b57aa5_83817551')) {function content_512654a5b57aa5_83817551($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="delete" <?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)){?>onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){ return true; }else{ event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/delete.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>