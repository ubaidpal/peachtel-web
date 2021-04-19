<?php

class PackageTermCodeGroup extends AppModel{
    
    var $name = 'PackageTermCodeGroup';
    var $actsAs = array('Containable');
    var $useTable = "pkg_term_code_group";
    
    public $belongsTo = array(

	);
    
    public $hasOne = array(

    );
    
}