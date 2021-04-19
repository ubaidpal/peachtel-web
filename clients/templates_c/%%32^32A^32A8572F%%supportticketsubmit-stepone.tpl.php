<?php /* Smarty version 2.6.26, created on 2012-12-04 09:37:17
         compiled from /var/www/clients/templates/default/supportticketsubmit-stepone.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['navopenticket'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><?php echo $this->_tpl_vars['LANG']['supportticketsheader']; ?>
</p>

<br />

<div class="row">
    <div class="center80">
    <?php $_from = $this->_tpl_vars['departments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['department']):
?>
        <div class="col2half">
            <div class="contentpadded">
                <p><div class="fontsize2"><img src="images/emails.gif" /> &nbsp;<strong><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?step=2&amp;deptid=<?php echo $this->_tpl_vars['department']['id']; ?>
"><?php echo $this->_tpl_vars['department']['name']; ?>
</a></strong></div></p>
    			<?php if ($this->_tpl_vars['department']['description']): ?><p><?php echo $this->_tpl_vars['department']['description']; ?>
</p><?php endif; ?>
            </div>
        </div>
    <?php endforeach; endif; unset($_from); ?>
    </div>
</div>

<br />
<br />
<br />