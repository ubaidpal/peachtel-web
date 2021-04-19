<?php /* Smarty version 2.6.26, created on 2012-12-07 07:40:24
         compiled from /var/www/clients/templates/default/clientregister.tpl */ ?>
<script type="text/javascript" src="includes/jscript/statesdropdown.js"></script>
<script type="text/javascript" src="includes/jscript/pwstrength.js"></script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['clientregistertitle'],'desc' => $this->_tpl_vars['LANG']['registerintro'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['noregistration']): ?>

    <div class="alert alert-error">
        <p><?php echo $this->_tpl_vars['LANG']['registerdisablednotice']; ?>
</p>
    </div>

<?php else: ?>

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
">
<input type="hidden" name="register" value="true" />

<fieldset class="control-group">

<div class="control-group">
<div class="col2half">

    <div class="control-group">
	    <label class="control-label" for="firstname"><?php echo $this->_tpl_vars['LANG']['clientareafirstname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="firstname" id="firstname" value="<?php echo $this->_tpl_vars['clientfirstname']; ?>
"<?php if (in_array ( 'firstname' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="lastname"><?php echo $this->_tpl_vars['LANG']['clientarealastname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="lastname" id="lastname" value="<?php echo $this->_tpl_vars['clientlastname']; ?>
"<?php if (in_array ( 'lastname' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="companyname"><?php echo $this->_tpl_vars['LANG']['clientareacompanyname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="companyname" id="companyname" value="<?php echo $this->_tpl_vars['clientcompanyname']; ?>
"<?php if (in_array ( 'companyname' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="email"><?php echo $this->_tpl_vars['LANG']['clientareaemail']; ?>
</label>
		<div class="controls">
		    <input type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['clientemail']; ?>
"<?php if (in_array ( 'email' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="password"><?php echo $this->_tpl_vars['LANG']['clientareapassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="password" id="password" value="<?php echo $this->_tpl_vars['clientpassword']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="password2"><?php echo $this->_tpl_vars['LANG']['clientareaconfirmpassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="password2" id="password2" value="<?php echo $this->_tpl_vars['clientpassword2']; ?>
" />
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

</div>
<div class="col2half">

    <div class="control-group">
	    <label class="control-label" for="address1"><?php echo $this->_tpl_vars['LANG']['clientareaaddress1']; ?>
</label>
		<div class="controls">
		    <input type="text" name="address1" id="address1" value="<?php echo $this->_tpl_vars['clientaddress1']; ?>
"<?php if (in_array ( 'address1' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="address2"><?php echo $this->_tpl_vars['LANG']['clientareaaddress2']; ?>
</label>
		<div class="controls">
		    <input type="text" name="address2" id="address2" value="<?php echo $this->_tpl_vars['clientaddress2']; ?>
"<?php if (in_array ( 'address2' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="city"><?php echo $this->_tpl_vars['LANG']['clientareacity']; ?>
</label>
		<div class="controls">
		    <input type="text" name="city" id="city" value="<?php echo $this->_tpl_vars['clientcity']; ?>
"<?php if (in_array ( 'city' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="state"><?php echo $this->_tpl_vars['LANG']['clientareastate']; ?>
</label>
		<div class="controls">
		    <input type="text" name="state" id="state" value="<?php echo $this->_tpl_vars['clientstate']; ?>
"<?php if (in_array ( 'state' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="postcode"><?php echo $this->_tpl_vars['LANG']['clientareapostcode']; ?>
</label>
		<div class="controls">
		    <input type="text" name="postcode" id="postcode" value="<?php echo $this->_tpl_vars['clientpostcode']; ?>
"<?php if (in_array ( 'postcode' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="country"><?php echo $this->_tpl_vars['LANG']['clientareacountry']; ?>
</label>
		<div class="controls">
		    <?php echo $this->_tpl_vars['clientcountriesdropdown']; ?>

		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="phonenumber"><?php echo $this->_tpl_vars['LANG']['clientareaphonenumber']; ?>
</label>
		<div class="controls">
		    <input type="text" name="phonenumber" id="phonenumber" value="<?php echo $this->_tpl_vars['clientphonenumber']; ?>
"<?php if (in_array ( 'phonenumber' , $this->_tpl_vars['uneditablefields'] )): ?> disabled="" class="disabled"<?php endif; ?> />
		</div>
	</div>

</div>
</div>

</fieldset>

<fieldset class="onecol">

<?php if ($this->_tpl_vars['currencies']): ?>
    <div class="control-group">
	    <label class="control-label" for="currency"><?php echo $this->_tpl_vars['LANG']['choosecurrency']; ?>
</label>
		<div class="controls" id="currency">
		    <select name="currency">
            <?php $_from = $this->_tpl_vars['currencies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curr']):
?>
            <option value="<?php echo $this->_tpl_vars['curr']['id']; ?>
"<?php if (! $_POST['currency'] && $this->_tpl_vars['curr']['default'] || $_POST['currency'] == $this->_tpl_vars['curr']['id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['curr']['code']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            </select>
		</div>
	</div>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['customfields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['customfield']):
?>
    <div class="control-group">
	    <label class="control-label" for="customfield<?php echo $this->_tpl_vars['customfield']['id']; ?>
"><?php echo $this->_tpl_vars['customfield']['name']; ?>
</label>
		<div class="controls">
		    <?php echo $this->_tpl_vars['customfield']['input']; ?>
 <?php echo $this->_tpl_vars['customfield']['description']; ?>

		</div>
	</div>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['securityquestions']): ?>
    <div class="control-group">
	    <label class="control-label" for="securityqans"><?php echo $this->_tpl_vars['LANG']['clientareasecurityquestion']; ?>
</label>
		<div class="controls">
		    <select name="securityqid" id="securityqid">
            <?php $_from = $this->_tpl_vars['securityquestions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['question']):
?>
            	<option value=<?php echo $this->_tpl_vars['question']['id']; ?>
><?php echo $this->_tpl_vars['question']['question']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            </select>
		</div>
	</div>
    <div class="control-group">
	    <label class="control-label" for="securityqans"><?php echo $this->_tpl_vars['LANG']['clientareasecurityanswer']; ?>
</label>
		<div class="controls">
		    <input type="password" name="securityqans" id="securityqans" />
		</div>
	</div>
<?php endif; ?>

</fieldset>

<?php if ($this->_tpl_vars['capatacha']): ?>
<h3><?php echo $this->_tpl_vars['LANG']['captchatitle']; ?>
</h3>
<p><?php echo $this->_tpl_vars['LANG']['captchaverify']; ?>
</p>
<?php if ($this->_tpl_vars['capatacha'] == 'recaptcha'): ?>
<div align="center"><?php echo $this->_tpl_vars['recapatchahtml']; ?>
</div>
<?php else: ?>
<p align="center"><img src="includes/verifyimage.php" align="middle" /> <input type="text" name="code" size="10" maxlength="5" class="input-small" /></p>
<?php endif; ?>
<?php endif; ?>

<br />

<?php if ($this->_tpl_vars['accepttos']): ?>
<div class="control-group">
    <label id="tosagree"></label>
    <div class="controls">
        <label class="checkbox">
            <input type="checkbox" name="accepttos" id="accepttos" value="on" >
            <?php echo $this->_tpl_vars['LANG']['ordertosagreement']; ?>
 <a href="<?php echo $this->_tpl_vars['tosurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['LANG']['ordertos']; ?>
</a>
        </label>
    </div>
</div>
<?php endif; ?>

<p align="center"><input class="btn btn-large btn-primary" type="submit" value="<?php echo $this->_tpl_vars['LANG']['clientregistertitle']; ?>
" /></p>

</form>

<?php endif; ?>

<br />
<br />