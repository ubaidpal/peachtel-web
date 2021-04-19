<?php

class SourceGateway extends AppModel{
    
    var $name = 'SourceGateway';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_src_gw";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}