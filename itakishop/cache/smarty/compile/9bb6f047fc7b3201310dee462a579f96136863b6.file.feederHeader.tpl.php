<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 06:14:26
         compiled from "D:\web\prestaki\modules\feeder\feederHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2624516d248249da88-74758903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9bb6f047fc7b3201310dee462a579f96136863b6' => 
    array (
      0 => 'D:\\web\\prestaki\\modules\\feeder\\feederHeader.tpl',
      1 => 1350987838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2624516d248249da88-74758903',
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
  'unifunc' => 'content_516d24824ba6f4_85291042',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516d24824ba6f4_85291042')) {function content_516d24824ba6f4_85291042($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\web\\prestaki\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<link rel="alternate" type="application/rss+xml" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'html', 'UTF-8');?>
" href="<?php echo $_smarty_tpl->tpl_vars['feedUrl']->value;?>
" /><?php }} ?>