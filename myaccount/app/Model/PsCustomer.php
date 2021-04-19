<?php

class PsCustomer extends AppModel{
    
    var $name = 'PsCustomer';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "customer";
    var $primaryKey = "id_customer";
    
    public $hasOne = array(
		'PsCustomerGroup' => array(
			'className' => 'PsCustomerGroup',
			'foreignKey' => 'id_customer'
		)
	);
}
?>
