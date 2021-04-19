<?php /* Smarty version 2.6.26, created on 2012-12-10 06:05:08
         compiled from blend/viewticket.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'blend/viewticket.tpl', 411, false),array('modifier', 'escape', 'blend/viewticket.tpl', 474, false),)), $this); ?>
<script language="javascript">
var ticketid = '<?php echo $this->_tpl_vars['ticketid']; ?>
';
var userid = '<?php echo $this->_tpl_vars['userid']; ?>
';
var pagefilename = '<?php echo $_SERVER['PHP_SELF']; ?>
';
var ticketcontent = "";
var selectedTab;
<?php echo '
function doDeleteReply(id) {
    if (confirm("'; ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['delreplysure']; ?>
<?php echo '")) {
        window.location=pagefilename+\'?action=viewticket&id=\'+ticketid+\'&sub=del&idsd=\'+id;
    }
}
function doDeleteTicket() {
    if (confirm("'; ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['delticketsure']; ?>
<?php echo '")) {
        window.location=pagefilename+\'?sub=deleteticket&id=\'+ticketid;
    }
}
function doDeleteNote(id) {
    if (confirm("'; ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['delnotesure']; ?>
<?php echo '")) {
        window.location=pagefilename+\'?action=viewticket&id=\'+ticketid+\'&sub=delnote&idsd=\'+id;
    }
}
function editTicket(id) {
    $(".editbtns"+id).toggle();
    $("#content"+id+" div").hide();
    $("#content"+id+" div").after(\'<textarea rows="15" style="width:99%" id="ticketedit\'+id+\'">Loading...</textarea>\');
    $.post("supporttickets.php", { action: "getmsg", ref: id },
        function(data){
            $("#ticketedit"+id).val(data);
        });
}
function editTicketCancel(id) {
    $("#ticketedit"+id).hide();
    $("#content"+id+" div").show();
    $(".editbtns"+id).toggle();
}
function editTicketSave(id) {
    $("#ticketedit"+id).hide();
    $("#content"+id+" div").show();
    $(".editbtns"+id).toggle();
    $.post("supporttickets.php", { action: "updatereply", ref: id, text: $("#ticketedit"+id).val() },
        function(data){
            $("#content"+id+" div").html(data);
        });
}
function quoteTicket(id,ids) {
    $(".tab").removeClass("tabselected");
    $("#tab0").addClass("tabselected");
    $(".tabbox").hide();
    $("#tab0box").show();
    $.post("supporttickets.php", { action: "getquotedtext", id: id, ids: ids },
    function(data){
        $("#replymessage").val(data+"\\n\\n"+$("#replymessage").val());
    });
    return false;
}
function selectpredefcat(catid) {
    $.post("supporttickets.php", { action: "loadpredefinedreplies", cat: catid },
    function(data){
        $("#prerepliescontent").html(data);
    });
}
function selectpredefreply(artid) {
    $.post("supporttickets.php", { action: "getpredefinedreply", id: artid },
    function(data){
        $("#replymessage").addToReply(data);
    });
    $("#prerepliescontainer").slideToggle();
}
function searchselectclient(userid) {
    $("#clientsearchval").val(userid);
	$("#ticketclientsearchresults").slideUp("slow");
    $("#clientsearchcancel").fadeOut();
}
function loadTab(target,type,offset) {
    $.post("supporttickets.php", { action: "get"+type, id: ticketid, userid: userid, target: target, offset: offset },
    function(data){
        $("#tab"+target+"box #tab_content").html(data);
    });
}
function expandRelServices() {
    $("#relatedservicesexpand").html(\'<img src="images/loading.gif" align="top" /> '; ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['global']['loading']; ?>
<?php echo '\');
    $.post("supporttickets.php", { action: "getallservices", id: ticketid, userid: userid },
    function(data){
        $("#relatedservicestbl").append(data);
        $("#relatedservicesexpand").fadeOut();
    });
}

$(document).ready(function(){

$(".tabbox").css("display","none");
$(".tab").click(function(){
    var elid = $(this).attr("id");
    if (elid != selectedTab) {
        $(".tab").removeClass("tabselected");
        $("#"+elid).addClass("tabselected");
        $(".tabbox").slideUp();
        $("#"+elid+"box").slideDown();
        $("#tab").val(elid.substr(3));
        selectedTab = elid;
    }
});
selectedTab = "tab0";
$("#tab0").addClass("tabselected");
$("#tab0box").css("display","");
$("#replymessage").focus(function () {
	$.post("supporttickets.php", { action: "makingreply", id: ticketid },
	function(data){
        $("#replyingadmin").html(data);
    });
    return false;
});
$("#replyfrm").submit(function () {
	var status = $("#ticketstatus").val();
	var response = $.ajax({
		type: "POST",
		url: "supporttickets.php?action=checkstatus",
		data: "id="+ticketid+"&ticketstatus="+status,
		async: false
	}).responseText;
	if (response == "true") {
    	return true;
	} else {
		if (confirm("'; ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['statuschanged']; ?>
\n\n<?php echo $this->_tpl_vars['_ADMINLANG']['support']['stillsubmit']; ?>
<?php echo '")) {
	        return true;
	    }
	    return false;
	}
});

$(window).unload( function () {
    $.post("supporttickets.php", { action: "endreply", id: ticketid });
});
$("#insertpredef").click(function () {
    $("#prerepliescontainer").slideToggle();
    return false;
});
$("#addfileupload").click(function () {
    $("#fileuploads").append("<input type=\\"file\\" name=\\"attachments[]\\" size=\\"85\\"><br />");
    return false;
});
$("#ticketstatus").change(function () {
    $.post("supporttickets.php", { action: "changestatus", id: ticketid, status: this.options[this.selectedIndex].text });
});
$("#predefq").keyup(function () {
    var intellisearchlength = $("#predefq").val().length;
    if (intellisearchlength>2) {
    $.post("supporttickets.php", { action: "loadpredefinedreplies", predefq: $("#predefq").val() },
        function(data){
            $("#prerepliescontent").html(data);
        });
    }
});

$("#clientsearchval").keyup(function () {
	var ticketuseridsearchlength = $("#clientsearchval").val().length;
	if (ticketuseridsearchlength>2) {
	$.post("search.php", { ticketclientsearch: 1, value: $("#clientsearchval").val() },
	    function(data){
            if (data) {
                $("#ticketclientsearchresults").html(data);
                $("#ticketclientsearchresults").slideDown("slow");
                $("#clientsearchcancel").fadeIn();
            }
        });
	}
});
$("#clientsearchcancel").click(function () {
    $("#ticketclientsearchresults").slideUp("slow");
    $("#clientsearchcancel").fadeOut();
});

});
'; ?>

</script>

<?php echo $this->_tpl_vars['infobox']; ?>


<div id="replyingadmin">
<?php if ($this->_tpl_vars['replyingadmin']): ?><div class="errorbox"><?php echo $this->_tpl_vars['replyingadmin']['name']; ?>
 <?php echo $this->_tpl_vars['_ADMINLANG']['support']['viewedandstarted']; ?>
 @ <?php echo $this->_tpl_vars['replyingadmin']['time']; ?>
</div><?php endif; ?>
</div>

<h2>#<?php echo $this->_tpl_vars['tid']; ?>
 - <?php echo $this->_tpl_vars['subject']; ?>
 <select name="ticketstatus" id="ticketstatus" style="font-size:18px;">
<?php $_from = $this->_tpl_vars['statuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['statusitem']):
?>
<option<?php if ($this->_tpl_vars['statusitem']['title'] == $this->_tpl_vars['status']): ?> selected<?php endif; ?> style="color:<?php echo $this->_tpl_vars['statusitem']['color']; ?>
"><?php echo $this->_tpl_vars['statusitem']['title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select></h2>

<p><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['client']; ?>
: <?php if ($this->_tpl_vars['userid']): ?><a href="clientssummary.php?userid=<?php echo $this->_tpl_vars['userid']; ?>
"<?php if ($this->_tpl_vars['clientgroupcolour']): ?> style="background-color:<?php echo $this->_tpl_vars['clientgroupcolour']; ?>
"<?php endif; ?> target="_blank"><?php echo $this->_tpl_vars['clientname']; ?>
</a><?php if ($this->_tpl_vars['contactid']): ?> (<a href="clientscontacts.php?userid=<?php echo $this->_tpl_vars['userid']; ?>
&contactid=<?php echo $this->_tpl_vars['contactid']; ?>
"<?php if ($this->_tpl_vars['clientgroupcolour']): ?> style="background-color:<?php echo $this->_tpl_vars['clientgroupcolour']; ?>
"<?php endif; ?> target="_blank"><?php echo $this->_tpl_vars['contactname']; ?>
</a>)<?php endif; ?><?php else: ?><?php echo $this->_tpl_vars['_ADMINLANG']['support']['notregclient']; ?>
<?php endif; ?> | <?php echo $this->_tpl_vars['_ADMINLANG']['support']['lastreply']; ?>
: <?php echo $this->_tpl_vars['lastreply']; ?>
</p>

<?php if ($this->_tpl_vars['clientnotes']): ?>
<div style="clear:both;overflow:auto;margin:15px 0;padding:5px; max-height:150px;border:2px dashed #e0e0e0;border-right:0;background-color:#fff;-moz-border-radius: 6px;-webkit-border-radius: 6px;-o-border-radius: 6px;border-radius: 6px;">
<?php $_from = $this->_tpl_vars['clientnotes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['note']):
?>
<div class="ticketstaffnotes">
    <table class="ticketstaffnotestable">
        <tr>
            <td><?php echo $this->_tpl_vars['note']['adminuser']; ?>
</td>
            <td align="right"><?php echo $this->_tpl_vars['note']['modified']; ?>
</td>
        </tr>
    </table>
    <div>
        <?php echo $this->_tpl_vars['note']['note']; ?>

        <div style="float:right;"><a href="clientsnotes.php?userid=<?php echo $this->_tpl_vars['clientsdetails']['userid']; ?>
&action=edit&id=<?php echo $this->_tpl_vars['note']['id']; ?>
"><img src="images/edit.gif" width="16" height="16" align="absmiddle" /></a></div>
    </div>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['addons_html']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['addon_html']):
?>
<div style="margin-bottom:15px;"><?php echo $this->_tpl_vars['addon_html']; ?>
</div>
<?php endforeach; endif; unset($_from); ?>

<div id="tabs">
    <ul>
        <li id="tab0" class="tab"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['addreply']; ?>
</a></li>
        <li id="tab1" class="tab"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['addnote']; ?>
</a></li>
        <li id="tab2" class="tab"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['setup']['customfields']; ?>
</a></li>
        <li id="tab3" class="tab" onclick="loadTab(3,'tickets',0)"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['clienttickets']; ?>
</a></li>
        <li id="tab4" class="tab" onclick="loadTab(4,'clientlog',0)"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['clientlog']; ?>
</a></li>
        <li id="tab5" class="tab"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['options']; ?>
</a></li>
        <li id="tab6" class="tab" onclick="loadTab(6,'ticketlog',0)"><a href="javascript:;"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['ticketlog']; ?>
</a></li>
    </ul>
</div>

<div id="tab0box" class="tabbox">
    <div id="tab_content">

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=viewticket&id=<?php echo $this->_tpl_vars['ticketid']; ?>
" enctype="multipart/form-data" name="replyfrm" id="replyfrm">

<textarea name="message" id="replymessage" rows="14" style="width:100%">


<?php echo $this->_tpl_vars['signature']; ?>
</textarea>

<br /><img src="images/spacer.gif" height="8" width="1" /><br />

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['postreply']; ?>
</td><td class="fieldarea"><select name="postaction">
<option value="return"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['setansweredreturn']; ?>

<option value="answered"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['setansweredremain']; ?>

<?php $_from = $this->_tpl_vars['statuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['statusitem']):
?>
<?php if ($this->_tpl_vars['statusitem']['id'] > 4): ?><option value="setstatus<?php echo $this->_tpl_vars['statusitem']['id']; ?>
"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['setto']; ?>
 <?php echo $this->_tpl_vars['statusitem']['title']; ?>
 <?php echo $this->_tpl_vars['_ADMINLANG']['support']['andremain']; ?>
</option><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<option value="close"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['closereturn']; ?>

<option value="note"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['addprivatenote']; ?>

</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onClick="window.open('supportticketskbarticle.php','kbartwnd','width=500,height=400,scrollbars=yes');return false"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['insertkblink']; ?>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" id="insertpredef"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['insertpredef']; ?>
</a>
</td></tr>
<tr><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['attachments']; ?>
</td><td class="fieldarea"><input type="file" name="attachments[]" size="85"> <a href="#" id="addfileupload"><img src="images/icons/add.png" align="absmiddle" border="0" /> <?php echo $this->_tpl_vars['_ADMINLANG']['support']['addmore']; ?>
</a><br /><div id="fileuploads"></div></td></tr>
<?php if ($this->_tpl_vars['userid']): ?><tr><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['addbilling']; ?>
</td><td class="fieldarea"><input type="text" name="billingdescription" size="60" value="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['toinvoicedes']; ?>
" onfocus="if(this.value=='<?php echo $this->_tpl_vars['_ADMINLANG']['support']['toinvoicedes']; ?>
')this.value=''" /> @ <input type="text" name="billingamount" size="10" value="<?php echo $this->_tpl_vars['_ADMINLANG']['fields']['amount']; ?>
" /> <select name="billingaction">
<option value="3" /> <?php echo $this->_tpl_vars['_ADMINLANG']['billableitems']['invoiceimmediately']; ?>
</option>
<option value="0" /> <?php echo $this->_tpl_vars['_ADMINLANG']['billableitems']['dontinvoicefornow']; ?>
</option>
<option value="1" /> <?php echo $this->_tpl_vars['_ADMINLANG']['billableitems']['invoicenextcronrun']; ?>
</option>
<option value="2" /> <?php echo $this->_tpl_vars['_ADMINLANG']['billableitems']['addnextinvoice']; ?>
</option>
</select></td></tr><?php endif; ?>
</table>

<div id="prerepliescontainer" style="display:none;">
    <img src="images/spacer.gif" height="8" width="1" />
    <br />
    <div style="border:1px solid #DFDCCE;background-color:#F7F7F2;padding:5px;text-align:left;">
        <div style="float:right;">Search: <input type="text" id="predefq" size="25" /></div>
        <div id="prerepliescontent"><?php echo $this->_tpl_vars['predefinedreplies']; ?>
</div>
    </div>
</div>

<img src="images/spacer.gif" height="8" width="1" />
<br />
<div align="center"><input type="submit" value="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['addresponse']; ?>
" name="postreply" class="button" id="postreplybutton" /></div>

</form>

    </div>
</div>
<div id="tab1box" class="tabbox">
    <div id="tab_content">

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=viewticket&id=<?php echo $this->_tpl_vars['ticketid']; ?>
">
<input type="hidden" name="postaction" value="note" />

<textarea name="message" id="replymessage" rows="14" style="width:100%"></textarea>

<br />
<img src="images/spacer.gif" height="8" width="1" />
<br />

<div align="center"><input type="submit" value="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['addnote']; ?>
" class="button" name="postreply" /></div>

</form>

    </div>
</div>
<div id="tab2box" class="tabbox">
    <div id="tab_content">

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=viewticket&id=<?php echo $this->_tpl_vars['ticketid']; ?>
&sub=savecustomfields">

<?php if (! $this->_tpl_vars['numcustomfields']): ?>
<div align="center"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['nocustomfields']; ?>
</div>
<?php else: ?>
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<?php $_from = $this->_tpl_vars['customfields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['customfield']):
?>
<tr><td width="25%" class="fieldlabel"><?php echo $this->_tpl_vars['customfield']['name']; ?>
</td><td class="fieldarea"><?php echo $this->_tpl_vars['customfield']['input']; ?>
</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<img src="images/spacer.gif" height="10" width="1" /><br />
<div align="center"><input type="submit" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['savechanges']; ?>
" class="button"></div>
</form>
<?php endif; ?>

    </div>
</div>
<div id="tab3box" class="tabbox">
    <div id="tab_content">

<img src="images/loading.gif" align="top" /> <?php echo $this->_tpl_vars['_ADMINLANG']['global']['loading']; ?>


    </div>
</div>
<div id="tab4box" class="tabbox">
    <div id="tab_content">

<img src="images/loading.gif" align="top" /> <?php echo $this->_tpl_vars['_ADMINLANG']['global']['loading']; ?>


    </div>
</div>
<div id="tab5box" class="tabbox">
    <div id="tab_content">

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=viewticket&id=<?php echo $this->_tpl_vars['ticketid']; ?>
">

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['department']; ?>
</td><td class="fieldarea"><select name="deptid">
<?php $_from = $this->_tpl_vars['departments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['department']):
?>
<option value="<?php echo $this->_tpl_vars['department']['id']; ?>
"<?php if ($this->_tpl_vars['department']['id'] == $this->_tpl_vars['deptid']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['department']['name']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select></td><td width="15%" class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['clientid']; ?>
</td><td class="fieldarea"><input type="text" name="userid" size="15" id="clientsearchval" value="<?php echo $this->_tpl_vars['userid']; ?>
" /> <img src="images/icons/delete.png" alt="Cancel" class="absmiddle" id="clientsearchcancel" height="16" width="16"><div id="ticketclientsearchresults"></div></td></tr>
<tr><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['subject']; ?>
</td><td class="fieldarea"><input type="text" name="subject" value="<?php echo $this->_tpl_vars['subject']; ?>
" style="width:80%"></td><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['flag']; ?>
</td><td class="fieldarea"><select name="flagto">
<option value="0"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['none']; ?>
</option>
<?php $_from = $this->_tpl_vars['staff']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['staffmember']):
?>
<option value="<?php echo $this->_tpl_vars['staffmember']['id']; ?>
"<?php if ($this->_tpl_vars['staffmember']['id'] == $this->_tpl_vars['flag']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['staffmember']['name']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select></td></tr>
<tr><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['status']; ?>
</td><td class="fieldarea"><select name="status">
<?php $_from = $this->_tpl_vars['statuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['statusitem']):
?>
<option<?php if ($this->_tpl_vars['statusitem']['title'] == $this->_tpl_vars['status']): ?> selected<?php endif; ?> style="color:<?php echo $this->_tpl_vars['statusitem']['color']; ?>
"><?php echo $this->_tpl_vars['statusitem']['title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select></td><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['priority']; ?>
</td><td class="fieldarea"><select name="priority">
<option value="High"<?php if ($this->_tpl_vars['priority'] == 'High'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['_ADMINLANG']['status']['high']; ?>
</option>
<option value="Medium"<?php if ($this->_tpl_vars['priority'] == 'Medium'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['_ADMINLANG']['status']['medium']; ?>
</option>
<option value="Low"<?php if ($this->_tpl_vars['priority'] == 'Low'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['_ADMINLANG']['status']['low']; ?>
</option>
</select></td></tr>
<tr><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['ccrecepients']; ?>
</td><td class="fieldarea"><input type="text" name="cc" value="<?php echo $this->_tpl_vars['cc']; ?>
" size="40"> (<?php echo $this->_tpl_vars['_ADMINLANG']['transactions']['commaseparated']; ?>
)</td><td class="fieldlabel"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['mergeticket']; ?>
</td><td class="fieldarea"><input type="text" name="mergetid" size="10"> (<?php echo $this->_tpl_vars['_ADMINLANG']['support']['notocombine']; ?>
)</td></tr>
</table>

<img src="images/spacer.gif" height="10" width="1"><br>
<div align="center"><input type="submit" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['savechanges']; ?>
" class="button"></div>
</form>

    </div>
</div>
<div id="tab6box" class="tabbox">
    <div id="tab_content">

<img src="images/loading.gif" align="top" /> <?php echo $this->_tpl_vars['_ADMINLANG']['global']['loading']; ?>


    </div>
</div>

<br />

<?php if ($this->_tpl_vars['numnotes']): ?>
<h2><?php echo $this->_tpl_vars['_ADMINLANG']['support']['privatestaffnote']; ?>
</h2>
<?php $_from = $this->_tpl_vars['notes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['note']):
?>
<div class="ticketstaffnotes">
    <table class="ticketstaffnotestable">
        <tr>
            <td><?php echo $this->_tpl_vars['note']['admin']; ?>
</td>
            <td align="right"><?php echo $this->_tpl_vars['note']['date']; ?>
</td>
        </tr>
    </table>
    <div>
        <?php echo $this->_tpl_vars['note']['message']; ?>

        <div style="float:right;"><a href="#" onClick="doDeleteNote('<?php echo $this->_tpl_vars['note']['id']; ?>
');return false"><img src="images/delete.gif" alt="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['deleteticketnote']; ?>
" border="0" align="absmiddle" /></a></div>
    </div>
</div>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['relatedservices']): ?>
<div class="tablebg">
<table class="datatable" id="relatedservicestbl" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['product']; ?>
</th><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['amount']; ?>
</th><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['billingcycle']; ?>
</th><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['signupdate']; ?>
</th><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['nextduedate']; ?>
</th><th><?php echo $this->_tpl_vars['_ADMINLANG']['fields']['status']; ?>
</th></tr>
<?php $_from = $this->_tpl_vars['relatedservices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['relatedservice']):
?>
<tr<?php if ($this->_tpl_vars['relatedservice']['selected']): ?> class="rowhighlight"<?php endif; ?>><td><?php echo $this->_tpl_vars['relatedservice']['name']; ?>
</td><td><?php echo $this->_tpl_vars['relatedservice']['amount']; ?>
</td><td><?php echo $this->_tpl_vars['relatedservice']['billingcycle']; ?>
</td><td><?php echo $this->_tpl_vars['relatedservice']['regdate']; ?>
</td><td><?php echo $this->_tpl_vars['relatedservice']['nextduedate']; ?>
</td><td><?php echo $this->_tpl_vars['relatedservice']['status']; ?>
</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>
<?php if ($this->_tpl_vars['relatedservicesexpand']): ?><div id="relatedservicesexpand" style="padding:2px 15px;text-align:right;"><a href="#" onclick="expandRelServices();return false"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['expand']; ?>
</a></div><?php endif; ?>
<?php endif; ?>

<br />

<table width=100% cellpadding=5 cellspacing=1 bgcolor="#cccccc" align=center>
<?php $_from = $this->_tpl_vars['replies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['reply']):
?>
<tr><td rowspan="2" bgcolor="<?php echo smarty_function_cycle(array('values' => "#F4F4F4,#F8F8F8"), $this);?>
" width="200" valign="top">

<?php if ($this->_tpl_vars['reply']['admin']): ?>

<strong><?php echo $this->_tpl_vars['reply']['admin']; ?>
</strong><br />
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['staff']; ?>
<br />

<?php if ($this->_tpl_vars['reply']['rating']): ?>
<br />
<?php echo $this->_tpl_vars['_ADMINLANG']['support']['rating']; ?>
: <?php echo $this->_tpl_vars['reply']['rating']; ?>

<br />
<?php endif; ?>

<?php else: ?>

<strong><?php echo $this->_tpl_vars['reply']['clientname']; ?>
</strong><br />

<?php if ($this->_tpl_vars['reply']['contactid']): ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['fields']['contact']; ?>
<br />
<?php elseif ($this->_tpl_vars['reply']['userid']): ?>
<?php echo $this->_tpl_vars['_ADMINLANG']['fields']['client']; ?>
<br />
<?php else: ?>
<a href="mailto:<?php echo $this->_tpl_vars['reply']['clientemail']; ?>
"><?php echo $this->_tpl_vars['reply']['clientemail']; ?>
</a>
<br />
<input type="button" value="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['blocksender']; ?>
" style="font-size:9px;" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>
?action=viewticket&id=<?php echo $this->_tpl_vars['ticketid']; ?>
&blocksender=true'"><br>
<?php endif; ?>

<?php endif; ?>

<br />
<div class="editbtns<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>"><input type="button" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['edit']; ?>
" onclick="editTicket('<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>')" /></div><div class="editbtns<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>" style="display:none"><input type="button" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['save']; ?>
" onclick="editTicketSave('<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>')" /> <input type="button" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['cancel']; ?>
" onclick="editTicketCancel('<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>')" /></div>

</td><td bgcolor="#F4F4F4">

<?php if ($this->_tpl_vars['reply']['id']): ?>
<a href="#" onClick="doDeleteReply('<?php echo $this->_tpl_vars['reply']['id']; ?>
');return false">
<?php else: ?>
<a href="#" onClick="doDeleteTicket();return false">
<?php endif; ?>
<img src="images/icons/delete.png" alt="<?php echo $this->_tpl_vars['_ADMINLANG']['support']['deleteticket']; ?>
" align="right" border="0" hspace="5"></a>

<?php if ($this->_tpl_vars['reply']['id']): ?>
<a href="#" onClick="quoteTicket('','<?php echo $this->_tpl_vars['reply']['id']; ?>
')">
<?php else: ?>
<a href="#" onClick="quoteTicket('<?php echo $this->_tpl_vars['ticketid']; ?>
','')">
<?php endif; ?>
<img src="images/icons/quote.png" align="right" border="0"></a> <?php echo $this->_tpl_vars['reply']['date']; ?>


</td></tr>
<tr><td bgcolor="#F4F4F4" id="content<?php if ($this->_tpl_vars['reply']['id']): ?>r<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>t<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>">

<div>

<?php echo $this->_tpl_vars['reply']['message']; ?>


<?php if ($this->_tpl_vars['reply']['numattachments']): ?>
<p>
<b><?php echo $this->_tpl_vars['_ADMINLANG']['support']['attachments']; ?>
</b>
<br />
<?php $_from = $this->_tpl_vars['reply']['attachments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['attachment']):
?>
<?php if ($this->_tpl_vars['thumbnails']): ?>
<div class="ticketattachmentcontainer">
<a href="../<?php echo $this->_tpl_vars['attachment']['dllink']; ?>
"><img src="../includes/thumbnail.php?<?php if ($this->_tpl_vars['reply']['id']): ?>rid=<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>tid=<?php echo $this->_tpl_vars['ticketid']; ?>
<?php endif; ?>&i=<?php echo $this->_tpl_vars['num']; ?>
" class="ticketattachmentthumb" /><br />
<img src="images/icons/attachment.png" align="absmiddle" /> <?php echo $this->_tpl_vars['attachment']['filename']; ?>
</a><br /><small><a href="<?php echo $this->_tpl_vars['attachment']['deletelink']; ?>
" onclick="return confirm('<?php echo ((is_array($_tmp=$this->_tpl_vars['_ADMINLANG']['support']['delattachment'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
')" style="color:#cc0000"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['remove']; ?>
</a></small>
</div>
<?php else: ?>
<a href="../<?php echo $this->_tpl_vars['attachment']['dllink']; ?>
"><img src="images/icons/attachment.png" align="absmiddle" /> <?php echo $this->_tpl_vars['attachment']['filename']; ?>
</a> <small><a href="<?php echo $this->_tpl_vars['attachment']['deletelink']; ?>
" onclick="return confirm('<?php echo ((is_array($_tmp=$this->_tpl_vars['_ADMINLANG']['support']['delattachment'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
')" style="color:#cc0000"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['remove']; ?>
</a></small><br />
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</p>
<?php endif; ?>

</div>

</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p align="center"><a href="supportticketsprint.php?id=<?php echo $this->_tpl_vars['ticketid']; ?>
" target="_blank"><?php echo $this->_tpl_vars['_ADMINLANG']['support']['viewprintable']; ?>
</a></p>