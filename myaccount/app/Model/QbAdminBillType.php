<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class QbAdminBillType extends AppModel{
    
    var $name = 'QbAdminBillType';
    var $actsAs = array('Containable');
    var $useTable = "QB_admin_bill_type";
    var $useDbConfig = "voiplion";

}
?>