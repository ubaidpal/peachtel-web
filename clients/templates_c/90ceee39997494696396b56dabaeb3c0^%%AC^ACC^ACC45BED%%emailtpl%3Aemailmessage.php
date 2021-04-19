<?php /* Smarty version 2.6.26, created on 2020-04-22 12:15:38
         compiled from emailtpl:emailmessage */ ?>
<p><a href="<?php echo $this->_tpl_vars['company_domain']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['company_logo_url']; ?>
" alt="<?php echo $this->_tpl_vars['company_name']; ?>
" border="0" /></a></p>
<p>Dear <?php echo $this->_tpl_vars['client_name']; ?>
,</p><p>Recently a request was submitted to reset your password for our client area. If you did not request this, please ignore this email. It will expire and become useless in 2 hours time.</p><p>To reset your password, please visit the url below:<br /><a href="<?php echo $this->_tpl_vars['pw_reset_url']; ?>
"><?php echo $this->_tpl_vars['pw_reset_url']; ?>
</a></p><p>When you visit the link above, your password will be reset, and the new password will be emailed to you.</p><p><?php echo $this->_tpl_vars['signature']; ?>
</p>