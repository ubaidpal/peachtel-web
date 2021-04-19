<?php

class Subscriber extends AppModel{
    
    var $name = 'Subscriber';
    var $actsAs = array('Containable');
    var $useTable = "subscriber";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}