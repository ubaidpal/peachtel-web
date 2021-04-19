<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class WhmcsProduct extends AppModel{
    
    var $name = 'WhmcsProduct';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";

    public $belongsTo = array(
		'Tblproduct' => array(
			'className' => 'Tblproduct',
			'foreignKey' => 'product_id'
		)
	);
}
?>