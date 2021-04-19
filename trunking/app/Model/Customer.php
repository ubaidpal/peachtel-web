<?php

class Customer extends AppModel{
    
    var $name = 'Customer';
    var $actsAs = array('Containable');
    var $useTable = "customer";
    
    var $hasMany = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_id'
		)
	);
}