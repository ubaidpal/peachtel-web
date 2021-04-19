<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblhosting extends AppModel{
    
    var $name = 'Tblhosting';
    var $actsAs = array('Containable');
    var $useTable = "tblhosting";
    var $useDbConfig = "whmcs";
}
?>

