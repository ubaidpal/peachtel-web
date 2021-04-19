<?php /* Smarty version 2.6.26, created on 2012-12-07 07:48:49
         compiled from viewemail.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->_tpl_vars['LANG']['clientareaemails']; ?>
 - <?php echo $this->_tpl_vars['companyname']; ?>
</title>

    <link href="templates/<?php echo $this->_tpl_vars['template']; ?>
/css/bootstrap.css" rel="stylesheet">
    <link href="templates/<?php echo $this->_tpl_vars['template']; ?>
/css/whmcs.css" rel="stylesheet">

  </head>

  <body class="popupwindow">

<h2><?php echo $this->_tpl_vars['subject']; ?>
</h2>

<div class="popupcontainer"><?php echo $this->_tpl_vars['message']; ?>
</div>

<p class="textcenter"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['closewindow']; ?>
" class="btn btn-primary" onclick="window.close()" /></p>

  </body>
</html>