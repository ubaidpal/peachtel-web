<?php
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

        echo $this->Html->css(array('all', 'reyazsStyle'));
        echo $this->Html->script('all');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="webcontainer">
            <div id="myHeader">
                <?php echo $this->Html->link("Logout", array('action' => 'logout'), array("style" => "float: right", "class" => "menu_item")); ?>
                <h1 style="margin-top: 78px;font-size: 50px;">peachtel.com</h1>

            </div>
            <div class="homeSearch" style="font-size:20px; ">
                <?php echo $this->Html->link("Home", array('action' => 'adminDashboard'), array("style" => "float:left;margin-top:1px;color:black", )); ?>
                <?php echo $this->Form->create('admintool', array('action' => 'billing'), array('div' => false)); ?>
                <span style="margin-left: 28px">Search >></span>
                <select name="accIdentifier" onchange="changeFor(this);">
                    <option value="id">Account ID</option>
                    <option value="comname">Company Name</option>
                    <option value="CTID/Hostname">CTID/Hostname</option>
                    <option value="DIDNumber">DID Number</option>
                    <option value="email">Email</option>
                    <option value="LastName">Last Name</option>
                    <option value="TrunkID">Trunk ID</option>
                    <option value="Quote">Quote</option>
                </select>
                <span style="margin-left: 10px">for</span>
                <select name="query" id="for">
                </select>
                <?php
                echo " - " . $this->form->button('Go', array('type' => 'submit', 'div' => false,'class'=>'btn btn-small btn-gray'));
                ?>

            </div>
            <div id="contendt">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <?php //echo $this->element('sql_dump');       ?>
    </body>
    <script type="text/javascript">
        var emails=new Array();
        var ids=new Array();
        var forlist=document.getElementById('for');
<?php
$i = 0;
//print_r($clients); exit;
foreach ($clients as $clent):
    ?>
            ids[<?php echo $i; ?>] = "<?php echo $clent['id']; ?>" ;//exit;
            emails[<?php echo $i++; ?>]= "<?php echo $clent['email']; ?>";
    <?php
endforeach;
?>

    for(var i=1; i<ids.length; i++){
        var forlistOption = document.createElement("option");//create new option
        forlistOption.value = ids[i];//set option value
        forlistOption.text = ids[i];//set option display text
        forlist.options.add(forlistOption);//add created option to select box.
    }
    function changeFor(list){
        if(forlist.options.length!=0){
            for(var index=forlist.options.length-1;index>=0;forlist.remove(index--));
        }
        if(list[list.selectedIndex].value=='clientid'){
            for(var i=1; i<ids.length; i++){
                var forlistOption = document.createElement("option");//create new option
                forlistOption.value = ids[i];//set option value
                forlistOption.text = ids[i];//set option display text
                forlist.options.add(forlistOption);//add created option to select box.
            }
        }
        else if(list[list.selectedIndex].value=='comname'){

        }
        else if(list[list.selectedIndex].value=='CTID/Hostname'){

        }
        else if(list[list.selectedIndex].value=='DIDNumber'){

        }
        else if(list[list.selectedIndex].value=='email'){
            for(var i=1; i<emails.length; i++){
                var forlistOption = document.createElement("option");//create new option
                forlistOption.value = emails[i];//set option value
                forlistOption.text = emails[i];//set option display text
                forlist.options.add(forlistOption);//add created option to select box.
            }
        }
        else if(list[list.selectedIndex].value=='LastName'){

        }
        else if(list[list.selectedIndex].value=='TrunkID'){

        }
        else if(list[list.selectedIndex].value=='Quote'){

        }
    }
    </script>
</html>
