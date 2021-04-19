<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 21:38:55
         compiled from "/var/www/itakishop/modules/blockadvertising/blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:967573646516dfd2f5bf303-09643589%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b6cd3a9117da6c86f5b4e936012232901db53c8' => 
    array (
      0 => '/var/www/itakishop/modules/blockadvertising/blockadvertising.tpl',
      1 => 1366110669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '967573646516dfd2f5bf303-09643589',
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
  'unifunc' => 'content_516dfd2f5d62c5_88125706',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516dfd2f5d62c5_88125706')) {function content_516dfd2f5d62c5_88125706($_smarty_tpl) {?>

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