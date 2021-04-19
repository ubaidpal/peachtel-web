<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class QbAdminProduct extends AppModel{
    
    var $name = 'QbAdminProduct';
    var $actsAs = array('Containable');
    var $useTable = "QB_admin_product";
    var $useDbConfig = "voiplion";

}
?>