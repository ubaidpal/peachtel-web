<?php

class OriginationRoute extends AppModel{
    
    var $name = 'OriginationRoute';
    var $actsAs = array('Containable');
    var $useTable = "orig_route";
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
    public $hasOne = array(
		'OriginationRouteCostDest' => array(
			'className' => 'OriginationRouteCostDest',
			'foreignKey' => 'orig_route_id'
		)
	);
}

?>