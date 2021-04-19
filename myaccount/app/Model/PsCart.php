<?php

class PsCart extends AppModel{
    
    var $name = 'PsCart';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "cart";
    var $primaryKey = "id_cart";
    
    public $hasMany = array(
		'PsCartProduct' => array(
			'className' => 'PsCartProduct',
			'foreignKey' => 'id_cart'
		)
	);
	
	public function getPsCart($qid) {
		return $this->find('first', array('conditions' => array('quote_id' => $qid), 'contain' => array(
		            'PsCartProduct' => array(
		                'PsProduct' => array('fields' => 'price')
		            )
		        )));
	}
	
	public function saveCart($psUser, $devices, $qid) {
		$defaultCartValues['PsCart']  = array(
	    	'quote_id' => $qid,
	    	'id_shop_group' => 1,
	    	'id_shop' => 1,
	    	'id_carrier' => 0,
	     	'id_lang' => 1,
	    	'id_address_delivery' => 0,
	    	'id_address_invoice' => 0,
	     	'id_currency' => 1,
	    	'id_customer' => $psUser['PsCustomer']['id_customer'],
	      	'secure_key' => $psUser['PsCustomer']['secure_key'],
	 		'recyclable' => 1,
	    	'gift' => 0,
	     	'allow_seperated_package' => 0,
	     	'date_add' => date('Y-m-d H:i:s'),
	     	'date_upd' => date('Y-m-d H:i:s')
		);
	                    
		if(!empty($devices)) {
			foreach($devices['product']['products'] as $device) {
				$defaultCartValues['PsCartProduct'][] = array(
	            	'id_product' => $device['id'],
	             	'id_address_delivery' => 0,
	            	'id_shop' => 1,
	              	'id_product_attribute' => 0,
	               	'quantity' => $device['quantity'],
	               	'date_add' => date('Y-m-d')
				);
	
			}
		}
		
		return $this->saveAll($defaultCartValues);
	}
}

?>