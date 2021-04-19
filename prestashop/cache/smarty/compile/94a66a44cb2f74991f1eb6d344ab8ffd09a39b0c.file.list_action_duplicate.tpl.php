<?php /* Smarty version Smarty-3.1.8, created on 2012-12-19 22:25:42
         compiled from "/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:142693404350d285365568c2-00796537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94a66a44cb2f74991f1eb6d344ab8ffd09a39b0c' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/helpers/list/list_action_duplicate.tpl',
      1 => 1355368176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '142693404350d285365568c2-00796537',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'confirm' => 0,
    'location_ok' => 0,
    'location_ko' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50d2853657a7c1_32154705',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d2853657a7c1_32154705')) {function content_50d2853657a7c1_32154705($_smarty_tpl) {?>
<a class="pointer" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')) document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ok']->value;?>
'; else document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ko']->value;?>
';">
	<img src="../img/admin/duplicate.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>