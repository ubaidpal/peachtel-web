<?php /* Smarty version 2.6.26, created on 2012-11-29 17:25:36
         compiled from /var/www/clients/templates/default/clientareaquotes.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['quotestitle'],'desc' => $this->_tpl_vars['LANG']['quotesintro'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="resultsbox">
<p><?php echo $this->_tpl_vars['numitems']; ?>
 <?php echo $this->_tpl_vars['LANG']['recordsfound']; ?>
, <?php echo $this->_tpl_vars['LANG']['page']; ?>
 <?php echo $this->_tpl_vars['pagenumber']; ?>
 <?php echo $this->_tpl_vars['LANG']['pageof']; ?>
 <?php echo $this->_tpl_vars['totalpages']; ?>
</p>
</div>

<table class="table table-striped table-framed table-centered">
    <thead>
        <tr>
            <th<?php if ($this->_tpl_vars['orderby'] == 'id'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=quotes&orderby=id"><?php echo $this->_tpl_vars['LANG']['quotenumber']; ?>
</a></th>
            <th<?php if ($this->_tpl_vars['orderby'] == 'subject'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=quotes&orderby=subject"><?php echo $this->_tpl_vars['LANG']['quotesubject']; ?>
</a></th>
            <th<?php if ($this->_tpl_vars['orderby'] == 'datecreated'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=quotes&orderby=datecreated"><?php echo $this->_tpl_vars['LANG']['quotedatecreated']; ?>
</a></th>
            <th<?php if ($this->_tpl_vars['orderby'] == 'validuntil'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=quotes&orderby=validuntil"><?php echo $this->_tpl_vars['LANG']['quotevaliduntil']; ?>
</a></th>
            <th<?php if ($this->_tpl_vars['orderby'] == 'stage'): ?> class="headerSort<?php echo $this->_tpl_vars['sort']; ?>
"<?php endif; ?>><a href="clientarea.php?action=quotes&orderby=stage"><?php echo $this->_tpl_vars['LANG']['quotestage']; ?>
</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php $_from = $this->_tpl_vars['quotes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['quote']):
?>
        <tr>
            <td><a href="dl.php?type=q&id=<?php echo $this->_tpl_vars['quote']['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['quote']['id']; ?>
</a></td>
            <td><?php echo $this->_tpl_vars['quote']['subject']; ?>
</td>
            <td><?php echo $this->_tpl_vars['quote']['datecreated']; ?>
</td>
            <td><?php echo $this->_tpl_vars['quote']['validuntil']; ?>
</td>
            <td><?php echo $this->_tpl_vars['quote']['stage']; ?>
</td>
            <td class="textcenter"><input type="button" class="btn btn-info" value="<?php echo $this->_tpl_vars['LANG']['quotedownload']; ?>
" onclick="window.location='dl.php?type=q&id=<?php echo $this->_tpl_vars['quote']['id']; ?>
'" /></td>
        </tr>
<?php endforeach; else: ?>
        <tr>
            <td colspan="6" class="textcenter"><?php echo $this->_tpl_vars['LANG']['norecordsfound']; ?>
</td>
        </tr>
<?php endif; unset($_from); ?>
    </tbody>
</table>

<div class="recordslimit">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
?action=<?php echo $this->_tpl_vars['clientareaaction']; ?>
" />
    <select name="itemlimit" onchange="submit()">
        <option><?php echo $this->_tpl_vars['LANG']['resultsperpage']; ?>
</option>
        <option value="10"<?php if ($this->_tpl_vars['itemlimit'] == 10): ?> selected<?php endif; ?>>10</option>
        <option value="25"<?php if ($this->_tpl_vars['itemlimit'] == 25): ?> selected<?php endif; ?>>25</option>
        <option value="50"<?php if ($this->_tpl_vars['itemlimit'] == 50): ?> selected<?php endif; ?>>50</option>
        <option value="100"<?php if ($this->_tpl_vars['itemlimit'] == 100): ?> selected<?php endif; ?>>100</option>
        <option value="all"<?php if ($this->_tpl_vars['itemlimit'] == 99999999): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['clientareaunlimited']; ?>
</option>
    </select>
    </form>
</div>

<div class="pagination">
    <ul>
        <li class="prev<?php if (! $this->_tpl_vars['prevpage']): ?> disabled<?php endif; ?>"><a href="<?php if ($this->_tpl_vars['prevpage']): ?>clientarea.php?action=quotes&amp;page=<?php echo $this->_tpl_vars['prevpage']; ?>
<?php else: ?>javascript:return false;<?php endif; ?>">&larr; <?php echo $this->_tpl_vars['LANG']['previouspage']; ?>
</a></li>
        <li class="next<?php if (! $this->_tpl_vars['nextpage']): ?> disabled<?php endif; ?>"><a href="<?php if ($this->_tpl_vars['nextpage']): ?>clientarea.php?action=quotes&amp;page=<?php echo $this->_tpl_vars['nextpage']; ?>
<?php else: ?>javascript:return false;<?php endif; ?>"><?php echo $this->_tpl_vars['LANG']['nextpage']; ?>
 &rarr;</a></li>
    </ul>
</div>