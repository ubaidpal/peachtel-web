<?php

class FraudCtrlPref extends AppModel {
    
    var $name = 'FraudCtrlPref';
    var $actsAs = array('Containable');
    var $useTable = "customer_bg_fraud_ctrl_pref";
    var $primaryKey = 'customer_bg_id';
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
		'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
}

?>