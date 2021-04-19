<?php

class PsCustomerGroup extends AppModel{
    
    var $name = 'PsCustomerGroup';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "customer_group";
    var $primaryKey = "id_customer";
}
?>
