<?php

class CdrRate extends AppModel{
    
    var $name = 'CdrRate';
    var $actsAs = array('Containable');
    var $useTable = "cdr_rate_static";
    
    public $belongsTo = array(
        'Cdr' => array(
			'className' => 'Cdr',
			'foreignKey' => 'cdr_id'
		)
	);
}