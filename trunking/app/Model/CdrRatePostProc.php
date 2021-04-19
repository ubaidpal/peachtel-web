<?php

class CdrRatePostProc extends AppModel{
    
    var $name = 'CdrRatePostProc';
    var $actsAs = array('Containable');
    var $useTable = "cdr_rate_postproc";
    
    public $belongsTo = array(
        'Cdr' => array(
			'className' => 'Cdr',
			'foreignKey' => 'cdr_id'
		)
	);
}