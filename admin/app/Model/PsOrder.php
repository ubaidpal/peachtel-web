<?php

class PsOrder extends AppModel{
    
    var $name = 'PsOrder';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "orders";
    var $primaryKey = "id_order";
    
}
?>
