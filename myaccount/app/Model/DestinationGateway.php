<?php

class DestinationGateway extends AppModel{
    
    var $name = 'DestinationGateway';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_dest_gw";
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}