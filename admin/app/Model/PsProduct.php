<?php

class PsProduct extends AppModel{
    
    var $name = 'PsProduct';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "product";
    var $primaryKey = "id_product";
    
    public $hasOne = array(
		'PsProductLang' => array(
			'className' => 'PsProductLang',
			'foreignKey' => 'id_product'
		),
        'PsImage' => array(
			'className' => 'PsImage',
			'foreignKey' => 'id_product'
		)
	);
	
	public function getSelectedDevices($dataId) {
		return $this->find('all', array(
	                'conditions' => array('PsProduct.id_product' => $dataId),
	                'fields' => array('DISTINCT id_product', 'price'),
	                'contain' => array (
	                    'PsProductLang' => array('fields' => array('name'))
	                )
	            ));
	}
}
?>
