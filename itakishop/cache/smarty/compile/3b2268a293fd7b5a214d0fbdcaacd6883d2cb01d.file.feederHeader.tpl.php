<?php /* Smarty version Smarty-3.1.8, created on 2020-04-22 13:05:21
         compiled from "/var/www/itakishop/modules/feeder/feederHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6674225555ea079516d8415-46103753%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b2268a293fd7b5a214d0fbdcaacd6883d2cb01d' => 
    array (
      0 => '/var/www/itakishop/modules/feeder/feederHeader.tpl',
      1 => 1366110669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6674225555ea079516d8415-46103753',
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
  'unifunc' => 'content_5ea079516ed841_75544860',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea079516ed841_75544860')) {function content_5ea079516ed841_75544860($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/var/www/itakishop/tools/smarty/plugins/modifier.escape.php';
?>

<link rel="alternate" type="application/rss+xml" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'html', 'UTF-8');?>
" href="<?php echo $_smarty_tpl->tpl_vars['feedUrl']->value;?>
" /><?php }} ?>