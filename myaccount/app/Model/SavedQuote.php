<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SavedQuote extends AppModel{
    
    var $name = 'SavedQuote';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";
    
    public $hasOne = array(
		'PsCart' => array (
			'className' => 'PsCart',
			'foreignKey' => 'quote_id'
		)
	);
    
    public $hasMany = array(
		'WhmcsProduct' => array (
			'className' => 'WhmcsProduct',
			'foreignKey' => 'quote_id'
		)
	);
	
	public function getQuote($qid) {
		return $this->find('first', array(
	                'conditions' => array('id' => $qid),
	                'contain' => array(
	                    'PsCart' => array(
	                        'PsCartProduct' => array(
	                            'PsProduct' => array(
	                                'fields' => array('id_product', 'price'),
	                                'PsProductLang'
	                            )
	                        )
	                    ),
	                    'WhmcsProduct' => array('Tblproduct' => array('fields' => array('name', 'order', 'paytype'), 'order' => 'order ASC', 
	                            'Tblproductgroup',
	                            'Tblpricing' => array(
	                                'fields' => array('msetupfee', 'monthly')
	                            )
	                        )
	                    )
	                )
	            )
	        );
	}
	
	public function saveQuote($userDetails, $dids, $products, $quoteName, $data) {
		$quote['SavedQuote'] = array('user_id' => $userDetails['USERID'], 'name' => 'Q-'.$quoteName);
                
        if(empty($data['method']) || $data['method'] == 'checkout')
        	$quote = array_merge($quote['SavedQuote'], array('onetime_fee' => $data['onetime_fee'], 'total_price' => $data['total_price'], 'recurring_fee' => $data['recurring_fee']));
        
		foreach($products as $categoryKey => $category) {
			foreach($category as $key => $product) {
				$isPbx = is_array($product) ? true : 0;
                $isDid = (isset($dids[$key]) && !empty($dids[$key])) ? true : 0;
                $qty = is_array($product) ? $product['count'] : $product;
                $dataCenter = is_array($product) ? $product['datacenter'] : '';
                        
                $quote['WhmcsProduct'][] = array(
                	'product_id' => $key,
                	'quantity' => $qty,
                	'is_pbx' => $isPbx,
                	'is_did' => $isDid,
                	'data_center' => $dataCenter,
                	'purchased_numbers' => (isset($dids[$key])) ? json_encode($dids[$key]) : ''
                );
            }
         }
		
		return $this->saveAll($quote);
	}

	public function getSavedQuotes($userID) {
		return $this->find('all', array(
			'order' => 'id DESC',
			'conditions' => array(
				'user_id' => $userID
				)
			)
		);
	}
}
?>