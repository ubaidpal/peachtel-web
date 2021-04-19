<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Nextusa extends AppModel {
    var $name = 'Nextusa';
    var $actsAs = array('Containable');
    var $useTable = "nextusa";
    var $useDbConfig = "nextUsa";
    
    public function checkExisting($data) {
        $byProductName = $this->findByProductName($data[1]);
        $byPartNumber = $this->findByPartNumber($data[2]);

        
        if(!empty($byProductName['Nextusa'])) {
            return $byProductName['Nextusa']['id'];
        } else if(!empty($byPartNumber['Nextusa'])) {
            return $byPartNumber['Nextusa']['id'];
        } else {
            return '';
        }
    }
}
?>
