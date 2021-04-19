<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 01:12:02
         compiled from "D:\web\itaki_prestashop\themes\prestashop_v1\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17828516cdda29fee47-93966939%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a285ce798fa56099f46e69c545a2b604b8aa7a25' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\themes\\prestashop_v1\\footer.tpl',
      1 => 1366078186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17828516cdda29fee47-93966939',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'page_name' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'PS_ALLOW_MOBILE_DEVICE' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516cdda2a5a962_08983476',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cdda2a5a962_08983476')) {function content_516cdda2a5a962_08983476($_smarty_tpl) {?>

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
                TEST
            </div>
            <div id="footer" class="grid_9 alpha omega clearfix">
                <div id="main_footer">
                    <?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

                    <?php if ($_smarty_tpl->tpl_vars['PS_ALLOW_MOBILE_DEVICE']->value){?>
                        <p class="center clearBoth"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true);?>
?mobile_theme_ok"><?php echo smartyTranslate(array('s'=>'Browse the mobile site'),$_smarty_tpl);?>
</a></p>
                    <?php }?>
                </div>
            </div>
		</div>
	<?php }?>
	</body>
</html>
<?php }} ?>