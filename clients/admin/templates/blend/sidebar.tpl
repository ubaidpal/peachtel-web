{if $sidebar eq "home"}

<span class="header"><img src="images/icons/linktracking.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.global.shortcuts}</span>
<ul class="menu">
    <li><a href="clientsadd.php"><img src="images/icons/clientsadd.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.clients.addnew}</a></li>
    <li><a href="ordersadd.php"><img src="images/icons/ordersadd.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.orders.addnew}</a></li>
    <li><a href="quotes.php?action=manage"><img src="images/icons/quotes.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.quotes.createnew}</a></li>
    <li><a href="todolist.php"><img src="images/icons/todolist.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.utilities.todolistcreatenew}</a></li>
    <li><a href="supporttickets.php?action=open"><img src="images/icons/tickets.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.support.opennewticket}</a></li>
    <li><a href="whois.php"><img src="images/icons/domains.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.utilities.whois}</a></li>
    <li><a href="#" onClick="showDialog('geninvoices');return false"><img src="images/icons/invoices.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.invoices.geninvoices}</a></li>
    <li><a href="#" onClick="showDialog('cccapture');return false"><img src="images/icons/offlinecc.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.invoices.attemptcccaptures}</a></li>
</ul>

<span class="header"><img src="images/icons/home.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.global.systeminfo}</span>
<div class="smallfont">{$_ADMINLANG.license.regto}: {$licenseinfo.registeredname}<br />{$_ADMINLANG.license.type}: {$licenseinfo.productname}<br />{$_ADMINLANG.license.expires}: {$licenseinfo.expires}<br />{$_ADMINLANG.global.version}: {$licenseinfo.currentversion}{if $licenseinfo.currentversion neq $licenseinfo.latestversion}<br /><span class="textred"><b>{$_ADMINLANG.license.updateavailable}</b></span>{/if}<br /><br /></div>

{elseif $sidebar eq "clients"}

<span class="header"><img src="images/icons/clients.png" class="absmiddle" alt="Clients" width="16" height="16" /> {$_ADMINLANG.clients.title}</span>
<ul class="menu">
    <li><a href="clients.php">{$_ADMINLANG.clients.viewsearch}</a></li>
    <li><a href="clientsadd.php">{$_ADMINLANG.clients.addnew}</a></li>
</ul>

<span class="header"><img src="images/icons/products.png" alt="Products/Services" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.services.title}</span>
<ul class="menu">
    <li><a href="clientshostinglist.php">{$_ADMINLANG.services.listall}</a></li>
    <li><a href="clientshostinglist.php?type=hostingaccount">- {$_ADMINLANG.services.listhosting}</a></li>
    <li><a href="clientshostinglist.php?type=reselleraccount">- {$_ADMINLANG.services.listreseller}</a></li>
    <li><a href="clientshostinglist.php?type=server">- {$_ADMINLANG.services.listservers}</a></li>
    <li><a href="clientshostinglist.php?type=other">- {$_ADMINLANG.services.listother}</a></li>
    <li><a href="clientsaddonslist.php">{$_ADMINLANG.services.listaddons}</a></li>
    <li><a href="clientsdomainlist.php">{$_ADMINLANG.services.listdomains}</a></li>
    <li><a href="cancelrequests.php">{$_ADMINLANG.clients.cancelrequests}</a></li>
</ul>

<span class="header"><img src="images/icons/affiliates.png" alt="Affiliates" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.affiliates.title}</span>
<ul class="menu">
    <li><a href="affiliates.php">{$_ADMINLANG.affiliates.manage}</a></li>
</ul>

{elseif $sidebar eq "orders"}

<span class="header"><img src="images/icons/orders.png" alt="Affiliates" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.orders.title}</span>
<ul class="menu">
    <li><a href="orders.php">{$_ADMINLANG.orders.listall}</a></li>
    <li><a href="orders.php?status=Pending">- {$_ADMINLANG.orders.listpending}</a></li>
    <li><a href="orders.php?status=Active">- {$_ADMINLANG.orders.listactive}</a></li>
    <li><a href="orders.php?status=Fraud">- {$_ADMINLANG.orders.listfraud}</a></li>
    <li><a href="orders.php?status=Cancelled">- {$_ADMINLANG.orders.listcancelled}</a></li>
    <li><a href="ordersadd.php">{$_ADMINLANG.orders.addnew}</a></li>
</ul>

{elseif $sidebar eq "billing"}

<span class="header"><img src="images/icons/transactions.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.billing.title}</span>
<ul class="menu">
    <li><a href="transactions.php">{$_ADMINLANG.billing.transactionslist}</a></li>
    <li><a href="gatewaylog.php">{$_ADMINLANG.billing.gatewaylog}</a></li>
    <li><a href="offlineccprocessing.php">{$_ADMINLANG.billing.offlinecc}</a></li>
