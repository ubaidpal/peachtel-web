<?php /* Smarty version 2.6.26, created on 2012-12-05 22:01:34
         compiled from /var/www/clients/templates/default/affiliatessignup.tpl */ ?>
<?php if ($this->_tpl_vars['affiliatesystemenabled']): ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['affiliatesactivate'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="alert alert-block alert-info">

    <h2><?php echo $this->_tpl_vars['LANG']['affiliatesignuptitle']; ?>
</h2>

    <p><?php echo $this->_tpl_vars['LANG']['affiliatesignupintro']; ?>
</p>

</div>

<ul>
<li><?php echo $this->_tpl_vars['LANG']['affiliatesignupinfo1']; ?>
</li>
<li><?php echo $this->_tpl_vars['LANG']['affiliatesignupinfo2']; ?>
</li>
<li><?php echo $this->_tpl_vars['LANG']['affiliatesignupinfo3']; ?>
</li>
</ul>

<br />

<form method="post" action="affiliates.php">
<input type="hidden" name="activate" value="true" />
<p align="center"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['affiliatesactivate']; ?>
" class="btn btn-success" /></p>
</form>

<?php else: ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['affiliatestitle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="alert alert-warning">
    <p><?php echo $this->_tpl_vars['LANG']['affiliatesdisabled']; ?>
</p>
</div>

<?php endif; ?>

<br />
<br />
<br />