<script type="text/javascript" src="includes/jscript/pwstrength.js"></script>

<p class="heading2">{$LANG.clientareaproductdetails}</p>

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="150" class="fieldarea">{$LANG.clientareahostingregdate}:</td><td>{$regdate}</td></tr>
<tr><td class="fieldarea">{$LANG.orderproduct}:</td><td>{$groupname} - {$product}</td></tr>
{if $domain}<tr><td class="fieldarea">{$LANG.clientareahostingdomain}:</td><td><a href="http://{$domain}" target="_blank">{$domain}</a></td></tr>{/if}
{if $dedicatedip}<tr><td class="fieldarea">{$LANG.domainregisternsip}:</td><td>{$dedicatedip}</td></tr>{/if}
{foreach from=$configurableoptions item=configoption}
<tr><td class="fieldarea">{$configoption.optionname}:</td><td>{if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}</td></tr>
{/foreach}
{foreach from=$productcustomfields item=customfield}
<tr><td class="fieldarea">{$customfield.name}:</td><td>{$customfield.value}</td></tr>
{/foreach}
{if $lastupdate}
<tr><td class="fieldarea">{$LANG.clientareadiskusage}:</td><td>{$diskusage}MB / {$disklimit}MB (<strong>{$diskpercent}</strong>)</td></tr>
<tr><td class="fieldarea">{$LANG.clientareabwusage}:</td><td>{$bwusage}MB / {$bwlimit}MB (<strong>{$bwpercent}</strong>)</td></tr>
{/if}
<tr><td class="fieldarea">{$LANG.orderpaymentmethod}:</td><td>{$paymentmethod}</td></tr>
<tr><td class="fieldarea">{$LANG.firstpaymentamount}:</td><td>{$firstpaymentamount}</td></tr>
<tr><td class="fieldarea">{$LANG.recurringamount}:</td><td>{$recurringamount}</td></tr>
<tr><td class="fieldarea">{$LANG.clientareahostingnextduedate}:</td><td>{$nextduedate}</td></tr>
<tr><td class="fieldarea">{$LANG.orderbillingcycle}:</td><td>{$billingcycle}</td></tr>
<tr><td class="fieldarea">{$LANG.clientareastatus}:</td><td>{$status}</td></tr>
{if $suspendreason}<tr><td class="fieldarea">{$LANG.suspendreason}:</td><td>{$suspendreason}</td></tr>{/if}
</table>
</td></tr></table>

<br />

<div align="center">{$moduleclientarea}</div>

{if $username}

{if $modulechangepassword}
<form method="post" action="{$smarty.server.PHP_SELF}?action=productdetails">
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="modulechangepassword" value="true" />
{/if}

<p><strong>&nbsp;&raquo; {$LANG.serverlogindetails}</strong></p>

{if $modulechangepwresult eq "success"}
<div class="successbox">{$LANG.serverchangepasswordsuccessful}</div><br />
{elseif $modulechangepwresult eq "error"}
<div class="errorbox">{$modulechangepasswordmessage}</div><br />
{/if}

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="150" class="fieldarea">{$LANG.serverusername}/{$LANG.serverpassword}:</td><td>{$username}{if $password} / {$password}{/if}</td></tr>
{if $modulechangepassword}<tr><td width="150" class="fieldarea">{$LANG.serverchangepasswordenter}:</td><td width="175"><input type="password" name="newpassword1" id="newpw" size="25" /></td><td><script type="text/javascript">showStrengthBar();</script></td></tr>
<tr><td class="fieldarea">{$LANG.serverchangepasswordconfirm}:</td><td><input type="password" name="newpassword2" size="25" /></td></tr>{/if}
</table>
</td></tr></table>

{if $modulechangepassword}
<p align="center"><input type="submit" value="{$LANG.serverchangepasswordupdate}" class="buttongo" /></p>
</form>
{/if}

{/if}

{if $downloads}

<p><strong>&nbsp;&raquo; {$LANG.downloadstitle}</strong></p>

{foreach key=num item=download from=$downloads}
<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="150" class="fieldarea">{$LANG.downloadname}:</td><td>{$download.type} <a href="{$download.link}">{$download.title}</a></td></tr>
<tr><td class="fieldarea">{$LANG.downloaddescription}:</td><td>{$download.description}</td></tr>
</table>
</td></tr></table><br />
{/foreach}

{/if}

<p><strong>&nbsp;&raquo; {$LANG.clientareaaccountaddons}</strong>{if $addonsavailable} - <a href="cart.php?gid=addons&pid={$id}">{$LANG.orderavailableaddons}</a>{/if}</p>

<table class="clientareatable" cellspacing="1" align="center">
<tr class="clientareatableheading"><td>{$LANG.clientareaaddon}</td><td>{$LANG.clientareaaddonpricing}</td><td>{$LANG.clientareahostingnextduedate}</td></tr>
{foreach key=num item=addon from=$addons}
<tr class="{$addon.class}"><td>{$addon.name}</td><td align="center">{$addon.pricing}</td><td align="center">{$addon.nextduedate}</td></tr>
{foreachelse}
<tr class="clientareatableactive"><td colspan="3">{$LANG.clientareanoaddons}</td></tr>
{/foreach}
</table>

<br />

<table align="center"><tr><td width="10" align="right"><table style="width:10px;height:10px;" cellspacing="1" class="clientareatable"><tr class="clientareatableactive"><td></td></tr></table></td><td>{$LANG.clientareaactive}</td><td width="10" align="right"><table style="width:10px;height:10px;" cellspacing="1" class="clientareatable"><tr class="clientareatablepending"><td></td></tr></table></td><td>{$LANG.clientareapending}</td><td width="10" align="right"><table style="width:10px;height:10px;" cellspacing="1" class="clientareatable"><tr class="clientareatablesuspended"><td></td></tr></table></td><td>{$LANG.clientareasuspended}</td><td width="10" align="right"><table style="width:10px;height:10px;" cellspacing="1" class="clientareatable"><tr class="clientareatableterminated"><td></td></tr></table></td><td>{$LANG.clientareaterminated}</td></tr></table>

<br />

<table align="center">
<tr>
<td><input type="button" value="{$LANG.clientareabacklink}" onclick="window.location='clientarea.php?action=products'" class="button" /></td>
{if $packagesupgrade}<td>
<form method="post" action="upgrade.php">
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="type" value="package" />
<p><input type="submit" value="{$LANG.upgradedowngradepackage}" class="buttongo" /></p>
</form>
</td>{/if}
{if $configoptionsupgrade}<td>
<form method="post" action="upgrade.php">
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="type" value="configoptions" />
<p><input type="submit" value="{$LANG.upgradedowngradeconfigoptions}" class="buttongo" /></p>
</form>
</td>{/if}
{if $showcancelbutton && ($status eq $LANG.clientareaactive OR $status eq $LANG.clientareasuspended)}<td><input type="button" value="{$LANG.clientareacancelrequestbutton}" onclick="window.location='clientarea.php?action=cancel&amp;id={$id}'" class="buttonwarn" /></td>{/if}
</tr>
</table>