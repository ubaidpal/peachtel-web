<?php

class BillingGroup extends AppModel{
    
    var $name = 'BillingGroup';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg";
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id'
		),
        'MasterBillingGroup' => array(
			'className' => 'MasterBillingGroup',
			'foreignKey' => 'customer_bg_billing_target_id'
		),
	);
    
    var $hasOne = array(
		'FraudCtrlPref' => array(
			'className' => 'FraudCtrlPref',
			'foreignKey' => 'customer_bg_id'
		)
	);
    
    var $hasMany = array(
        'Subscriber' => array(
			'className' => 'Subscriber',
			'foreignKey' => 'customer_bg_id'
		),
        'OriginationRoute' => array(
			'className' => 'OriginationRoute',
			'foreignKey' => 'customer_bg_id'
		),
        'DestinationGateway' => array(
			'className' => 'DestinationGateway',
			'foreignKey' => 'customer_bg_id'
		)
	);
    
    public function findCustomerBgs($id) {
        return $this->find('list', array(
            'conditions' => array(
                'customer_id' => $id
            ),
            'fields' => array('id', 'descr')
        ));
    }
}