</ul>

<span class="header"><img src="images/icons/invoices.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.invoices.title}</span>
<ul class="menu">
    <li><a href="invoices.php">{$_ADMINLANG.invoices.listall}</a></li>
    <li><a href="invoices.php?status=Paid">- {$_ADMINLANG.status.paid}</a></li>
    <li><a href="invoices.php?status=Unpaid">- {$_ADMINLANG.status.unpaid}</a></li>
    <li><a href="invoices.php?status=Overdue">- {$_ADMINLANG.status.overdue}</a></li>
    <li><a href="invoices.php?status=Cancelled">- {$_ADMINLANG.status.cancelled}</a></li>
    <li><a href="invoices.php?status=Refunded">- {$_ADMINLANG.status.refunded}</a></li>
    <li><a href="invoices.php?status=Collections">- {$_ADMINLANG.status.collections}</a></li>
</ul>

<span class="header"><img src="images/icons/billableitems.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.billableitems.title}</span>
<ul class="menu">
    <li><a href="billableitems.php">{$_ADMINLANG.billableitems.listall}</a></li>
    <li><a href="billableitems.php?status=Uninvoiced">- {$_ADMINLANG.billableitems.uninvoiced}</a></li>
    <li><a href="billableitems.php?status=Recurring">- {$_ADMINLANG.billableitems.recurring}</a></li>
    <li><a href="billableitems.php?action=manage">{$_ADMINLANG.billableitems.addnew}</a></li>
</ul>

<span class="header"><img src="images/icons/quotes.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.quotes.title}</span>
<ul class="menu">
    <li><a href="quotes.php">{$_ADMINLANG.quotes.listall}</a></li>
    <li><a href="quotes.php?validity=Valid">- {$_ADMINLANG.status.valid}</a></li>
    <li><a href="quotes.php?validity=Expired">- {$_ADMINLANG.status.expired}</a></li>
    <li><a href="quotes.php?action=manage">{$_ADMINLANG.quotes.createnew}</a></li>
</ul>

{elseif $sidebar eq "support"}

<span class="header"><img src="images/icons/support.png" alt="Support Center" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.support.title}</span>
<ul class="menu">
    <li><a href="supportannouncements.php">{$_ADMINLANG.support.announcements}</a></li>
    <li><a href="supportdownloads.php">{$_ADMINLANG.support.downloads}</a></li>
    <li><a href="supportkb.php">{$_ADMINLANG.support.knowledgebase}</a></li>
    <li><a href="supporttickets.php?action=open">{$_ADMINLANG.support.opennewticket}</a></li>
    <li><a href="supportticketpredefinedreplies.php">{$_ADMINLANG.support.predefreplies}</a></li>
</ul>

<span class="header"><img src="images/icons/tickets.png" alt="Filter Tickets" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.support.filtertickets}</span>

<form method="post" action="supporttickets.php">
<span class="header">{$_ADMINLANG.fields.status}</span>
<select name="view">
    <option value="any">- Any -</option>
    <option value=""{if $ticketstatusfilter eq ""} selected{/if}>{$_ADMINLANG.support.awaitingreply} ({$ticketsawaitingreply})</option>
    <option value="flagged"{if $ticketstatusfilter eq "flagged"} selected{/if}>{$_ADMINLANG.support.flagged} ({$ticketsflagged})</option>
    <option value="active"{if $ticketstatusfilter eq "active"} selected{/if}>{$_ADMINLANG.support.allactive} ({$ticketsallactive})</option>
{foreach from=$ticketstatuses item=status}
    <option value="{$status.title}"{if $status.title eq $ticketstatusfilter} selected{/if}>{$status.title} ({$status.count})</option>
{/foreach}
</select>
<span class="header">{$_ADMINLANG.support.department}</span>
<select name="deptid">
    <option value="">- Any -</option>
{foreach from=$ticketdepts item=dept}
    <option value="{$dept.id}"{if $dept.id eq $ticketdeptfilter} selected{/if}>{$dept.name}</option>
{/foreach}
</select>
<span class="header">{$_ADMINLANG.support.subjectmessage}</span>
<input type="text" name="subject" value="{$ticketsubjectfilter}" />
<span class="header">{$_ADMINLANG.fields.email}</span>
<input type="text" name="email" value="{$ticketemailfilter}" />
<input type="submit" value="Filter" />
</form>

<br />

