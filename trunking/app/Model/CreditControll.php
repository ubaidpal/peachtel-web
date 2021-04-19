<?php

class CreditControll extends AppModel{
    
    var $name = 'CreditControll';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_credit_ctrl";
    var $primaryKey = 'customer_bg_id';
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}