<?php /* Smarty version Smarty-3.1.8, created on 2020-04-22 13:05:22
         compiled from "/var/www/itakishop/themes/prestashop_v1/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9749436415ea079523c5bf7-64854356%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '249c6aa95879ab34089200ce491e37311b02e1b6' => 
    array (
      0 => '/var/www/itakishop/themes/prestashop_v1/footer.tpl',
      1 => 1367316691,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9749436415ea079523c5bf7-64854356',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'page_name' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ea079523db889_31274731',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea079523db889_31274731')) {function content_5ea079523db889_31274731($_smarty_tpl) {?>

		<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
				</div>

<!-- Right -->
                <?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>
				<div id="right_column" class="column grid_2 omega">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

				</div>
                <?php }?>
			</div>
            </div>
<!-- Footer -->
            <div id="top_footer">
            	<div style="margin: auto; max-width: 980px; color: #fff; font-size: 14px;">
				<label>2013 ©&nbsp;<span style="color: #F18F00;">Itaki Networks.</span>&nbsp;All rights reserved.</label>
				<label style="float: right;"><a id="topBtn" style="color: #fff;" href="javascript:void(0);">Back to top</a><span></span></label>
            	</div>
            </div>
		</div>
	<?php }?>
	</body>
</html>
<?php }} ?>