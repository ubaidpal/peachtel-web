<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Server extends AppModel{
    
    var $name = 'Server';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";

}
?>