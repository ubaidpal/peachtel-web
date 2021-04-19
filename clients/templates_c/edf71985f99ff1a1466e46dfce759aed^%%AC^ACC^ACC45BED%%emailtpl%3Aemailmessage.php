<?php /* Smarty version 2.6.26, created on 2012-12-12 19:00:04
         compiled from emailtpl:emailmessage */ ?>
<p><a href="<?php echo $this->_tpl_vars['company_domain']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['company_logo_url']; ?>
" alt="<?php echo $this->_tpl_vars['company_name']; ?>
" border="0" /></a></p>
<p>Dear <?php echo $this->_tpl_vars['client_name']; ?>
,</p><p>This is a notice to remind you that you have an invoice due on <?php echo $this->_tpl_vars['invoice_date_due']; ?>
. We tried to bill you automatically but were unable to because we don't have your credit card details on file.</p><p>Invoice Date: <?php echo $this->_tpl_vars['invoice_date_created']; ?>
<br>Invoice #<?php echo $this->_tpl_vars['invoice_num']; ?>
<br>Amount Due: <?php echo $this->_tpl_vars['invoice_total']; ?>
<br>Due Date: <?php echo $this->_tpl_vars['invoice_date_due']; ?>
</p><p>Please login to our client area at the link below to submit your card details or make payment using a different method.</p><p><?php echo $this->_tpl_vars['invoice_link']; ?>
</p><p><?php echo $this->_tpl_vars['signature']; ?>
</p>