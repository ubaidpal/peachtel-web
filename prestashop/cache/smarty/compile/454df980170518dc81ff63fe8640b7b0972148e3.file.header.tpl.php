<?php /* Smarty version Smarty-3.1.8, created on 2013-03-25 04:29:30
         compiled from "/var/www/prestashop/pdf/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150294641651500aea4922f3-18637933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '454df980170518dc81ff63fe8640b7b0972148e3' => 
    array (
      0 => '/var/www/prestashop/pdf/header.tpl',
      1 => 1355373566,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150294641651500aea4922f3-18637933',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logo_path' => 0,
    'width_logo' => 0,
    'height_logo' => 0,
    'shop_name' => 0,
    'date' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51500aea4d0066_85884364',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51500aea4d0066_85884364')) {function content_51500aea4d0066_85884364($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/var/www/prestashop/tools/smarty/plugins/modifier.escape.php';
?>
<table style="width: 100%">
<tr>
	<td style="width: 50%">
		<?php if ($_smarty_tpl->tpl_vars['logo_path']->value){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['logo_path']->value;?>
" style="width:<?php echo $_smarty_tpl->tpl_vars['width_logo']->value;?>
px; height:<?php echo $_smarty_tpl->tpl_vars['height_logo']->value;?>
px;" />
		<?php }?>
	</td>
	<td style="width: 50%; text-align: right;">
		<table style="width: 100%">
			<tr>
				<td style="font-weight: bold; font-size: 14pt; color: #444; width: 100%"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['shop_name']->value, 'htmlall', 'UTF-8');?>
</td>
			</tr>
			<tr>
				<td style="font-size: 14pt; color: #9E9F9E"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['date']->value, 'htmlall', 'UTF-8');?>
</td>
			</tr>
			<tr>
				<td style="font-size: 14pt; color: #9E9F9E"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['title']->value, 'htmlall', 'UTF-8');?>
</td>
			</tr>
		</table>
	</td>
</tr>
</table>

<?php }} ?>