<?php

class PsImage extends AppModel{
    
    var $name = 'PsImage';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "image";
    
    
}
?>
