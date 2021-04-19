<?php /* Smarty version 2.6.26, created on 2012-12-05 22:01:20
         compiled from /var/www/clients/templates/default/viewticket.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', '/var/www/clients/templates/default/viewticket.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['error']): ?>

<p><?php echo $this->_tpl_vars['LANG']['supportticketinvalid']; ?>
</p>

<?php else: ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['LANG']['supportticketsviewticket'])) ? $this->_run_mod_handler('cat', true, $_tmp, ' #') : smarty_modifier_cat($_tmp, ' #')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tid']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tid'])))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['errormessage']): ?>
<div class="alert alert-error">
    <p class="bold"><?php echo $this->_tpl_vars['LANG']['clientareaerrors']; ?>
</p>
    <ul>
        <?php echo $this->_tpl_vars['errormessage']; ?>

    </ul>
</div>
<?php endif; ?>

<h2><?php echo $this->_tpl_vars['subject']; ?>
</h2>

<div class="ticketdetailscontainer">
    <div class="col4">
        <div class="internalpadding">
            <?php echo $this->_tpl_vars['LANG']['supportticketsubmitted']; ?>

            <div class="detail"><?php echo $this->_tpl_vars['date']; ?>
</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            <?php echo $this->_tpl_vars['LANG']['supportticketsdepartment']; ?>

            <div class="detail"><?php echo $this->_tpl_vars['department']; ?>
</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            <?php echo $this->_tpl_vars['LANG']['supportticketspriority']; ?>

            <div class="detail"><?php echo $this->_tpl_vars['urgency']; ?>
</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            <?php echo $this->_tpl_vars['LANG']['supportticketsstatus']; ?>

            <div class="detail"><?php echo $this->_tpl_vars['status']; ?>
</div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php if ($this->_tpl_vars['customfields']): ?>
<table class="table table-framed">
<?php $_from = $this->_tpl_vars['customfields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['customfield']):
?>
<tr><td><?php echo $this->_tpl_vars['customfield']['name']; ?>
:</td><td><?php echo $this->_tpl_vars['customfield']['value']; ?>
</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<p><input type="button" value="<?php echo $this->_tpl_vars['LANG']['clientareabacklink']; ?>
" class="btn" onclick="window.location='supporttickets.php'" /> <input type="button" value="<?php echo $this->_tpl_vars['LANG']['supportticketsreply']; ?>
" class="btn btn-primary" onclick="jQuery('#replycont').slideToggle()" /><?php if ($this->_tpl_vars['showclosebutton']): ?> <input type="button" value="<?php echo $this->_tpl_vars['LANG']['supportticketsclose']; ?>
" class="btn btn-danger" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>
?tid=<?php echo $this->_tpl_vars['tid']; ?>
&amp;c=<?php echo $this->_tpl_vars['c']; ?>
&amp;closeticket=true'" /><?php endif; ?></p>

<div id="replycont" class="ticketreplybox<?php if (! $_GET['postreply']): ?> hide<?php endif; ?>">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?tid=<?php echo $this->_tpl_vars['tid']; ?>
&amp;c=<?php echo $this->_tpl_vars['c']; ?>
&amp;postreply=true" enctype="multipart/form-data" class="form-stacked">

    <fieldset class="control-group">

	    <div class="row">
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="name"><?php echo $this->_tpl_vars['LANG']['supportticketsclientname']; ?>
</label>
        			<div class="controls">
        			    <?php if ($this->_tpl_vars['loggedin']): ?><input class="input-xlarge disabled" type="text" id="name" value="<?php echo $this->_tpl_vars['clientname']; ?>
" disabled="disabled" /><?php else: ?><input class="input-xlarge" type="text" name="replyname" id="name" value="<?php echo $this->_tpl_vars['replyname']; ?>
" /><?php endif; ?>
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="email"><?php echo $this->_tpl_vars['LANG']['supportticketsclientemail']; ?>
</label>
        			<div class="controls">
        			    <?php if ($this->_tpl_vars['loggedin']): ?><input class="input-xlarge disabled" type="text" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
" disabled="disabled" /><?php else: ?><input class="input-xlarge" type="text" name="replyemail" id="email" value="<?php echo $this->_tpl_vars['replyemail']; ?>
" /><?php endif; ?>
        			</div>
        		</div>
        	</div>
        </div>

	    <div class="control-group">
		    <label class="control-label bold" for="message"><?php echo $this->_tpl_vars['LANG']['contactmessage']; ?>
</label>
			<div class="controls">
			    <textarea name="replymessage" id="message" rows="12" class="fullwidth"><?php echo $this->_tpl_vars['replymessage']; ?>
</textarea>
			</div>
		</div>

	    <div class="control-group">
		    <label class="control-label bold" for="attachments"><?php echo $this->_tpl_vars['LANG']['supportticketsticketattachments']; ?>
:</label>
			<div class="controls">
			    <input type="file" name="attachments[]" style="width:70%;" /><br />
                <div id="fileuploads"></div>
                <a href="#" onclick="extraTicketAttachment();return false"><img src="images/add.gif" align="absmiddle" border="0" /> <?php echo $this->_tpl_vars['LANG']['addmore']; ?>
</a><br />
                (<?php echo $this->_tpl_vars['LANG']['supportticketsallowedextensions']; ?>
: <?php echo $this->_tpl_vars['allowedfiletypes']; ?>
)
			</div>
		</div>

    </fieldset>

    <p align="center"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['supportticketsticketsubmit']; ?>
" class="btn btn-primary" /></p>

</form>
</div>

<div class="ticketmsgs">
<?php $_from = $this->_tpl_vars['descreplies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['reply']):
?>
    <div class="<?php if ($this->_tpl_vars['reply']['admin']): ?>admin<?php else: ?>client<?php endif; ?>header">
        <div style="float:right;"><?php echo $this->_tpl_vars['reply']['date']; ?>
</div>
        <?php if ($this->_tpl_vars['reply']['admin']): ?>
            <?php echo $this->_tpl_vars['reply']['name']; ?>
 || <?php echo $this->_tpl_vars['LANG']['supportticketsstaff']; ?>

        <?php elseif ($this->_tpl_vars['reply']['contactid']): ?>
            <?php echo $this->_tpl_vars['reply']['name']; ?>
 || <?php echo $this->_tpl_vars['LANG']['supportticketscontact']; ?>

        <?php elseif ($this->_tpl_vars['reply']['userid']): ?>
            <?php echo $this->_tpl_vars['reply']['name']; ?>
 || <?php echo $this->_tpl_vars['LANG']['supportticketsclient']; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['reply']['name']; ?>
 || <?php echo $this->_tpl_vars['reply']['email']; ?>

        <?php endif; ?>
    </div>
    <div class="<?php if ($this->_tpl_vars['reply']['admin']): ?>admin<?php else: ?>client<?php endif; ?>msg">

        <?php echo $this->_tpl_vars['reply']['message']; ?>


        <?php if ($this->_tpl_vars['reply']['attachments']): ?>
        <div class="attachments">
            <strong><?php echo $this->_tpl_vars['LANG']['supportticketsticketattachments']; ?>
:</strong><br />
            <?php $_from = $this->_tpl_vars['reply']['attachments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['attachment']):
?>
            &nbsp; <img src="images/article.gif" align="middle" /> <a href="dl.php?type=<?php if ($this->_tpl_vars['reply']['id']): ?>ar&id=<?php echo $this->_tpl_vars['reply']['id']; ?>
<?php else: ?>a&id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?>&i=<?php echo $this->_tpl_vars['num']; ?>
"><?php echo $this->_tpl_vars['attachment']; ?>
</a><br />
            <?php endforeach; endif; unset($_from); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['reply']['id'] && $this->_tpl_vars['reply']['admin'] && $this->_tpl_vars['ratingenabled']): ?>
        <?php if ($this->_tpl_vars['reply']['rating']): ?>
        <table class="ticketrating" align="right">
            <tr>
                <td><?php echo $this->_tpl_vars['LANG']['ticketreatinggiven']; ?>
&nbsp;</td>
                <?php $_from = $this->_tpl_vars['ratings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rating']):
?>
                <td background="images/rating_<?php if ($this->_tpl_vars['reply']['rating'] >= $this->_tpl_vars['rating']): ?>pos<?php else: ?>neg<?php endif; ?>.png"></td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
        </table>
        <?php else: ?>
        <table class="ticketrating" align="right">
            <tr onmouseout="rating_leave('rate<?php echo $this->_tpl_vars['reply']['id']; ?>
')">
                <td><?php echo $this->_tpl_vars['LANG']['ticketratingquestion']; ?>
&nbsp;</td>
                <td class="point" onmouseover="rating_hover('rate<?php echo $this->_tpl_vars['reply']['id']; ?>
_1')" onclick="rating_select('<?php echo $this->_tpl_vars['tid']; ?>
','<?php echo $this->_tpl_vars['c']; ?>
','rate<?php echo $this->_tpl_vars['reply']['id']; ?>
_1')"><strong><?php echo $this->_tpl_vars['LANG']['ticketratingpoor']; ?>
&nbsp;</strong></td>
                <?php $_from = $this->_tpl_vars['ratings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rating']):
?>
                <td class="star" id="rate<?php echo $this->_tpl_vars['reply']['id']; ?>
_<?php echo $this->_tpl_vars['rating']; ?>
" onmouseover="rating_hover(this.id)" onclick="rating_select('<?php echo $this->_tpl_vars['tid']; ?>
','<?php echo $this->_tpl_vars['c']; ?>
',this.id)"></td>
                <?php endforeach; endif; unset($_from); ?>
                <td class="point" onmouseover="rating_hover('rate<?php echo $this->_tpl_vars['reply']['id']; ?>
_5')" onclick="rating_select('<?php echo $this->_tpl_vars['tid']; ?>
','<?php echo $this->_tpl_vars['c']; ?>
','rate<?php echo $this->_tpl_vars['reply']['id']; ?>
_5')"><strong>&nbsp;<?php echo $this->_tpl_vars['LANG']['ticketratingexcellent']; ?>
</strong></td>
            </tr>
        </table>
<?php endif; ?>
<div class="clear"></div>
<?php endif; ?>

    </div>
<?php endforeach; endif; unset($_from); ?>
</div>

<p><input type="button" value="<?php echo $this->_tpl_vars['LANG']['clientareabacklink']; ?>
" class="btn" onclick="window.location='supporttickets.php'" /> <input type="button" value="<?php echo $this->_tpl_vars['LANG']['supportticketsreply']; ?>
" class="btn btn-primary" onclick="jQuery('#replycont2').slideToggle()" /><?php if ($this->_tpl_vars['showclosebutton']): ?> <input type="button" value="<?php echo $this->_tpl_vars['LANG']['supportticketsclose']; ?>
" class="btn btn-danger" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>
?tid=<?php echo $this->_tpl_vars['tid']; ?>
&amp;c=<?php echo $this->_tpl_vars['c']; ?>
&amp;closeticket=true'" /><?php endif; ?></p>

<div id="replycont2" class="ticketreplybox hide">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?tid=<?php echo $this->_tpl_vars['tid']; ?>
&amp;c=<?php echo $this->_tpl_vars['c']; ?>
&amp;postreply=true" enctype="multipart/form-data" class="form-stacked">

    <fieldset class="control-group">

	    <div class="row">
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="name"><?php echo $this->_tpl_vars['LANG']['supportticketsclientname']; ?>
</label>
        			<div class="controls">
        			    <?php if ($this->_tpl_vars['loggedin']): ?><input class="input-xlarge disabled" type="text" id="name" value="<?php echo $this->_tpl_vars['clientname']; ?>
" disabled="disabled" /><?php else: ?><input class="input-xlarge" type="text" name="replyname" id="name" value="<?php echo $this->_tpl_vars['replyname']; ?>
" /><?php endif; ?>
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="control-group">
        		    <label class="control-label bold" for="email"><?php echo $this->_tpl_vars['LANG']['supportticketsclientemail']; ?>
</label>
        			<div class="controls">
        			    <?php if ($this->_tpl_vars['loggedin']): ?><input class="input-xlarge disabled" type="text" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
" disabled="disabled" /><?php else: ?><input class="input-xlarge" type="text" name="replyemail" id="email" value="<?php echo $this->_tpl_vars['replyemail']; ?>
" /><?php endif; ?>
        			</div>
        		</div>
        	</div>
        </div>

	    <div class="control-group">
		    <label class="control-label bold" for="message"><?php echo $this->_tpl_vars['LANG']['contactmessage']; ?>
</label>
			<div class="controls">
			    <textarea name="replymessage" id="message" rows="12" class="fullwidth"><?php echo $this->_tpl_vars['replymessage']; ?>
</textarea>
			</div>
		</div>

	    <div class="control-group">
		    <label class="control-label bold" for="attachments"><?php echo $this->_tpl_vars['LANG']['supportticketsticketattachments']; ?>
:</label>
			<div class="controls">
			    <input type="file" name="attachments[]" style="width:70%;" /><br />
                <div id="fileuploads"></div>
                <a href="#" onclick="extraTicketAttachment();return false"><img src="images/add.gif" align="absmiddle" border="0" /> <?php echo $this->_tpl_vars['LANG']['addmore']; ?>
</a><br />
                (<?php echo $this->_tpl_vars['LANG']['supportticketsallowedextensions']; ?>
: <?php echo $this->_tpl_vars['allowedfiletypes']; ?>
)
			</div>
		</div>

    </fieldset>

    <p align="center"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['supportticketsticketsubmit']; ?>
" class="btn btn-primary" /></p>

</form>
</div>

<?php endif; ?>