<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 01:11:59
         compiled from "D:\web\itaki_prestashop\modules\feeder\feederHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25415516cdd9f9bdb82-90667521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dcc394a958e4190692b361ef488806413252d737' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\modules\\feeder\\feederHeader.tpl',
      1 => 1350987838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25415516cdd9f9bdb82-90667521',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'meta_title' => 0,
    'feedUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516cdd9f9d6ce3_70652929',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cdd9f9d6ce3_70652929')) {function content_516cdd9f9d6ce3_70652929($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\web\\itaki_prestashop\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<link rel="alternate" type="application/rss+xml" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'html', 'UTF-8');?>
" href="<?php echo $_smarty_tpl->tpl_vars['feedUrl']->value;?>
" /><?php }} ?>