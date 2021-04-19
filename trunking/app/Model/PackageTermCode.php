<?php

class PackageTermCode extends AppModel{
    
    var $name = 'PackageTermCode';
    var $actsAs = array('Containable');
    var $useTable = "pkg_term_code";
    var $primaryKey = 'pkg_term_code_group_id';
    public $belongsTo = array(

	);
    
    public $hasOne = array(

    );
    
}