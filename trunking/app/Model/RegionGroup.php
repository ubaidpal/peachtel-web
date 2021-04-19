<?php

class RegionGroup extends AppModel {
    
    var $name = 'RegionGroup';
    var $actsAs = array('Containable');
    var $useTable = "region_group";
    
}