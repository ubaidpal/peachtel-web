<?php

class PsCartProduct extends AppModel{
    
    var $name = 'PsCartProduct';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "cart_product";
    
    public $belongsTo = array(
		'PsCart' => array(
			'className' => 'PsCart',
			'foreignKey' => 'id_cart'
		),
        'PsProduct' => array(
			'className' => 'PsProduct',
			'foreignKey' => 'id_product'
		),
	);
}

?>