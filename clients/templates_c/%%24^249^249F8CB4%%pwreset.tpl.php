<?php /* Smarty version 2.6.26, created on 2020-04-22 11:52:27
         compiled from /var/www/clients/templates/default/pwreset.tpl */ ?>
<div class="halfwidthcontainer">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['pwreset'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['success']): ?>

  <div class="alert alert-success">
    <p><?php echo $this->_tpl_vars['LANG']['pwresetvalidationsent']; ?>
</p>
  </div>

  <p><?php echo $this->_tpl_vars['LANG']['pwresetvalidationcheckemail']; ?>


  <br />
  <br />
  <br />
  <br />

<?php else: ?>

<?php if ($this->_tpl_vars['errormessage']): ?>
<div class="alert alert-error textcenter">
    <p><?php echo $this->_tpl_vars['errormessage']; ?>
</p>
</div>
<?php endif; ?>

<form method="post" action="pwreset.php"  class="form-stacked">
<input type="hidden" name="action" value="reset" />

<?php if ($this->_tpl_vars['securityquestion']): ?>

<input type="hidden" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" />

<p><?php echo $this->_tpl_vars['LANG']['pwresetsecurityquestionrequired']; ?>
</p>


<div class="logincontainer">

    <fieldset class="control-group">

	    <div class="control-group">
		  <label class="control-label" for="answer"><?php echo $this->_tpl_vars['securityquestion']; ?>
:</label>
		  <div class="controls">
		    <input class="input-xlarge" name="answer" id="answer" type="text" value="<?php echo $this->_tpl_vars['answer']; ?>
" />
		  </div>
		</div>

        <div>
		  <p align="center"><input type="submit" class="btn btn-primary" value="<?php echo $this->_tpl_vars['LANG']['pwresetsubmit']; ?>
" /></p>
        </div>

    </fieldset>

</div>

<?php else: ?>

<p><?php echo $this->_tpl_vars['LANG']['pwresetdesc']; ?>
</p>

<div class="logincontainer">

    <fieldset class="control-group">

	    <div class="control-group">
		  <label class="control-label" for="email"><?php echo $this->_tpl_vars['LANG']['loginemail']; ?>
:</label>
		  <div class="controls">
		    <input class="input-xlarge" name="email" id="email" type="text" />
		  </div>
		</div>

        <div>
		  <p align="center"><input type="submit" class="btn btn-primary" value="<?php echo $this->_tpl_vars['LANG']['pwresetsubmit']; ?>
" /></p>
        </div>

    </fieldset>

</div>

<?php endif; ?>

</form>

<?php endif; ?>

</div>