<span class="header"><img src="images/icons/networkissues.png" alt="Network Issues" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.networkissues.title}</span>
<ul class="menu">
    <li><a href="networkissues.php">- {$_ADMINLANG.networkissues.open}</a></li>
    <li><a href="networkissues.php?view=scheduled">- {$_ADMINLANG.networkissues.scheduled}</a></li>
    <li><a href="networkissues.php?view=resolved">- {$_ADMINLANG.networkissues.resolved}</a></li>
    <li><a href="networkissues.php?action=manage">{$_ADMINLANG.networkissues.addnew}</a></li>
</ul>

{elseif $sidebar eq "reports"}

<span class="header"><img src="images/icons/reports.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.reports.title}</span>
<ul class="menu">
    {foreach from=$text_reports key=filename item=reporttitle}
    <li><a href="reports.php?report={$filename}">{$reporttitle}</a></li>
    {/foreach}
</ul>

<span class="header"><img src="images/icons/csvexports.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.reports.exports}</span>
<ul class="menu">
    <li><a href="csvdownload.php?type=clients">{$_ADMINLANG.clients.title}</a></li>
    <li><a href="csvdownload.php?type=products">{$_ADMINLANG.services.title}</a></li>
    <li><a href="csvdownload.php?type=domains">{$_ADMINLANG.domains.title}</a></li>
    <li><a href="reports.php?report=transactions">{$_ADMINLANG.billing.transactionslist}</a></li>
    <li><a href="reports.php?report=pdfbatch">{$_ADMINLANG.reports.pdfbatch}</a></li>
</ul>

{elseif $sidebar eq "browser"}

<span class="header"><img src="images/icons/browser.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.browser.bookmarks}</span>
<ul class="menu">
    <li><a href="http://www.whmcs.com/" target="brwsrwnd">WHMCS Homepage</a></li>
    <li><a href="https://www.whmcs.com/clients/" target="brwsrwnd">WHMCS Client Area</a></li>
    {foreach from=$browserlinks item=link}
    <li><a href="{$link.url}" target="brwsrwnd">{$link.name} <img src="images/delete.gif" width="10" border="0" onclick="doDelete('{$link.id}')"></a></li>
    {/foreach}
</ul>

<form method="post" action="browser.php?action=add">
<span class="header"><img src="images/icons/browseradd.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.browser.addnew}</span>
<ul class="menu">
    <li>{$_ADMINLANG.browser.sitename}:<br><input type="text" name="sitename" size="25" style="font-size:9px;"><br>{$_ADMINLANG.browser.url}:<br><input type="text" name="siteurl" size="25" value="http://" style="font-size:9px;"><br><input type="submit" value="{$_ADMINLANG.browser.add}" style="font-size:9px;"></li>
</ul>
</form>

{elseif $sidebar eq "utilities"}

<span class="header"><img src="images/icons/utilities.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.utilities.title}</span>
<ul class="menu">
    <li><a href="messagecenter.php">Message Center</a></li>
    <li><a href="utilitieslinktracking.php">{$_ADMINLANG.utilities.linktracking}</a></li>
    <li><a href="browser.php">{$_ADMINLANG.utilities.browser}</a></li>
    <li><a href="calendar.php">{$_ADMINLANG.utilities.calendar}</a></li>
    <li><a href="todolist.php">{$_ADMINLANG.utilities.todolist}</a></li>
    <li><a href="whois.php">{$_ADMINLANG.utilities.whois}</a></li>
    <li><a href="utilitiesresolvercheck.php">{$_ADMINLANG.utilities.domainresolver}</a></li>
    <li><a href="systemintegrationcode.php">{$_ADMINLANG.utilities.integrationcode}</a></li>
    <li><a href="whmimport.php">{$_ADMINLANG.utilities.cpanelimport}</a></li>
    <li><a href="systemdatabase.php">{$_ADMINLANG.utilities.dbstatus}</a></li>
    <li><a href="systemcleanup.php">{$_ADMINLANG.utilities.syscleanup}</a></li>
    <li><a href="systemphpinfo.php">{$_ADMINLANG.utilities.phpinfo}</a></li>
</ul>

<span class="header"><img src="images/icons/logs.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.utilities.logs}</span>
<ul class="menu">
    <li><a href="systemactivitylog.php">{$_ADMINLANG.utilities.activitylog}</a></li>
    <li><a href="systemadminlog.php">{$_ADMINLANG.utilities.adminlog}</a></li>
    <li><a href="systemmodulelog.php">{$_ADMINLANG.utilities.modulelog}</a></li>
    <li><a href="systememaillog.php">{$_ADMINLANG.utilities.emaillog}</a></li>
    <li><a href="systemmailimportlog.php">{$_ADMINLANG.utilities.ticketmaillog}</a></li>
    <li><a href="systemwhoislog.php">{$_ADMINLANG.utilities.whoislog}</a></li>
</ul>

{elseif $sidebar eq "addonmodules"}

