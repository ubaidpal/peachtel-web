<?php /* Smarty version Smarty-3.1.8, created on 2013-02-26 22:45:37
         compiled from "D:\web\itaki_prestashop\themes\default\password.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29943512d816111b348-13425500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24fe6b3b1d6b34ee00333d4f62c91bb7c265ca02' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\themes\\default\\password.tpl',
      1 => 1350987840,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29943512d816111b348-13425500',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'confirmation' => 0,
    'request_uri' => 0,
    'link' => 0,
    'img_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_512d8161344425_82019414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512d8161344425_82019414')) {function content_512d8161344425_82019414($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\web\\itaki_prestashop\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Forgot your password?'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<h1><?php echo smartyTranslate(array('s'=>'Forgot your password?'),$_smarty_tpl);?>
</h1>

<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if (isset($_smarty_tpl->tpl_vars['confirmation']->value)&&$_smarty_tpl->tpl_vars['confirmation']->value==1){?>
<p class="success"><?php echo smartyTranslate(array('s'=>'Your password has been successfully reset and a confirmation has been sent to your e-mail address:'),$_smarty_tpl);?>
 <?php echo stripslashes(smarty_modifier_escape($_POST['email'], 'htmlall', 'UTF-8'));?>
</p>
<?php }elseif(isset($_smarty_tpl->tpl_vars['confirmation']->value)&&$_smarty_tpl->tpl_vars['confirmation']->value==2){?>
<p class="success"><?php echo smartyTranslate(array('s'=>'A confirmation e-mail has been sent to your address:'),$_smarty_tpl);?>
 <?php echo stripslashes(smarty_modifier_escape($_POST['email'], 'htmlall', 'UTF-8'));?>
</p>
<?php }else{ ?>
<p><?php echo smartyTranslate(array('s'=>'Please enter the e-mail address used to register. We will send your new password to that address.'),$_smarty_tpl);?>
</p>
<form action="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['request_uri']->value, 'htmlall', 'UTF-8');?>
" method="post" class="std" id="form_forgotpassword">
	<fieldset>
		<p class="text">
			<label for="email"><?php echo smartyTranslate(array('s'=>'E-mail:'),$_smarty_tpl);?>
</label>
			<input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])){?><?php echo stripslashes(smarty_modifier_escape($_POST['email'], 'htmlall', 'UTF-8'));?>
<?php }?>" />
		</p>
		<p class="submit">
			<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'Retrieve Password'),$_smarty_tpl);?>
" />
		</p>
	</fieldset>
</form>
<?php }?>
<p class="clear">
	<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Return to Login'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/my-account.gif" alt="<?php echo smartyTranslate(array('s'=>'Return to Login'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication');?>
" title="<?php echo smartyTranslate(array('s'=>'Back to Login'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Back to Login'),$_smarty_tpl);?>
</a>
</p>
<?php }} ?>