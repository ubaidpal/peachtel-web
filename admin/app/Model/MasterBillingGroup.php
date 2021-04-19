<?php

class MasterBillingGroup extends AppModel {
    
    var $name = 'MasterBillingGroup';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg";
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
            'conditions' => array('customer_bg_billing_target_id' => null)
		)
	);
    
    public $hasMany = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_billing_target_id'
		)
	);
    
    var $hasOne = array(
       		'CreditControll' => array(
                'className' => 'CreditControll',
                'foreignKey' => 'customer_bg_id'
		), 
    );
}