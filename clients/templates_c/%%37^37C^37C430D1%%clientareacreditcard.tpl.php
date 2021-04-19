<?php /* Smarty version 2.6.26, created on 2012-12-06 02:32:30
         compiled from /var/www/clients/templates/default/clientareacreditcard.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['clientareanavccdetails'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/clientareadetailslinks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['remoteupdatecode']): ?>

  <div align="center">
    <?php echo $this->_tpl_vars['remoteupdatecode']; ?>

  </div>

<?php else: ?>

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
?action=creditcard">

  <fieldset class="onecol">

    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['creditcardcardtype']; ?>
</label>
		<div class="controls">
		    <input type="text" value="<?php echo $this->_tpl_vars['cardtype']; ?>
" disabled="true" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['creditcardcardnumber']; ?>
</label>
		<div class="controls">
		    <input type="text" value="<?php echo $this->_tpl_vars['cardnum']; ?>
" disabled="true" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['creditcardcardexpires']; ?>
</label>
		<div class="controls">
		    <input type="text" value="<?php echo $this->_tpl_vars['cardexp']; ?>
" disabled="true" class="input-small" />
		</div>
	</div>
<?php if ($this->_tpl_vars['cardissuenum']): ?>
    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['creditcardcardissuenum']; ?>
</label>
		<div class="controls">
		    <input type="text" value="<?php echo $this->_tpl_vars['cardissuenum']; ?>
" disabled="true" class="input-small" />
		</div>
	</div>
<?php endif; ?><?php if ($this->_tpl_vars['cardstart']): ?>
    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['creditcardcardstart']; ?>
</label>
		<div class="controls">
		    <input type="text" value="<?php echo $this->_tpl_vars['cardstart']; ?>
" disabled="true" class="input-mini" />
		</div>
	</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['allowcustomerdelete'] && $this->_tpl_vars['cardtype']): ?>
    <div class="control-group">
	    <label class="control-label">&nbsp;</label>
		<div class="controls">
            <input class="btn btn-danger" type="button" value="<?php echo $this->_tpl_vars['LANG']['creditcarddelete']; ?>
" onclick="window.location='clientarea.php?action=creditcard&delete=true'" />
        </div>
    </div>
<?php endif; ?>
  </fieldset>

<div class="styled_title"><h3><?php echo $this->_tpl_vars['LANG']['creditcardenternewcard']; ?>
</h3></div>

  <br />

  <fieldset class="onecol">

    <div class="control-group">
	    <label class="control-label" for="cctype"><?php echo $this->_tpl_vars['LANG']['creditcardcardtype']; ?>
</label>
		<div class="controls">
		    <select name="cctype" id="cctype">
            <?php $_from = $this->_tpl_vars['acceptedcctypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['cardtype']):
?>
                <option><?php echo $this->_tpl_vars['cardtype']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            </select>
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="ccnumber"><?php echo $this->_tpl_vars['LANG']['creditcardcardnumber']; ?>
</label>
		<div class="controls">
		    <input type="text" name="ccnumber" id="ccnumber" autocomplete="off" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="ccexpirymonth"><?php echo $this->_tpl_vars['LANG']['creditcardcardexpires']; ?>
</label>
		<div class="controls">
		    <select name="ccexpirymonth" id="ccexpirymonth"><?php $_from = $this->_tpl_vars['months']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['month']):
?><option><?php echo $this->_tpl_vars['month']; ?>
</option><?php endforeach; endif; unset($_from); ?></select> / <select name="ccexpiryyear"><?php $_from = $this->_tpl_vars['years']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year']):
?><option><?php echo $this->_tpl_vars['year']; ?>
</option><?php endforeach; endif; unset($_from); ?></select>
		</div>
	</div>
<?php if ($this->_tpl_vars['showccissuestart']): ?>
    <div class="control-group">
	    <label class="control-label" for="ccstartmonth"><?php echo $this->_tpl_vars['LANG']['creditcardcardstart']; ?>
</label>
		<div class="controls">
		    <input type="text" name="ccstartmonth" id="ccstartmonth" maxlength="2" class="input-small" style="width:30px;" /> / <input type="text" name="ccstartyear" id="ccstartyear" maxlength="2" class="input-small" style="width:30px;" value="<?php echo $this->_tpl_vars['ccstartyear']; ?>
" /> (MM/YY)
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="ccissuenum"><?php echo $this->_tpl_vars['LANG']['creditcardcardissuenum']; ?>
</label>
		<div class="controls">
		    <input type="text" name="ccissuenum" id="ccissuenum" maxlength="3" class="input-small" />
		</div>
	</div>
<?php endif; ?>

  </fieldset>

  <div class="form-actions">
    <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->_tpl_vars['LANG']['clientareasavechanges']; ?>
" />
    <input class="btn" type="reset" value="<?php echo $this->_tpl_vars['LANG']['cancel']; ?>
" />
  </div>

</form>

<?php endif; ?>