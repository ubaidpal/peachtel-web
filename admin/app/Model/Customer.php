<?php

class Customer extends AppModel{
    
    var $name = 'Customer';
    var $actsAs = array('Containable');
    var $useTable = "customer";
    var $useDbConfig = "postgres";
    
    var $hasMany = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_id'
		),
        'Cdr' => array(
			'className' => 'Cdr',
			'foreignKey' => 'customer_id'
		),
	);

    var $hasOne = array(
       		'MasterBillingGroup' => array(
			'className' => 'MasterBillingGroup',
			'foreignKey' => 'customer_id',
            'conditions' => array('customer_bg_billing_target_id' => null)
		), 
    );
    
    public function findCustomerByName($clientTrunkID) {
        $customer = $this->find('first', array(
                        'conditions' => array('Customer.descr' => $clientTrunkID),
                        'contain' => array(
                                'MasterBillingGroup' => array(
                                    'BillingGroup' => array(
                                        'Subscriber',
                                        'FraudCtrlPref'
                                    ),
                                    'CreditControll'
                                ),
                                'Cdr'
                            )
                        )
                    );

        return $customer;
    }

}