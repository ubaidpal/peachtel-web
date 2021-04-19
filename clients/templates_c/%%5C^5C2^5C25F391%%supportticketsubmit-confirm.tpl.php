<?php /* Smarty version 2.6.26, created on 2012-12-05 22:01:16
         compiled from /var/www/clients/templates/default/supportticketsubmit-confirm.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['navopenticket'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<br />

<div class="center80">

    <div class="alert alert-success textcenter">
        <p class="fontsize3" style="padding:10px;"><strong><?php echo $this->_tpl_vars['LANG']['supportticketsticketcreated']; ?>
 <a href="viewticket.php?tid=<?php echo $this->_tpl_vars['tid']; ?>
&amp;c=<?php echo $this->_tpl_vars['c']; ?>
" style="color:#000000;">#<?php echo $this->_tpl_vars['tid']; ?>
</a></strong></p>
    </div>

    <div class="center80">

        <p><?php echo $this->_tpl_vars['LANG']['supportticketsticketcreateddesc']; ?>
</p>

    </div>

</div>

<br />
<br />
<br />
<br />
<br />