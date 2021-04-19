<?php

class Region extends AppModel {
    
    var $name = 'Region';
    var $actsAs = array('Containable');
    var $useTable = "region";
    
}