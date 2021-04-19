<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Itakinet: CSRP Web Control');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
        echo $this->Html->script(array('jquery-1.8.2.min', 'jquery-ui-1.9.1.custom.min'));
        echo $this->Html->css(array('itakinet', 'jquery-ui-1.8.22.custom'));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, '/', array('style' => 'font-size: 24px !important;')); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
            <div class="main_content_holder">
                <div id="content">	

                    <div id="contentHeader">
                        <h1><?php echo $this->name; ?></h1>
                    </div> <!-- #contentHeader -->

                    <div class="container">

                        <div class="trunking_main_holder">

                            <div class="trunking_content">
                                <?php echo $this->element('trunking_nav', array('header' => $this->name)); ?>
                                <div class="trunk_main_cont">
                                    <?php echo $this->fetch('content'); ?>
                                </div>
                            </div> <!-- .box -->
                        </div> <!-- .trunking_main_holder -->

                    </div> <!-- .container -->

                </div> <!-- #content -->
            </div>
		</div>
		<div id="footer">
            <div></div>
		</div>
	</div>
</body>
</html>