<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblproduct extends AppModel{
    var $name = 'Tblproduct';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    public $hasOne = array(
		'Tblpricing' => array(
			'className' => 'Tblpricing',
			'foreignKey' => 'relid',
            'dependent' => true
		),
        'QbAdminProduct' => array(
			'className' => 'QbAdminProduct',
			'foreignKey' => 'wid',
            'dependent' => true
		),
	);
    
    public $belongsTo = array(
		'Tblproductgroup' => array(
			'className' => 'Tblproductgroup',
			'foreignKey' => 'gid'
		)
	);
	
	public $hasMany = array(
		'Datacenter' => array(
			'className' => 'Datacenter',
			'foreignKey' => 'product_id'
		),
	);
}
?>
