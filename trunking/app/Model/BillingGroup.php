<?php

class BillingGroup extends AppModel{
    
    var $name = 'BillingGroup';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg";
    
    public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id'
		)
	);
    
    var $hasOne = array(
		'CreditControll' => array(
			'className' => 'CreditControll',
			'foreignKey' => 'customer_bg_id'
		)
	);
    
    var $hasMany = array(
		'OriginationRoute' => array(
			'className' => 'OriginationRoute',
			'foreignKey' => 'customer_bg_id'
		)
	);
}