<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tbladmin extends AppModel{
    var $name = 'Tbladmin';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    public $validate=array(
        'username'=>array('rule'=>'notEmpty'),
        'password'=>array('rule'=>'notEmpty')
    );
}
?>
