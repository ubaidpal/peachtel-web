<?php

class PsStockAvailable extends AppModel{
    
    var $name = 'PsStockAvailable';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "stock_available";
    var $primaryKey = "id_stock_available";
    
	public $belongsTo = array(
		'PsProduct' => array(
			'className' => 'PsProduct',
			'foreignKey' => 'id_product'
		)
	);
    
}
?>
