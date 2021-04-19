<?php

class PsManufacturer extends AppModel{
    
    var $name = 'PsManufacturer';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "manufacturer";
    
    
}
?>
