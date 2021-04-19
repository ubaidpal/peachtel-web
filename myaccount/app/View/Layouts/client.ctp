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
        <title><?php echo $cakeDescription ?>:<?php echo $title_for_layout; ?>
        </title><?php
echo $this->Html->meta('icon');

echo $this->Html->css(array('all', 'reyazs', 'trunking-css', 'jquery.treeview'));
echo $this->Html->script(array('all', 'jquery.min', 'jquery-custom.min', 'selectToUISlider.jQuery', 'jquery.validate', 'jquery.validate_1', 'jquery.treeview','jquery.treeview.edit'));

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
                $db_active = $this->params['action'] == 'dashboard' ? 'nav active' : "nav";
                $b_active = $this->params['action'] == 'billing' ? 'nav active' : "nav";
                $p_active = $this->params['action'] == 'pbx' ? 'nav active' : "nav";
                $pr_active = $this->params['action'] == 'provisioning' ? 'nav active' : "nav";
                $t_active = $this->params['action'] == 'trunking' ? 'nav active' : "nav";
                $st_active = $this->params['action'] == 'store' ? 'nav active' : "nav";
                $su_active = $this->params['action'] == 'support' ? 'nav active' : "nav";
                $q_active = $this->params['action'] == 'quote_tool' ? 'nav active' : "nav";
            ?>
            <div id="sidebar">

                <ul id="mainNav">
                   <!-- <li  class="<?php echo $db_active; ?>">
                        <span class="icon-home"></span>
                        <?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'dashboard')); ?>
                    </li>-->

                    <li  class="<?php echo $b_active; ?>">
                        <span class="icon-info"></span>
                        <?php echo $this->Html->link('Billling', array('controller' => 'users', 'action' => 'billing')); ?>
                    </li>

                    <li  class="<?php echo $p_active; ?>">
                        <span class="icon-layers"></span>
                        <?php echo $this->Html->link('PBX', array('controller' => 'users', 'action' => 'pbx')); ?>
                    </li>

                    <li  class="<?php echo $pr_active; ?>">
                        <span class="icon-list"></span>
                        <?php echo $this->Html->link('Provisioning', array('controller' => 'users', 'action' => 'provisioning')); ?>
                    </li>

                    <li  class="<?php echo $t_active; ?>">
                        <span class="icon-compass"></span>
                        <?php echo $this->Html->link('Trunking', array('controller' => 'users', 'action' => 'trunking')); ?>
                    </li>

                    <li  class="<?php echo $st_active; ?>"  style="display: none;">
                        <span class="icon-equalizer"></span>
                        <?php echo $this->Html->link('Store', array('controller' => 'users', 'action' => 'store')); ?>
                    </li>

                    <li  class="<?php echo $su_active; ?>">
                        <span class="icon-chart"></span>
                        <?php echo $this->Html->link('Support', array('controller' => 'users', 'action' => 'support')); ?>
                    </li>

                    <li class="<?php echo $q_active; ?>">
                        <span class="icon-map-pin-fill"></span>
                        <?php echo $this->Html->link('Quotes', array('controller' => 'quotes', 'action' => 'quote_tool?admin=1')); ?>
                    </li>

                </ul>

                <!--

                Currently disabled. This contains the user details of user.

                <div class="grid-8">
                    <?php
                    if ($this->Session->read("clientDetails") != null) {

                        $clientDetails = $this->Session->read("clientDetails");
                        if (isset($clientDetails['CLIENT']))
                            $cdetail = $clientDetails['CLIENT'];
                        ?>
                        <div class="box_side">
                            <h3>Client Info</h3>

                            Customer Name : <?php
                    if (isset($cdetail['FIRSTNAME'])): echo $cdetail['FIRSTNAME'] . " " . $cdetail['LASTNAME'];
                    endif;
                        ?> </br>
                            Email : <?php
                        if (isset($cdetail['EMAIL'])): echo $cdetail['EMAIL'];
                        endif;
                        ?> </br>
                            Account ID :  <?php
                        if (isset($cdetail['ID'])): echo $cdetail['ID'];
                        endif;
                        ?> </br>
                            Last login : <?php
                        if (isset($cdetail["LASTLOGIN"])): echo $cdetail["LASTLOGIN"];
                        endif;
                        ?> </br>
                            Account Status :  <label id='status'><?php
                        if (isset($cdetail["STATUS"])): echo $cdetail["STATUS"];
                        endif;
                        ?></label>


                        </div>
                    <?php } ?>
                </div><!--Grid 8-->

            </div> <!-- #sidebar -->
            <!--content-->
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
            <!--content-->
            <div id="topNav">
                <ul>
                    <div id="customer_detail_pane"><?php echo "Customer Name: ".$clientDetails['CLIENT']['FIRSTNAME']." ".$clientDetails['CLIENT']['LASTNAME']." | Email: ".$clientDetails['CLIENT']['EMAIL']." | Account ID: ".$clientDetails['CLIENT']['ID']; ?></div>
                    <li><?php echo $this->Html->link('Account Information', array('controller' => 'users', 'action' => 'account_information')); ?></li>
                    <li><?php echo $this->Html->link('Logout', array('action' => 'logout')); ?></li>
                    <li style="color: white" id="time">UNX Time</li>
                </ul>
            </div> <!-- #topNav -->
        </div><!-- #wrapper -->
    </body>
    <script type="text/javascript">
        function showTime(){
            var currentTime=new Date();
            var hour=currentTime.getHours();
            if(hour>12)
                document.getElementById('time').innerHTML=hour-12+" : "+currentTime.getMinutes()+" PM";
            else
                document.getElementById('time').innerHTML=hour+" : "+currentTime.getMinutes()+" AM";
        }
        showTime();
        setInterval(showTime,30000);
        $('#changestatus').click(function(){
            changeAccountStatus( $('#status').text());
        });
        $('#changestatus2').click(function(){
            changeAccountStatus($('#status2').text());
        });

    </script>
</html>
