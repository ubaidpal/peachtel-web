<?php /* Smarty version Smarty-3.1.8, created on 2013-04-15 06:10:49
         compiled from "D:\web\itaki_prestashop\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18761516bd2297c7560-54605696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '931bdf20cf18c01a57a31f706ccaee77fe2a4bc1' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1350987838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18761516bd2297c7560-54605696',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'adv_link' => 0,
    'adv_title' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516bd229801b17_82587365',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516bd229801b17_82587365')) {function content_516bd229801b17_82587365($_smarty_tpl) {?>

<!-- MODULE Block advertising -->
<div class="advertising_block">
	<a href="<?php echo $_smarty_tpl->tpl_vars['adv_link']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" width="155"  height="163" /></a>
</div>
<!-- /MODULE Block advertising -->
<?php }} ?>