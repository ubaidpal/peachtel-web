<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class QbAdminDisplayType extends AppModel{
    
    var $name = 'QbAdminDisplayType';
    var $actsAs = array('Containable');
    var $useTable = "QB_admin_display_type";
    var $useDbConfig = "voiplion";

}
?>