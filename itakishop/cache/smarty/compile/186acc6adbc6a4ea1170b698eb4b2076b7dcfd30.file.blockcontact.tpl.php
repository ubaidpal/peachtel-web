<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 21:38:55
         compiled from "/var/www/itakishop/modules/blockcontact/blockcontact.tpl" */ ?>
<?php /*%%SmartyHeaderCode:416197502516dfd2f77e646-21611537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '186acc6adbc6a4ea1170b698eb4b2076b7dcfd30' => 
    array (
      0 => '/var/www/itakishop/modules/blockcontact/blockcontact.tpl',
      1 => 1366110669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '416197502516dfd2f77e646-21611537',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'telnumber' => 0,
    'email' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516dfd2f7b9955_92473700',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516dfd2f7b9955_92473700')) {function content_516dfd2f7b9955_92473700($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/var/www/itakishop/tools/smarty/plugins/modifier.escape.php';
?>

<div id="contact_block" class="block">
	<h4><?php echo smartyTranslate(array('s'=>'Contact us','mod'=>'blockcontact'),$_smarty_tpl);?>
</h4>
	<div class="block_content clearfix">
			<p><?php echo smartyTranslate(array('s'=>'Our hotline is available 24/7','mod'=>'blockcontact'),$_smarty_tpl);?>
</p>
			<?php if ($_smarty_tpl->tpl_vars['telnumber']->value!=''){?><p class="tel"><span class="label"><?php echo smartyTranslate(array('s'=>'Phone:','mod'=>'blockcontact'),$_smarty_tpl);?>
</span><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['telnumber']->value, 'htmlall', 'UTF-8');?>
</p><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['email']->value!=''){?><a href="mailto:<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['email']->value, 'htmlall', 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Contact our hotline','mod'=>'blockcontact'),$_smarty_tpl);?>
</a><?php }?>
	</div>
</div>
<?php }} ?>