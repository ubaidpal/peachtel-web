<?php /* Smarty version Smarty-3.1.8, created on 2013-03-11 00:06:55
         compiled from "D:\web\itaki_prestashop\itaki_adminpanel/themes/default\template\controllers\stats\stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22349513d585f333f74-42959833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '585b9da6152e08145ffa98a66b04d7a0259e6a6e' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\itaki_adminpanel/themes/default\\template\\controllers\\stats\\stats.tpl',
      1 => 1350987836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22349513d585f333f74-42959833',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_name' => 0,
    'module_instance' => 0,
    'hook' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_513d585f374bf1_06085800',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_513d585f374bf1_06085800')) {function content_513d585f374bf1_06085800($_smarty_tpl) {?>

<div>
	<?php if ($_smarty_tpl->tpl_vars['module_name']->value){?>
		<?php if ($_smarty_tpl->tpl_vars['module_instance']->value&&$_smarty_tpl->tpl_vars['module_instance']->value->active){?>
			<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>

		<?php }else{ ?>
			<?php echo smartyTranslate(array('s'=>'Module not found'),$_smarty_tpl);?>

		<?php }?>
	<?php }else{ ?>
		<h3 class="space"><?php echo smartyTranslate(array('s'=>'Please select a module in the left column.'),$_smarty_tpl);?>
</h3>
	<?php }?>
</div>
</div>
</div>


<?php }} ?>