<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Activity extends AppModel{
    
    var $name = 'Activity';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";
}
?>