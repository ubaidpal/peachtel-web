<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TempItem extends AppModel {
    
    var $name = 'TempItem';
    var $actsAs = array('Containable');
    var $useTable = "temp_items";
    var $useDbConfig = "voiplion";
}
?>