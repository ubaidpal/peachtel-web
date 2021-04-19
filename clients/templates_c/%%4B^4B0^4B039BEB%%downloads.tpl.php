<?php /* Smarty version 2.6.26, created on 2012-12-07 07:42:58
         compiled from /var/www/clients/templates/default/downloads.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/pageheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['downloadstitle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="searchbox">
    <form method="post" action="downloads.php?action=search">
        <div class="input-append">
            <input type="text" name="q" value="<?php if ($this->_tpl_vars['q']): ?><?php echo $this->_tpl_vars['q']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['downloadssearch']; ?>
<?php endif; ?>" class="input-medium appendedInputButton" onfocus="if(this.value=='<?php echo $this->_tpl_vars['LANG']['downloadssearch']; ?>
')this.value=''" /><button type="submit" class="btn btn-warning"><?php echo $this->_tpl_vars['LANG']['search']; ?>
</button>
        </div>
    </form>
</div>

<p><?php echo $this->_tpl_vars['LANG']['downloadsintrotext']; ?>
</p>

<br />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['downloadscategories'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="row">
<div class="control-group">
<?php $_from = $this->_tpl_vars['dlcats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dlcat']):
?>
    <div class="col4">
        <div class="internalpadding">
            <img src="images/folder.gif" /> <a href="<?php if ($this->_tpl_vars['seofriendlyurls']): ?>downloads/<?php echo $this->_tpl_vars['dlcat']['id']; ?>
/<?php echo $this->_tpl_vars['dlcat']['urlfriendlyname']; ?>
<?php else: ?>downloads.php?action=displaycat&amp;catid=<?php echo $this->_tpl_vars['dlcat']['id']; ?>
<?php endif; ?>" class="fontsize2"><strong><?php echo $this->_tpl_vars['dlcat']['name']; ?>
</strong></a> (<?php echo $this->_tpl_vars['dlcat']['numarticles']; ?>
)<br />
            <?php echo $this->_tpl_vars['dlcat']['description']; ?>

        </div>
    </div>
<?php endforeach; endif; unset($_from); ?>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template'])."/subheader.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['LANG']['downloadspopular'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_from = $this->_tpl_vars['mostdownloads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['download']):
?>
<div class="row">
    <?php echo $this->_tpl_vars['download']['type']; ?>
 <a href="<?php echo $this->_tpl_vars['download']['link']; ?>
" class="fontsize2"><strong><?php echo $this->_tpl_vars['download']['title']; ?>
<?php if ($this->_tpl_vars['download']['clientsonly']): ?> <img src="images/padlock.gif" alt="Login Required" /><?php endif; ?></strong></a><br />
    <?php echo $this->_tpl_vars['download']['description']; ?>
<br />
    <span class="lighttext"><?php echo $this->_tpl_vars['LANG']['downloadsfilesize']; ?>
: <?php echo $this->_tpl_vars['download']['filesize']; ?>
</span>
</div>
<?php endforeach; endif; unset($_from); ?>

<br />
<br />
<br />