<?php /* Smarty version Smarty-3.1.8, created on 2012-12-28 17:54:46
         compiled from "/var/www/prestashop/modules/blocksharefb/blocksharefb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201844386450de23364914d3-45526029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba3ad1ec75b5ba3e11bdf8188e5611d9cfcb36dd' => 
    array (
      0 => '/var/www/prestashop/modules/blocksharefb/blocksharefb.tpl',
      1 => 1355372806,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201844386450de23364914d3-45526029',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_link' => 0,
    'product_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50de23364d5a28_36682632',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50de23364d5a28_36682632')) {function content_50de23364d5a28_36682632($_smarty_tpl) {?>

<li id="left_share_fb">
	<a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['product_link']->value;?>
&amp;t=<?php echo $_smarty_tpl->tpl_vars['product_title']->value;?>
" class="js-new-window"><?php echo smartyTranslate(array('s'=>'Share on Facebook','mod'=>'blocksharefb'),$_smarty_tpl);?>
</a>
</li><?php }} ?>