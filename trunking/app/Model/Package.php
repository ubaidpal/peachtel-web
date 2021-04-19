<?php

class Package extends AppModel{
    
    var $name = 'Package';
    var $actsAs = array('Containable');
    var $useTable = "pkg";
    
    public $belongsTo = array(

	);
    
    public $hasOne = array(

    );
    
}