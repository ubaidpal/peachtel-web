<?php /* Smarty version 2.6.26, created on 2012-11-29 17:31:11
         compiled from /var/www/clients/templates/default/logout.tpl */ ?>
<div class="halfwidthcontainer">

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['logouttitle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="alert alert-success">
        <p><?php echo $this->_tpl_vars['LANG']['logoutsuccessful']; ?>
</p>
    </div>

    <div class="logincontainer">

        <p><a href="index.php"><strong><?php echo $this->_tpl_vars['LANG']['logoutcontinuetext']; ?>
</strong></a></p>

    </div>

</div>