{$addon_module_sidebar}

<span class="header"><img src="images/icons/addonmodules.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.utilities.addonmodules}</span>
<ul class="menu">
    {foreach from=$addon_modules key=filename item=addontitle}
    <li><a href="addonmodules.php?module={$filename}">{$addontitle}</a></li>
    {/foreach}
</ul>

{elseif $sidebar eq "config"}

<span class="header"><img src="images/icons/config.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.setup.config}</span>
<ul class="menu">
    <li><a href="configgeneral.php">{$_ADMINLANG.setup.general}</a></li>
    <li><a href="configauto.php">{$_ADMINLANG.setup.automation}</a></li>
    <li><a href="configemailtemplates.php">{$_ADMINLANG.setup.emailtpls}</a></li>
    <li><a href="configfraud.php">{$_ADMINLANG.setup.fraud}</a></li>
    <li><a href="configclientgroups.php">{$_ADMINLANG.setup.clientgroups}</a></li>
    <li><a href="configcustomfields.php">{$_ADMINLANG.setup.customclientfields}</a></li>
    <li><a href="configadmins.php">{$_ADMINLANG.setup.admins}</a></li>
    <li><a href="configadminroles.php">{$_ADMINLANG.setup.adminroles}</a></li>
    <li><a href="configaddonmods.php">{$_ADMINLANG.setup.addonmodules}</a></li>
</ul>

<span class="header"><img src="images/icons/income.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.setup.payments}</span>
<ul class="menu">
    <li><a href="configcurrencies.php">{$_ADMINLANG.setup.currencies}</a></li>
    <li><a href="configgateways.php">{$_ADMINLANG.setup.gateways}</a></li>
    <li><a href="configtax.php">{$_ADMINLANG.setup.tax}</a></li>
    <li><a href="configpromotions.php">{$_ADMINLANG.setup.promos}</a></li>
</ul>

<span class="header"><img src="images/icons/products.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.setup.products}</span>
<ul class="menu">
    <li><a href="configproducts.php">{$_ADMINLANG.setup.products}</a></li>
    <li><a href="configproductoptions.php">{$_ADMINLANG.setup.configoptions}</a></li>
    <li><a href="configaddons.php">{$_ADMINLANG.setup.addons}</a></li>
    <li><a href="configbundles.php">{$_ADMINLANG.setup.bundles}</a></li>
    <li><a href="configdomains.php">{$_ADMINLANG.setup.domainpricing}</a></li>
    <li><a href="configregistrars.php">{$_ADMINLANG.setup.registrars}</a></li>
    <li><a href="configservers.php">{$_ADMINLANG.setup.servers}</a></li>
</ul>

<span class="header"><img src="images/icons/support.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.support.title}</span>
<ul class="menu">
    <li><a href="configticketdepartments.php">{$_ADMINLANG.setup.supportdepartments}</a></li>
    <li><a href="configticketstatuses.php">{$_ADMINLANG.setup.ticketstatuses}</a></li>
    <li><a href="configticketescalations.php">{$_ADMINLANG.setup.escalationrules}</a></li>
    <li><a href="configticketspamcontrol.php">{$_ADMINLANG.setup.spam}</a></li>
</ul>

<span class="header"><img src="images/icons/configother.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.setup.other}</span>
<ul class="menu">
    <li><a href="configorderstatuses.php">{$_ADMINLANG.setup.orderstatuses}</a></li>
    <li><a href="configsecurityqs.php">{$_ADMINLANG.setup.securityqs}</a></li>
    <li><a href="configbannedips.php">{$_ADMINLANG.setup.bannedips}</a></li>
    <li><a href="configbannedemails.php">{$_ADMINLANG.setup.bannedemails}</a></li>
    <li><a href="configbackups.php">{$_ADMINLANG.setup.backups}</a></li>
</ul>

{/if}

<span class="header"><img src="images/icons/search.png" alt="" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.global.advancedsearch}</span>
<div class="smallfont">

<form method="get" action="search.php">
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients </option>
      <option value="orders">Orders </option>
      <option value="services">Services </opt>
      <option value="domains">Domains </option>
      <option value="invoices">Invoices </option>
      <option value="tickets">Tickets </option>
    </select>
    <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select>
    <input type="text" name="q" style="width:85%;" />
    <input type="submit" value="{$_ADMINLANG.global.search}" class="button" />
  </form>

</div>

<br />

<span class="header"><img src="images/icons/admins.png" alt="" width="16" height="16" class="absmiddle" /> {$_ADMINLANG.global.staffonline}</span>
<div class="smallfont">{$adminsonline}</div>

<div class="controls"><a href="#" onclick="sidebarClose();return false">&laquo; Minimise Sidebar</a></div>