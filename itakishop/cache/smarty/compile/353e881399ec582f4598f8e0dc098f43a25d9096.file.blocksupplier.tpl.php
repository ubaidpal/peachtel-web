<?php /* Smarty version Smarty-3.1.8, created on 2013-04-16 01:12:00
         compiled from "D:\web\itaki_prestashop\modules\blocksupplier\blocksupplier.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22622516cdda0b86950-13747370%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '353e881399ec582f4598f8e0dc098f43a25d9096' => 
    array (
      0 => 'D:\\web\\itaki_prestashop\\modules\\blocksupplier\\blocksupplier.tpl',
      1 => 1350987838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22622516cdda0b86950-13747370',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'display_link_supplier' => 0,
    'link' => 0,
    'suppliers' => 0,
    'text_list' => 0,
    'text_list_nb' => 0,
    'supplier' => 0,
    'form_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_516cdda0cd6738_33763076',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_516cdda0cd6738_33763076')) {function content_516cdda0cd6738_33763076($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\web\\itaki_prestashop\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<!-- Block suppliers module -->
<div id="suppliers_block_left" class="block blocksupplier">
	<h4><?php if ($_smarty_tpl->tpl_vars['display_link_supplier']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('supplier');?>
" title="<?php echo smartyTranslate(array('s'=>'Suppliers','mod'=>'blocksupplier'),$_smarty_tpl);?>
"><?php }?><?php echo smartyTranslate(array('s'=>'Suppliers','mod'=>'blocksupplier'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['display_link_supplier']->value){?></a><?php }?></h4>
	<div class="block_content">
<?php if ($_smarty_tpl->tpl_vars['suppliers']->value){?>
	<?php if ($_smarty_tpl->tpl_vars['text_list']->value){?>
	<ul class="bullet">
	<?php  $_smarty_tpl->tpl_vars['supplier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['supplier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['suppliers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['supplier']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['supplier']->iteration=0;
 $_smarty_tpl->tpl_vars['supplier']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['supplier_list']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['supplier']->key => $_smarty_tpl->tpl_vars['supplier']->value){
$_smarty_tpl->tpl_vars['supplier']->_loop = true;
 $_smarty_tpl->tpl_vars['supplier']->iteration++;
 $_smarty_tpl->tpl_vars['supplier']->index++;
 $_smarty_tpl->tpl_vars['supplier']->first = $_smarty_tpl->tpl_vars['supplier']->index === 0;
 $_smarty_tpl->tpl_vars['supplier']->last = $_smarty_tpl->tpl_vars['supplier']->iteration === $_smarty_tpl->tpl_vars['supplier']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['supplier_list']['first'] = $_smarty_tpl->tpl_vars['supplier']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['supplier_list']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['supplier_list']['last'] = $_smarty_tpl->tpl_vars['supplier']->last;
?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['supplier_list']['iteration']<=$_smarty_tpl->tpl_vars['text_list_nb']->value){?>
		<li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['supplier_list']['last']){?>last_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['supplier_list']['first']){?>first_item<?php }else{ ?>item<?php }?>">
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getsupplierLink($_smarty_tpl->tpl_vars['supplier']->value['id_supplier'],$_smarty_tpl->tpl_vars['supplier']->value['link_rewrite']);?>
" title="<?php echo smartyTranslate(array('s'=>'More about','mod'=>'blocksupplier'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['supplier']->value['name'];?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['supplier']->value['name'], 'htmlall', 'UTF-8');?>
</a>
		</li>
		<?php }?>
	<?php } ?>
	</ul>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['form_list']->value){?>
		<form action="<?php echo smarty_modifier_escape($_SERVER['SCRIPT_NAME'], 'htmlall', 'UTF-8');?>
" method="get">
			<p>
				<select id="supplier_list" onchange="autoUrl('supplier_list', '');">
					<option value="0"><?php echo smartyTranslate(array('s'=>'All suppliers','mod'=>'blocksupplier'),$_smarty_tpl);?>
</option>
				<?php  $_smarty_tpl->tpl_vars['supplier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['supplier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['suppliers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['supplier']->key => $_smarty_tpl->tpl_vars['supplier']->value){
$_smarty_tpl->tpl_vars['supplier']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['link']->value->getsupplierLink($_smarty_tpl->tpl_vars['supplier']->value['id_supplier'],$_smarty_tpl->tpl_vars['supplier']->value['link_rewrite']);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['supplier']->value['name'], 'htmlall', 'UTF-8');?>
</option>
				<?php } ?>
				</select>
			</p>
		</form>
	<?php }?>
<?php }else{ ?>
	<p><?php echo smartyTranslate(array('s'=>'No supplier','mod'=>'blocksupplier'),$_smarty_tpl);?>
</p>
<?php }?>
	</div>
</div>
<!-- /Block suppliers module -->
<?php }} ?>