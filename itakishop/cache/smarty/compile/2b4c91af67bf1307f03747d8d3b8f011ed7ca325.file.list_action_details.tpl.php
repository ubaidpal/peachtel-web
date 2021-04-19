<?php /* Smarty version Smarty-3.1.8, created on 2013-04-14 21:54:16
         compiled from "D:\web\itaki_prestashop\itaki_adminpanel/themes/default\template\helpers\list\list_action_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26902516b5dc8846758-90799620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b4c91af67bf1307f03747d8d3b8f011ed7ca325' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\itaki_adminpanel/themes/default\\template\\helpers\\list\\list_action_details.tpl',
      1 => 1350987836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26902516b5dc8846758-90799620',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'id' => 0,
    'action' => 0,
    'controller' => 0,
    'token' => 0,
    'json_params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516b5dc8884e14_23787376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516b5dc8884e14_23787376')) {function content_516b5dc8884e14_23787376($_smarty_tpl) {?>

<a class="pointer" id="details_<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="display_action_details('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['controller']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
', <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['json_params']->value, ENT_QUOTES, 'UTF-8');?>
); return false">
	<img src="../img/admin/more.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a>
<?php }} ?>