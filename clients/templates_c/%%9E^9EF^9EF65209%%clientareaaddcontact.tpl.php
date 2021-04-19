<?php /* Smarty version 2.6.26, created on 2012-12-06 02:32:26
         compiled from default/clientareaaddcontact.tpl */ ?>
<script type="text/javascript" src="includes/jscript/statesdropdown.js"></script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['clientareanavcontacts'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/clientareadetailslinks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['successful']): ?>
<div class="alert alert-success">
    <p><?php echo $this->_tpl_vars['LANG']['changessavedsuccessfully']; ?>
</p>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['errormessage']): ?>
<div class="alert alert-error">
    <p class="bold"><?php echo $this->_tpl_vars['LANG']['clientareaerrors']; ?>
</p>
    <ul>
        <?php echo $this->_tpl_vars['errormessage']; ?>

    </ul>
</div>
<?php endif; ?>

<script type="text/javascript">
<?php echo '
jQuery(document).ready(function(){
    jQuery("#subaccount").click(function () {
        if (jQuery("#subaccount:checked").val()!=null) {
            jQuery("#subaccountfields").slideDown();
        } else {
            jQuery("#subaccountfields").slideUp();
        }
    });
});
'; ?>

function deleteContact() {
if (confirm("<?php echo $this->_tpl_vars['LANG']['clientareadeletecontactareyousure']; ?>
")) {
window.location='clientarea.php?action=contacts&delete=true&id=<?php echo $this->_tpl_vars['contactid']; ?>
';
}}
</script>

<form method="post" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=contacts">
<div class="alert alert-block alert-info">
<p><?php echo $this->_tpl_vars['LANG']['clientareachoosecontact']; ?>
: <select name="contactid" onchange="submit()">
    <?php $_from = $this->_tpl_vars['contacts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['contact']):
?>
        <option value="<?php echo $this->_tpl_vars['contact']['id']; ?>
"><?php echo $this->_tpl_vars['contact']['name']; ?>
 - <?php echo $this->_tpl_vars['contact']['email']; ?>
</option>
    <?php endforeach; endif; unset($_from); ?>
    <option value="new" selected="selected"><?php echo $this->_tpl_vars['LANG']['clientareanavaddcontact']; ?>
</option>
    </select> <input class="btn" type="submit" value="<?php echo $this->_tpl_vars['LANG']['go']; ?>
" /></p>
</div>
</form>

<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=addcontact">
<input type="hidden" name="submit" value="true" />

<fieldset class="control-group" style="margin:0;">

<div class="control-group">
<div class="col2half">

    <div class="control-group">
	    <label class="control-label" for="firstname"><?php echo $this->_tpl_vars['LANG']['clientareafirstname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="firstname" id="firstname" value="<?php echo $this->_tpl_vars['contactfirstname']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="lastname"><?php echo $this->_tpl_vars['LANG']['clientarealastname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="lastname" id="lastname" value="<?php echo $this->_tpl_vars['contactlastname']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="companyname"><?php echo $this->_tpl_vars['LANG']['clientareacompanyname']; ?>
</label>
		<div class="controls">
		    <input type="text" name="companyname" id="companyname" value="<?php echo $this->_tpl_vars['contactcompanyname']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="email"><?php echo $this->_tpl_vars['LANG']['clientareaemail']; ?>
</label>
		<div class="controls">
		    <input type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['contactemail']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="billingcontact"><?php echo $this->_tpl_vars['LANG']['subaccountactivate']; ?>
</label>
		<div class="controls">
		    <label class="checkbox">
            <input type="checkbox" name="subaccount" id="subaccount"<?php if ($this->_tpl_vars['subaccount']): ?> checked<?php endif; ?> /> <?php echo $this->_tpl_vars['LANG']['subaccountactivatedesc']; ?>

            </label>
		</div>
	</div>

</div>
<div class="col2half">

    <div class="control-group">
	    <label class="control-label" for="address1"><?php echo $this->_tpl_vars['LANG']['clientareaaddress1']; ?>
</label>
		<div class="controls">
		    <input type="text" name="address1" id="address1" value="<?php echo $this->_tpl_vars['contactaddress1']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="address2"><?php echo $this->_tpl_vars['LANG']['clientareaaddress2']; ?>
</label>
		<div class="controls">
		    <input type="text" name="address2" id="address2" value="<?php echo $this->_tpl_vars['contactaddress2']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="city"><?php echo $this->_tpl_vars['LANG']['clientareacity']; ?>
</label>
		<div class="controls">
		    <input type="text" name="city" id="city" value="<?php echo $this->_tpl_vars['contactcity']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="state"><?php echo $this->_tpl_vars['LANG']['clientareastate']; ?>
</label>
		<div class="controls">
		    <input type="text" name="state" id="state" value="<?php echo $this->_tpl_vars['contactstate']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="postcode"><?php echo $this->_tpl_vars['LANG']['clientareapostcode']; ?>
</label>
		<div class="controls">
		    <input type="text" name="postcode" id="postcode" value="<?php echo $this->_tpl_vars['contactpostcode']; ?>
" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="country"><?php echo $this->_tpl_vars['LANG']['clientareacountry']; ?>
</label>
		<div class="controls">
		    <?php echo $this->_tpl_vars['countriesdropdown']; ?>

		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="phonenumber"><?php echo $this->_tpl_vars['LANG']['clientareaphonenumber']; ?>
</label>
		<div class="controls">
		    <input type="text" name="phonenumber" id="phonenumber" value="<?php echo $this->_tpl_vars['contactphonenumber']; ?>
" />
		</div>
	</div>

</div>
</div>

</fieldset>

<div id="subaccountfields" class="well<?php if (! $this->_tpl_vars['subaccount']): ?> hide<?php endif; ?>">

<fieldset>

    <div class="control-group">
	    <label class="control-label" for="password"><?php echo $this->_tpl_vars['LANG']['clientareapassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="password" id="password" />
		</div>
	</div>

    <div class="control-group">
	    <label class="control-label" for="password2"><?php echo $this->_tpl_vars['LANG']['clientareaconfirmpassword']; ?>
</label>
		<div class="controls">
		    <input type="password" name="password2" id="password2" />
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

    <div class="control-group">
	    <label class="full control-label"><?php echo $this->_tpl_vars['LANG']['subaccountpermissions']; ?>
</label>
		<div class="controls">
            <ul class="inputs-list">
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" value="profile"<?php if (in_array ( 'profile' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsprofile']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permcontacts" value="contacts"<?php if (in_array ( 'contacts' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermscontacts']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permproducts" value="products"<?php if (in_array ( 'products' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsproducts']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permmanageproducts" value="manageproducts"<?php if (in_array ( 'manageproducts' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsmanageproducts']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permdomains" value="domains"<?php if (in_array ( 'domains' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsdomains']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permmanagedomains" value="managedomains"<?php if (in_array ( 'managedomains' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsmanagedomains']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="perminvoices" value="invoices"<?php if (in_array ( 'invoices' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsinvoices']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permtickets" value="tickets"<?php if (in_array ( 'tickets' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermstickets']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permaffiliates" value="affiliates"<?php if (in_array ( 'affiliates' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsaffiliates']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permemails" value="emails"<?php if (in_array ( 'emails' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <span><?php echo $this->_tpl_vars['LANG']['subaccountpermsemails']; ?>
</span>
                    </label>
                </li>
                <li class="col2half">
                    <label class="checkbox">
                        <input type="checkbox" name="permissions[]" id="permorders" value="orders"<?php if (in_array ( 'orders' , $this->_tpl_vars['permissions'] )): ?> checked<?php endif; ?> />
                        <?php echo $this->_tpl_vars['LANG']['subaccountpermsorders']; ?>

                    </label>
                </li>
            </ul>
		</div>
	</div>

</fieldset>

</div>

<fieldset>

    <div class="control-group">
	    <label class="control-label"><?php echo $this->_tpl_vars['LANG']['clientareacontactsemails']; ?>
</label>
		<div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="generalemails" id="generalemails" value="1"<?php if ($this->_tpl_vars['generalemails']): ?> checked<?php endif; ?> />
                <?php echo $this->_tpl_vars['LANG']['clientareacontactsemailsgeneral']; ?>

            </label>
            <label class="checkbox">
                <input type="checkbox" name="productemails" id="productemails" value="1"<?php if ($this->_tpl_vars['productemails']): ?> checked<?php endif; ?> />
                <?php echo $this->_tpl_vars['LANG']['clientareacontactsemailsproduct']; ?>

            </label>
            <label class="checkbox">
                <input type="checkbox" name="domainemails" id="domainemails" value="1"<?php if ($this->_tpl_vars['domainemails']): ?> checked<?php endif; ?> />
                <?php echo $this->_tpl_vars['LANG']['clientareacontactsemailsdomain']; ?>

            </label>
            <label class="checkbox">
                <input type="checkbox" name="invoiceemails" id="invoiceemails" value="1"<?php if ($this->_tpl_vars['invoiceemails']): ?> checked<?php endif; ?> />
                <?php echo $this->_tpl_vars['LANG']['clientareacontactsemailsinvoice']; ?>

            </label>
            <label class="checkbox">
                <input type="checkbox" name="supportemails" id="supportemails" value="1"<?php if ($this->_tpl_vars['supportemails']): ?> checked<?php endif; ?> />
                <?php echo $this->_tpl_vars['LANG']['clientareacontactsemailssupport']; ?>

            </label>
		</div>
	</div>

</fieldset>

  <div class="form-actions">
    <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->_tpl_vars['LANG']['clientareasavechanges']; ?>
" />
    <input class="btn" type="reset" value="<?php echo $this->_tpl_vars['LANG']['cancel']; ?>
" />
  </div>

</form>