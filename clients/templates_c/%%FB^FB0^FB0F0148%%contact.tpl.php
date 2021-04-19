<?php /* Smarty version 2.6.26, created on 2020-04-22 11:52:17
         compiled from /var/www/clients/templates/default/contact.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['contacttitle'],'desc' => $this->_tpl_vars['LANG']['contactheader'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['sent']): ?>

<br />

<div class="alert alert-success textcenter">
    <p><strong><?php echo $this->_tpl_vars['LANG']['contactsent']; ?>
</strong></p>
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

<form method="post" action="contact.php?action=send" class="form-stacked center95">

    <fieldset class="control-group">

	    <div class="row">
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="name"><?php echo $this->_tpl_vars['LANG']['supportticketsclientname']; ?>
</label>
        			<div class="controls">
        			    <input class="input-xlarge" type="text" name="name" id="name" value="<?php echo $this->_tpl_vars['name']; ?>
" />
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="email"><?php echo $this->_tpl_vars['LANG']['supportticketsclientemail']; ?>
</label>
        			<div class="controls">
        			    <input class="input-xlarge" type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
" />
        			</div>
        		</div>
        	</div>
        </div>

        <div class="row">
    	    <div class="control-group">
    		    <label class="control-label bold" for="subject"><?php echo $this->_tpl_vars['LANG']['supportticketsticketsubject']; ?>
</label>
    			<div class="controls">
    			    <input class="input-xlarge" type="text" name="subject" id="subject" value="<?php echo $this->_tpl_vars['subject']; ?>
" style="width:80%;" />
    			</div>
    		</div>
		</div>

        <div class="control-group">
		    <label class="control-label bold" for="message"><?php echo $this->_tpl_vars['LANG']['contactmessage']; ?>
</label>
			<div class="controls">
			    <textarea name="message" id="message" rows="12" class="fullwidth"><?php echo $this->_tpl_vars['message']; ?>
</textarea>
			</div>
		</div>

    </fieldset>

<?php if ($this->_tpl_vars['capatacha']): ?>
<p><strong>&nbsp;&raquo;&nbsp;<?php echo $this->_tpl_vars['LANG']['captchatitle']; ?>
</strong></p>
<p><?php echo $this->_tpl_vars['LANG']['captchaverify']; ?>
</p>
<?php if ($this->_tpl_vars['capatacha'] == 'recaptcha'): ?>
<div align="center"><?php echo $this->_tpl_vars['recapatchahtml']; ?>
</div>
<?php else: ?>
<p align="center"><img src="includes/verifyimage.php" align="middle" /> <input type="text" class="input-small" name="code" size="10" maxlength="5" /></p>
<?php endif; ?>
<?php endif; ?>

    <p align="center"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['contactsend']; ?>
" class="btn btn-primary" /></p>

</form>

<?php endif; ?>

<br />
<br />
<br />