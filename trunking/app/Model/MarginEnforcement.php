<?php

class MarginEnforcement extends AppModel{
    
    var $name = 'MarginEnforcement';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_vendor_term_route_pref";
    var $primaryKey = 'customer_bg_id';
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}