<?php /* Smarty version 2.6.26, created on 2012-11-30 19:00:04
         compiled from emailtpl:emailmessage */ ?>
<p><a href="<?php echo $this->_tpl_vars['company_domain']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['company_logo_url']; ?>
" alt="<?php echo $this->_tpl_vars['company_name']; ?>
" border="0" /></a></p>
<p> Dear <?php echo $this->_tpl_vars['client_name']; ?>
, </p> <p> This is a billing notice that your invoice no. <?php echo $this->_tpl_vars['invoice_num']; ?>
 which was generated on <?php echo $this->_tpl_vars['invoice_date_created']; ?>
 is now overdue. </p> <p> Your payment method is: <?php echo $this->_tpl_vars['invoice_payment_method']; ?>
 </p> <p> Invoice: <?php echo $this->_tpl_vars['invoice_num']; ?>
<br /> Balance Due: <?php echo $this->_tpl_vars['invoice_balance']; ?>
<br /> Due Date: <?php echo $this->_tpl_vars['invoice_date_due']; ?>
 </p> <p> You can login to your client area to view and pay the invoice at <?php echo $this->_tpl_vars['invoice_link']; ?>
 </p> <p> Your login details are as follows: </p> <p> Email Address: <?php echo $this->_tpl_vars['client_email']; ?>
<br /> Password: <?php echo $this->_tpl_vars['client_password']; ?>
 </p> <p> <?php echo $this->_tpl_vars['signature']; ?>
 </p>