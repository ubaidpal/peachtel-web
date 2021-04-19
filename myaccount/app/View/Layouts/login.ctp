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

        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array('default/login', 'default/alljs', 'jquery.treeview'));
        echo $this->Html->script(array('jquery.min', 'jquery-custom.min', 'selectToUISlider.jQuery', 'jquery.validate_1', 'jquery.treeview','jquery.treeview.edit'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        $h_active = ($this->action == 'login') ? 'selected' : '';
        $o_active = (isset($page) && $page == 'overview') ? 'selected' : '';
        $dc_active = (isset($page) && $page == 'datacenter-locations') ? 'selected' : '';
        $q_active = ($this->action == 'quote_tool') ? 'selected' : '';
        $c_active = (isset($page) && $page == 'contact_us') ? 'selected' : '';
        ?>
        <script>
            $(function() {
                $("#search").live('click', function() {
                    $("#search").animate({
                        width: "600px"
                    }, 800);
                }).live('blur', function() {
                    $("#search").animate({
                        width: "156px"
                    }, 300);
                });

                $("#topBtn").live('click', function() {
                    $('html').animate({
                        scrollTop: '0'
                    }, 800);
                });

                var currentTime = new Date();
                var hour = currentTime.getHours();
                if(hour > 12)
                    $('#gettime').html(hour - 12 + " : " + currentTime.getMinutes() + " PM");
                else
                    $('#gettime').html(hour + " : " + currentTime.getMinutes() + " AM");
            });
        </script>
    </head>
    <body>
        <div id="content">
            <div id="header">
                <div id="main_nav">
                    <div id="title_login_holder">
                        <label></label>
                        <?php $client = $this->Session->read('clientDetails'); ?>
                        <?php if(empty($client)): ?>
                        <label><a href="javascript:void(0);" id="login">Customer Sign In / Sign Up</a></label>
                        <?php else: ?>

                        <label style="color: #fff; font-size: 11px; font-weight: bold;">
                                <?php echo "Customer Name: ".$client['CLIENT']['FIRSTNAME']." ".$client['CLIENT']['LASTNAME']." | Email: ".$client['CLIENT']['EMAIL']." | Account ID: ".$client['CLIENT']['ID'];; ?>&nbsp;&nbsp;
                                <?php echo $this->Html->link('Account Information', array('controller' => 'users', 'action' => 'account_information')); ?>
                                <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
                                <li style="color: white; float: right; margin-left: 10px; list-style: none;" id="gettime">UNX Time</li>
                        </label>
                        <?php endif; ?>
                    </div>
                    <ul>
                        <li class="<?php echo $h_active; ?>"><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/">Home</a></li>
                        <!--<li class="<?php echo $dc_active; ?>"><a href="<?php echo $this->base?>/datacenter-locations.html">PBX Hosting & Datacenter Locations</a></li>-->
                        <li class="<?php echo $q_active; ?>"><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/quotes/quote_tool">Buy (Price) a Phone System</a></li>
                        <li><a href="https://devweb.peachtel.net/itakishop/">Shop for Equipment</a></li>
                        <!--<li class="<?php echo $o_active; ?>"><a href="<?php echo $this->base?>/overview.html">Overview</a></li>-->
                        <!--<li><a href="<?php echo $this->base?>/faqs.html">FAQs</a></li>-->
                        <li class="<?php echo $c_active; ?>"><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/contact_us.html">Contact Us</a></li>
                        <!--<li>
                            <?php if(empty($client)): ?>
                                <a href="javascript:void(0);" id="login">My Account</a>
                            <?php else: ?>
                                <a href="<?php echo $this->base ?>/users/billing">My Account</a>
                            <?php endif; ?>
                        </li>-->
                    </ul>
                </div>
            </div>
            <div id="container" style="position: relative;">
                <div id="logo_search_holder">
                    <?php echo $this->Html->image('../images/gallery/peachtel.png', array('style' => array('height: 55px;'))); ?>
                    <!--<div id="search_holder">
                        <input type="text" id="search" placeholder="Search Here..." /><input type="submit" value="Search" />
                    </div>-->
                </div>
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <div id="footer-content">
                    <label>2013 © <span>PeachTEL.</span> All rights reserved.</label>
                    <label style="float: right;">
                        <a href="javascript:void(0);" id="topBtn">Back to top</a>
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <?php
            echo $this->element('loginform');
            echo $this->element('loginformAjax');
            echo $this->element('regformAjax');
        ?>
    </body>
</html>
