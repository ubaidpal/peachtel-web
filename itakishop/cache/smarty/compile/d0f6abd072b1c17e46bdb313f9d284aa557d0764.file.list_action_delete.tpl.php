<?php /* Smarty version Smarty-3.1.8, created on 2013-04-15 22:00:24
         compiled from "D:\web\itaki_prestashop\itaki_adminpanel/themes/default\template\helpers\list\list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25521516cb0b8626b10-54387899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0f6abd072b1c17e46bdb313f9d284aa557d0764' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\itaki_adminpanel/themes/default\\template\\helpers\\list\\list_action_delete.tpl',
      1 => 1350987836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25521516cb0b8626b10-54387899',
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
  'unifunc' => 'content_516cb0b865e483_59870376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cb0b865e483_59870376')) {function content_516cb0b865e483_59870376($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="delete" <?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)){?>onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){ return true; }else{ event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/delete.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>