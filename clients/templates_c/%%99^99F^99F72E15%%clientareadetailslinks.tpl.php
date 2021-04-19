<?php /* Smarty version 2.6.26, created on 2012-12-06 02:32:26
         compiled from default/clientareadetailslinks.tpl */ ?>
<div>
    <ul class="nav nav-tabs">

        <li <?php if ($this->_tpl_vars['clientareaaction'] == 'details'): ?>class="active"<?php endif; ?>><a href="clientarea.php?action=details"><?php echo $this->_tpl_vars['LANG']['clientareanavdetails']; ?>
</a></li>

        <?php if ($this->_tpl_vars['condlinks']['updatecc']): ?><li <?php if ($this->_tpl_vars['clientareaaction'] == 'creditcard'): ?>class="active"<?php endif; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?action=creditcard"><?php echo $this->_tpl_vars['LANG']['clientareanavccdetails']; ?>
</a></li><?php endif; ?>

        <li <?php if ($this->_tpl_vars['clientareaaction'] == 'contacts' || $this->_tpl_vars['clientareaaction'] == 'addcontact'): ?>class="active"<?php endif; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?action=contacts"><?php echo $this->_tpl_vars['LANG']['clientareanavcontacts']; ?>
</a></li>

        <li <?php if ($this->_tpl_vars['clientareaaction'] == 'changepw'): ?>class="active"<?php endif; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?action=changepw"><?php echo $this->_tpl_vars['LANG']['clientareanavchangepw']; ?>
</a></li>

        <?php if ($this->_tpl_vars['condlinks']['updatesq']): ?><li <?php if ($this->_tpl_vars['clientareaaction'] == 'changesq'): ?>class="active"<?php endif; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?action=changesq"><?php echo $this->_tpl_vars['LANG']['clientareanavsecurityquestions']; ?>
</a></li><?php endif; ?>

    </ul>
</div>
<div class="clear"></div>