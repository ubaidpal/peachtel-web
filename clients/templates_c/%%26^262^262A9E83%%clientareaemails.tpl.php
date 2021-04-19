<?php /* Smarty version 2.6.26, created on 2012-12-07 07:48:45
         compiled from /var/www/clients/templates/default/clientareaemails.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['clientareaemails'],'desc' => $this->_tpl_vars['LANG']['emailstagline'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><?php echo $this->_tpl_vars['numitems']; ?>
 <?php echo $this->_tpl_vars['LANG']['recordsfound']; ?>
, <?php echo $this->_tpl_vars['LANG']['page']; ?>
 <?php echo $this->_tpl_vars['pagenumber']; ?>
 <?php echo $this->_tpl_vars['LANG']['pageof']; ?>
 <?php echo $this->_tpl_vars['totalpages']; ?>
</p>

<br />

<table class="table table-striped table-framed">
    <thead>
        <tr>
            <th<?php if ($this->_tpl_vars['orderby'] == 'date'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=emails&orderby=date"><?php echo $this->_tpl_vars['LANG']['clientareaemailsdate']; ?>
</a></th>
            <th<?php if ($this->_tpl_vars['orderby'] == 'subject'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=emails&orderby=subject"><?php echo $this->_tpl_vars['LANG']['clientareaemailssubject']; ?>
</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php $_from = $this->_tpl_vars['emails']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['email']):
?>
        <tr>
            <td><?php echo $this->_tpl_vars['email']['date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['email']['subject']; ?>
</td>
            <td class="textcenter"><input type="button" class="btn btn-info" value="<?php echo $this->_tpl_vars['LANG']['emailviewmessage']; ?>
" onclick="popupWindow('viewemail.php?id=<?php echo $this->_tpl_vars['email']['id']; ?>
','emlmsg',650,400)" /></td>
        </tr>
<?php endforeach; else: ?>
        <tr>
            <td colspan="3" class="textcenter"><?php echo $this->_tpl_vars['LANG']['norecordsfound']; ?>
</td>
        </tr>
<?php endif; unset($_from); ?>
    </tbody>
</table>

<div class="pagination">
    <ul>
        <li class="prev<?php if (! $this->_tpl_vars['prevpage']): ?> disabled<?php endif; ?>"><a href="<?php if ($this->_tpl_vars['prevpage']): ?>clientarea.php?action=emails&amp;page=<?php echo $this->_tpl_vars['prevpage']; ?>
<?php else: ?>javascript:return false;<?php endif; ?>">&larr; <?php echo $this->_tpl_vars['LANG']['previouspage']; ?>
</a></li>
        <li class="next<?php if (! $this->_tpl_vars['nextpage']): ?> disabled<?php endif; ?>"><a href="<?php if ($this->_tpl_vars['nextpage']): ?>clientarea.php?action=emails&amp;page=<?php echo $this->_tpl_vars['nextpage']; ?>
<?php else: ?>javascript:return false;<?php endif; ?>"><?php echo $this->_tpl_vars['LANG']['nextpage']; ?>
 &rarr;</a></li>
    </ul>
</div>