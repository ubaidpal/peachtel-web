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
$cakeDescription = __d('cake_dev', 'PeachTEL ');
?>
<html lang="<?= $lang ?>" xmlns="http://www.w3.org/1999/xhtml">
    <head><?php echo $this->Html->charset(); ?>
        <title><?php echo $cakeDescription ?>:<?php echo $title_for_layout; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="<?= $lang ?>" />
        <?php
            echo $this->Html->meta('icon');

            echo $this->Html->css(array('all', 'reyazs', 'trunking-css'));
            echo $this->Html->script(array('all', 'jquery.min', 'jquery-custom.min', 'tiny_mce/tiny_mce', 'selectToUISlider.jQuery', 'jquery.validate'));

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
            $homeActions =  array(
                'adminDashboard', 'admin', 'activity_log',
                'new_account', 'new_customers', 'pending_orders',
                'port', 'sale_agents', 'inventory',
                'client_list', 'e911_calls', 'tax_report',
                'adwords', 'revenue_report', 'agent_report',
                'cnam_lookup'
            );

            $db_active = in_array($this->params['action'], $homeActions) ? 'nav active' : "nav";
            $b_active = $this->params['action'] == 'billing' ? 'nav active' : "nav";
            $p_active = $this->params['action'] == 'pbx' ? 'nav active' : "nav";
            $pr_active = $this->params['action'] == 'provisioning' ? 'nav active' : "nav";
            $t_active = $this->params['action'] == 'trunking' ? 'nav active' : "nav";
            $st_active = $this->params['action'] == 'store' ? 'nav active' : "nav";
            $su_active = $this->params['controller'] == 'support' ? 'nav active' : "nav";
            $n_active = $this->params['action'] == 'notes' ? 'nav active' : "nav";
            $q_active = $this->params['action'] == 'quote_tool' ? 'nav active' : "nav";

            $clientDetails = $this->Session->read("clientDetails");
            //print_r($b_active); exit;
//        $list = array(
//            $this->Html->link('Billling', array('action' => 'billing'), array("class" => "nav active",)),
//            $this->Html->link('PBX', array('action' => 'pbx'), array("class" => "sub_menu_item",)),
//            $this->Html->link('Provisioning', array('action' => 'provisioning'), array("class" => "sub_menu_item", "style" => $pr_active)),
//            $this->Html->link('Trunking', array('action' => 'trunking'), array("class" => "sub_menu_item", "style" => $t_active)),
//            $this->Html->link('Store', array('action' => 'store'), array("class" => "sub_menu_item", "style" => $st_active)),
//            $this->Html->link('Support', array('action' => 'support'), array("class" => "sub_menu_item", "style" => $su_active)),
//            $this->Html->link('Notes', array('action' => 'notes'), array("class" => "sub_menu_item", "style" => $n_active)),
//            $this->Html->link('Quotes', array('action' => 'quotes'), array("class" => "sub_menu_item", "style" => $q_active)),
//        );
//        echo $this->Html->nestedlist($list, array('id' => 'mainNav'), array("class" => "nav"));
            ?>
            <div id="sidebar">

                <ul id="mainNav">
                    <li  class="<?php echo $db_active; ?>">
                        <span class="icon-home"></span>
                        <?php echo $this->Html->link(__('Home'), array('action' => '/')); ?>
                    </li>

                    <?php if ($clientDetails != null) { ?>
                        <li  class="<?php echo $b_active; ?>">
                            <span class="icon-chart"></span>
                            <?php echo $this->Html->link('Billling', array('controller' => 'admintools', 'action' => 'billing')); ?>
                        </li>

                        <li  class="<?php echo $p_active; ?>">
                            <span class="icon-layers"></span>
                            <?php echo $this->Html->link('PBX', array('controller' => 'admintools', 'action' => 'pbx')); ?>
                        </li>

                        <li  class="<?php echo $pr_active; ?>">
                            <span class="icon-aperture"></span>
                            <?php echo $this->Html->link('Provisioning', array('controller' => 'admintools', 'action' => 'provisioning')); ?>
                        </li>

                        <li  class="<?php echo $t_active; ?>">
                            <span class="icon-article"></span>
                            <?php echo $this->Html->link('Trunking', array('controller' => 'admintools', 'action' => 'trunking')); ?>
                        </li>

                        <li  class="<?php echo $st_active; ?>"  style="display: none;">
                            <span class="icon-equalizer"></span>
                            <?php echo $this->Html->link('Store', array('controller' => 'admintools', 'action' => 'store')); ?>
                        </li>

                        <li  class="<?php echo $su_active; ?>">
                            <span class="icon-info"></span>
                            <?php echo $this->Html->link('Support', array('controller' => 'support', 'action' => '/')); ?>
                        </li>

                        <li class="<?php echo $n_active; ?>">
                            <span class="icon-comment-stroke"></span>
                            <?php echo $this->Html->link('Notes', array('controller' => 'admintools', 'action' => 'notes')); ?>
                        </li>

                        <li class="<?php echo $q_active; ?>">
                            <span class="icon-left-quote"></span>
                            <?php echo $this->Html->link('Quotes', array('controller' => 'quotes', 'action' => 'quote_tool')); ?>
                        </li>
                    <?php } ?>

                </ul>
                <div class="grid-8">
                    <?php
                    if ($this->Session->read("clientDetails") != null) {

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
                        ?></label>&nbsp;[<a href="javascript:;" id="changestatus">change</a>]
                            <div id="status_loader"  style="text-align:center; position:absolute; display: none; right: 7%;   top: 93%">
                                <?php echo $this->Html->image('/images/loaders/facebook.gif'); ?>
                            </div>
                        <br /><br />
                        <li style="list-style: none !important;"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/myaccount/users/billing" target="_blank">Login as Client</a></li>
                        <li style="list-style: none !important;"><?php echo $this->Html->link('Add Note', array('action' => 'notes')); ?></li>

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
                    <?php if($clientDetails) : ?>
                    <div id="customer_detail_pane"><?php echo "Customer Name: ".$clientDetails['CLIENT']['FIRSTNAME']." ".$clientDetails['CLIENT']['LASTNAME']." | Email: ".$clientDetails['CLIENT']['EMAIL']." | Account ID: ".$clientDetails['CLIENT']['ID']; ?></div>
                    <?php endif; ?>
                    <li ><?php echo $this->Html->link('Logout', array('action' => 'logout')); ?></li>
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
        function changeAccountStatus(c_status){
            if(String.trim(c_status)=="Inactive"){
                c_status="Active";
            }
            else{
                c_status="Inactive"
            }
            jQuery.ajax({
                url:"<?php echo $this->base ?>/admintools/changeClientStatusInWHMCS",
                data:{
                    status:c_status
                },
                type:'POST',
                dataType:'json',
                beforeSend:function(){

                    jQuery('#status_loader').show();
                    jQuery('#status_loader1').show();

                },
                success:function(response){
                    jQuery('#status_loader').hide();
                     jQuery('#status_loader1').hide();
                    console.log(response);
                    if(response.done){

                        $('#status').text(c_status);
                        $('#status2').text(c_status);
                    }

                },
                failure:function(){
                    alert(" i can not do it. you may not be on network. ")
                }
            });
        }
    </script>
</html>
