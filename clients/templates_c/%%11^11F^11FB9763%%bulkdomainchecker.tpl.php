<?php /* Smarty version 2.6.26, created on 2020-04-22 12:15:36
         compiled from /var/www/clients/templates/default/bulkdomainchecker.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['domaintitle'],'desc' => $this->_tpl_vars['LANG']['domaincheckerintro'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['inccode']): ?>
<div class="alert alert-error textcenter">
    <?php echo $this->_tpl_vars['LANG']['captchaverifyincorrect']; ?>

</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['bulkdomainsearchenabled']): ?><p align="right"><a href="domainchecker.php"><?php echo $this->_tpl_vars['LANG']['domainsimplesearch']; ?>
</a> | <a href="domainchecker.php?search=bulktransfer"><?php echo $this->_tpl_vars['LANG']['domainbulktransfersearch']; ?>
</a></p><?php endif; ?>

<form method="post" action="domainchecker.php?search=bulk">

<div class="well">
    <p><?php echo $this->_tpl_vars['LANG']['domainbulksearchintro']; ?>
</p>
    <br />
    <div class="textcenter">
        <textarea name="bulkdomains" rows="8" style="width:60%;"><?php echo $this->_tpl_vars['bulkdomains']; ?>
</textarea>
    </div>
    <div class="textcenter">
        <?php if ($this->_tpl_vars['capatacha']): ?>
        <div class="captchainput">
            <p><?php echo $this->_tpl_vars['LANG']['captchaverify']; ?>
</p>
            <?php if ($this->_tpl_vars['capatacha'] == 'recaptcha'): ?>
            <p><?php echo $this->_tpl_vars['recapatchahtml']; ?>
</p>
            <?php else: ?>
            <p><img src="includes/verifyimage.php" align="middle" /> <input type="text" name="code" class="input-small" maxlength="5" /></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="internalpadding"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['checkavailability']; ?>
" class="btn btn-primary btn-large" /></div>
    </div>
</div>

</form>

<?php if ($this->_tpl_vars['invalid']): ?>
	<p class="fontsize3 domcheckererror textcenter"><?php echo $this->_tpl_vars['LANG']['domaincheckerbulkinvaliddomain']; ?>
</p>
<?php endif; ?>

<?php if ($this->_tpl_vars['availabilityresults']): ?>

<br />

<div class="center80">

<form method="post" action="<?php echo $this->_tpl_vars['systemsslurl']; ?>
cart.php?a=add&domain=register">

<table class="zebra-striped">
    <thead>
        <tr>
            <th></th>
            <th><?php echo $this->_tpl_vars['LANG']['domainname']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainstatus']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainmoreinfo']; ?>
</th>
        </tr>
    </thead>
    <tbody>
<?php $_from = $this->_tpl_vars['availabilityresults']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['result']):
?>
        <tr>
            <td class="textcenter"><?php if ($this->_tpl_vars['result']['status'] == 'available'): ?><input type="checkbox" name="domains[]" value="<?php echo $this->_tpl_vars['result']['domain']; ?>
" <?php if ($this->_tpl_vars['num'] == '0' && $this->_tpl_vars['available']): ?>checked <?php endif; ?>/><input type="hidden" name="domainsregperiod[<?php echo $this->_tpl_vars['result']['domain']; ?>
]" value="<?php echo $this->_tpl_vars['result']['period']; ?>
" /><?php else: ?>X<?php endif; ?></td>
            <td><?php echo $this->_tpl_vars['result']['domain']; ?>
</td>
            <td class="textcenter <?php if ($this->_tpl_vars['result']['status'] == 'available'): ?>domcheckersuccess<?php else: ?>domcheckererror<?php endif; ?>"><?php if ($this->_tpl_vars['result']['status'] == 'available'): ?><?php echo $this->_tpl_vars['LANG']['domainavailable']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['domainunavailable']; ?>
<?php endif; ?></td>
            <td class="textcenter"><?php if ($this->_tpl_vars['result']['status'] == 'unavailable'): ?><a href="http://<?php echo $this->_tpl_vars['result']['domain']; ?>
" target="_blank">WWW</a> <a href="#" onclick="popupWindow('whois.php?domain=<?php echo $this->_tpl_vars['result']['domain']; ?>
','whois',650,420);return false">WHOIS</a><?php else: ?><select name="domainsregperiod[<?php echo $this->_tpl_vars['result']['domain']; ?>
]"><?php $_from = $this->_tpl_vars['result']['regoptions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['period'] => $this->_tpl_vars['regoption']):
?><option value="<?php echo $this->_tpl_vars['period']; ?>
"><?php echo $this->_tpl_vars['period']; ?>
 <?php echo $this->_tpl_vars['LANG']['orderyears']; ?>
 @ <?php echo $this->_tpl_vars['regoption']['register']; ?>
</option><?php endforeach; endif; unset($_from); ?></select><?php endif; ?></td>
        </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p align="center"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['ordernowbutton']; ?>
 &raquo;" class="btn btn-danger" /></p>

</form>

</div>

<?php else: ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['domainspricing'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="center80">

<table class="table table-striped table-framed">
    <thead>
        <tr>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domaintld']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainminyears']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainsregister']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainstransfer']; ?>
</th>
            <th class="textcenter"><?php echo $this->_tpl_vars['LANG']['domainsrenew']; ?>
</th>
        </tr>
    </thead>
    <tbody>
<?php $_from = $this->_tpl_vars['tldpricelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tldpricelist']):
?>
        <tr>
            <td><?php echo $this->_tpl_vars['tldpricelist']['tld']; ?>
</td>
            <td class="textcenter"><?php echo $this->_tpl_vars['tldpricelist']['period']; ?>
</td>
            <td class="textcenter"><?php if ($this->_tpl_vars['tldpricelist']['register']): ?><?php echo $this->_tpl_vars['tldpricelist']['register']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['domainregnotavailable']; ?>
<?php endif; ?></td>
            <td class="textcenter"><?php if ($this->_tpl_vars['tldpricelist']['transfer']): ?><?php echo $this->_tpl_vars['tldpricelist']['transfer']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['domainregnotavailable']; ?>
<?php endif; ?></td>
            <td class="textcenter"><?php if ($this->_tpl_vars['tldpricelist']['renew']): ?><?php echo $this->_tpl_vars['tldpricelist']['renew']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['domainregnotavailable']; ?>
<?php endif; ?></td>
        </tr>
<?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>

<?php if (! $this->_tpl_vars['loggedin'] && $this->_tpl_vars['currencies']): ?>
<form method="post" action="domainchecker.php">
<p align="right"><?php echo $this->_tpl_vars['LANG']['choosecurrency']; ?>
: <select name="currency" onchange="submit()"><?php $_from = $this->_tpl_vars['currencies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curr']):
?>
<option value="<?php echo $this->_tpl_vars['curr']['id']; ?>
"<?php if ($this->_tpl_vars['curr']['id'] == $this->_tpl_vars['currency']['id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['curr']['code']; ?>
</option>
<?php endforeach; endif; unset($_from); ?></select> <input type="submit" value="<?php echo $this->_tpl_vars['LANG']['go']; ?>
" /></p>
</form>
<?php endif; ?>

</div>

<?php endif; ?>

<br /><br />