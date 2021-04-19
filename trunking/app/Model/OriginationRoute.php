<?php

class OriginationRoute extends AppModel{
    
    var $name = 'OriginationRoute';
    var $actsAs = array('Containable');
    var $useTable = "orig_route";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}

?>