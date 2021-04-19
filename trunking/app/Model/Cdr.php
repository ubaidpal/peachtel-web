<?php

class Cdr extends AppModel{
    
    var $name = 'Cdr';
    var $actsAs = array('Containable');
    var $useTable = "cdr";
    
    public $belongsTo = array(
        'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id'
		),
        'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
    
    public $hasOne = array(
        'CdrRate' => array(
			'className' => 'CdrRate',
			'foreignKey' => 'cdr_id'
		),
        'CdrRatePostProc' => array(
			'className' => 'CdrRatePostProc',
			'foreignKey' => 'cdr_id'
		)
    );
    
}