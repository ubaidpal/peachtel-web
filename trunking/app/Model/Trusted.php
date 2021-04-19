<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Trusted extends AppModel {
    var $name = 'Trusted';
    var $actsAs = array('Containable');
    var $useTable = "trusted";
}
?>
