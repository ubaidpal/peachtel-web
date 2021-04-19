<?php /* Smarty version 2.6.26, created on 2013-04-03 22:34:27
         compiled from /var/www/clients/templates/default/clientareachangepw.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['clientareanavchangepw'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/clientareadetailslinks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['successful']): ?>
<div class="alert alert-success">
    <p><?php echo $this->_tpl_vars['LANG']['changessavedsuccessfully']; ?>
</p>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['errormessage']): ?>
<div class="alert alert-error">
    <p class="bold"><?php echo $this->_tpl_vars['LANG']['clientareaerrors']; ?>
</p>
    <ul>
        <?php echo $this->_tpl_vars['errormessage']; ?>

    </ul>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=changepw">

  <fieldset class="onecol">

    <div class="control-group">
	    <label class="control-label" for="existingpw"><?php echo $this->_tpl_vars['LANG']['existingpassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="existingpw" id="existingpw" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="password"><?php echo $this->_tpl_vars['LANG']['newpassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="newpw" id="password" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="confirmpw"><?php echo $this->_tpl_vars['LANG']['confirmnewpassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="confirmpw" id="confirmpw" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="passstrength"><?php echo $this->_tpl_vars['LANG']['pwstrength']; ?>
</label>
		<div class="controls">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pwstrength.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</div>

  </fieldset>

  <div class="form-actions">
    <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->_tpl_vars['LANG']['clientareasavechanges']; ?>
" />
    <input class="btn" type="reset" value="<?php echo $this->_tpl_vars['LANG']['cancel']; ?>
" />
  </div>

</form>