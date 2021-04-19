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

        echo $this->Html->css(array('all'));
        echo $this->Html->script('all');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body bgcolor="blue">
        <div id="webcontainer">
            <div id="header">
                <h1>peachtel.com</h1>
            </div>
            <div class="menu">
                <h3 class="upper_menu">
                    <ul>
                        <a href="#"><li class="menu_item">HOME</li></a>
                        <a href="#" ><li class="menu_item">ABOUT US</li></a>
                        <a href="#"><li class="menu_item">QUOTES</li></a>
                        <a href="#"><li class="menu_item">CONTACT US</li></a>
                        <li style="margin-left: 458px;margin-right: 0px;" class="menu_item"></li>
                        <!--                        <a href="#"><li class="menu_item" style="border-right: 0px">LOGIN</li></a>-->
                    </ul>
                </h3>
                <h4 class="sub_menu">

                    <?php
                    $b_active = $this->params['action'] == 'billing' ? 'background-color: gray;' : "";
                    $p_active = $this->params['action'] == 'pbx' ? 'background-color: gray;' : "";
                    $pr_active = $this->params['action'] == 'provisioning' ? 'background-color: gray;' : "";
                    $t_active = $this->params['action'] == 'trunking' ? 'background-color: gray;' : "";
                    $st_active = $this->params['action'] == 'store' ? 'background-color: gray;' : "";
                    $su_active = $this->params['action'] == 'support' ? 'background-color: gray;' : "";

                    $list = array(
                        $this->Html->link('Billling', array('action' => 'billing'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('PBX', array('action' => 'pbx'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('Provisioning', array('action' => 'provisioning'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('Trunking', array('action' => 'trunking'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('Store', array('action' => 'store'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('Support', array('action' => 'support'), array("class" => "sub_menu_item")) . "|",
                        $this->Html->tag('span', 'logged in as', array("class" => "sub_menu_item")) . "|",
                        $this->Html->link('logout', array('action' => 'logout'), array("class" => "sub_menu_item")),
                    );
                    echo $this->Html->nestedlist($list);
                    ?>
                    <!--                    <ul style="color:white;">
                                            <a href="<?php $this->base; ?>/voiplion/users/billing"><li class="sub_menu_item" style="<?php echo $b_active; ?>" >Billing</li></a>|
                                            <a href="<?php $this->base; ?>/voiplion/users/pbx"><li class="sub_menu_item" style="<?php echo $p_active; ?>">PBX</li></a>|
                                            <a href="<?php $this->base; ?>/voiplion/users/provisioning"><li class="sub_menu_item" style="<?php echo $pr_active; ?>">Provisioning</li></a>|
                                            <a href="<?php $this->base; ?>/voiplion/users/trunking"><li class="sub_menu_item" style="<?php echo $t_active; ?>">Trunking</li></a>|
                                            <a href="<?php $this->base; ?>/voiplion/users/store"><li class="sub_menu_item" style="<?php echo $st_active; ?>">Store</li></a>|
                                            <a href="<?php $this->base; ?>/voiplion/users/support"><li class="sub_menu_item" style="<?php echo $su_active; ?>">Support</li></a>
                                            <li class="sub_menu_item" style="margin-left: 250px;margin-right: -18px;" ><i>logged in as </i><?php echo $_SESSION['username'] ?></li>
                                            <a href="<?php $this->base; ?>/voiplion/admintools/logout"><li class="sub_menu_item">logout</li></a>
                                        </ul>-->
                </h4>
            </div>
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
            </div>
        </div>
        <?php //echo $this->element('sql_dump');  ?>
    </body>
</html>
