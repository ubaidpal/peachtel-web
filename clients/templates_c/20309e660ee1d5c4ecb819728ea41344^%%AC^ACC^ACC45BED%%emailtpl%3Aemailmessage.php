<?php /* Smarty version 2.6.26, created on 2012-12-10 06:05:27
         compiled from emailtpl:emailmessage */ ?>
<p><a href="<?php echo $this->_tpl_vars['company_domain']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['company_logo_url']; ?>
" alt="<?php echo $this->_tpl_vars['company_name']; ?>
" border="0" /></a></p>
<p>
<?php echo $this->_tpl_vars['ticket_message']; ?>

</p>
<p>
----------------------------------------------<br />
Ticket ID: #<?php echo $this->_tpl_vars['ticket_id']; ?>
<br />
Subject: <?php echo $this->_tpl_vars['ticket_subject']; ?>
<br />
Status: <?php echo $this->_tpl_vars['ticket_status']; ?>
<br />
Ticket URL: <?php echo $this->_tpl_vars['ticket_link']; ?>
<br />
----------------------------------------------
</p>