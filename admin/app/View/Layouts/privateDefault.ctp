<?php
//debug('in layotu'); exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
$cakeDescription = __d('cake_dev', 'PeachTEL');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><?php echo $this->Html->charset(); ?>
        <title><?php echo $cakeDescription ?>:<?php echo $title_for_layout; ?></title>
        <?php
            echo $this->Html->meta('icon');

            echo $this->Html->css(array('all', 'reyazs', 'trunking-css'));
            echo $this->Html->script(array('all', 'jquery.min', 'jquery-custom.min'));

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="wrapper">

            <div id="header" style="height: 135px;">
                <?php echo $this->Html->image('../images/gallery/peachtel.png', array('style' => 'width: 225px; position:absolute; top: 40; left: 7')); ?>
            </div>

            <?php
            $db_active = $this->params['action'] == 'adminDashboard' ? 'nav active' : "nav";
            $i_active = $this->params['action'] == 'import' ? 'nav active' : "nav";
            $p_active = $this->params['action'] == 'itaki_network_product' ? 'nav active' : "nav";
            ?>
            <div id="sidebar">

                <ul id="mainNav">
                    <li  class="<?php echo $db_active; ?>">
                        <span class="icon-home"></span>
                        <?php echo $this->Html->link(__('Home'), '/'); ?>
                    </li>
                    <li  class="<?php echo $i_active; ?>">
                        <span class="icon-map-pin-fill"></span>
                        <?php echo $this->Html->link('Import CSV', array('action' => 'import')); ?>
                    </li>
                    <li  class="<?php echo $p_active; ?>">
                        <span class="icon-map-pin-fill"></span>
                        <?php echo $this->Html->link('Add Prestashop Products', array('action' => 'itaki_network_product')); ?>
                    </li>

                </ul>

            </div> <!-- #sidebar -->
            <!--content-->
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
            <!--content-->
        </div><!-- #wrapper -->
    </body>
</html>
