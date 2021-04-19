<?php

class RegionCode extends AppModel {
    
    var $name = 'RegionCode';
    var $actsAs = array('Containable');
    var $useTable = "region_code";
    var $primaryKey = 'prefix';
}