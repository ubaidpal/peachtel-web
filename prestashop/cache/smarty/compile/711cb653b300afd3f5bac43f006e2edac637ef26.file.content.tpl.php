<?php /* Smarty version Smarty-3.1.8, created on 2013-03-11 05:52:27
         compiled from "/var/www/prestashop/admin123807/themes/default/template/controllers/not_found/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:229366371513da95b348614-48187015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '711cb653b300afd3f5bac43f006e2edac637ef26' => 
    array (
      0 => '/var/www/prestashop/admin123807/themes/default/template/controllers/not_found/content.tpl',
      1 => 1355367621,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '229366371513da95b348614-48187015',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'controller' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_513da95b3c07b5_88932641',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_513da95b3c07b5_88932641')) {function content_513da95b3c07b5_88932641($_smarty_tpl) {?>
<h1><?php echo smartyTranslate(array('s'=>'The controller %s is missing or invalid.','sprintf'=>$_smarty_tpl->tpl_vars['controller']->value),$_smarty_tpl);?>
</h1>
<ul>
<li><a href="index.php"><?php echo smartyTranslate(array('s'=>'Go to Dashboard'),$_smarty_tpl);?>
</a></li>
<li><a href="#" onclick="window.history.back();"><?php echo smartyTranslate(array('s'=>'Back to previous page'),$_smarty_tpl);?>
</a></li>
</ul>
<?php }} ?>