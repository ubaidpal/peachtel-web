<?php

class CreditControll extends AppModel{
    
    var $name = 'CreditControll';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_credit_ctrl";
    var $primaryKey = 'customer_bg_id';
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
        'MasterBillingGroup' => array(
			'className' => 'MasterBillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}