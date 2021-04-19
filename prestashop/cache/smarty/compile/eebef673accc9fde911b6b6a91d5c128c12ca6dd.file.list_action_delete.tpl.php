<?php /* Smarty version Smarty-3.1.8, created on 2012-12-18 05:09:07
         compiled from "/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:33363211250d040c3138815-35882642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eebef673accc9fde911b6b6a91d5c128c12ca6dd' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_delete.tpl',
      1 => 1355368172,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33363211250d040c3138815-35882642',
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
  'unifunc' => 'content_50d040c31958e6_77097701',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d040c31958e6_77097701')) {function content_50d040c31958e6_77097701($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="delete" <?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)){?>onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){ return true; }else{ event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/delete.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>