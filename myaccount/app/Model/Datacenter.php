<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Datacenter extends AppModel{
    
    var $name = 'Datacenter';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";

    public $belongsTo = array(
		'QbAdminCategory' => array(
			'className' => 'QbAdminCategory',
			'foreignKey' => 'category_id'
		),
		'Tblproduct' => array(
			'className' => 'Tblproduct',
			'foreignKey' => 'product_id'
		),
	);
}
?>