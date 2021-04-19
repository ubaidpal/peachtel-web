<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblinvoice extends AppModel {
    var $name = 'Tblinvoice';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    public $hasMany = array(
		'Tblinvoiceitem' => array(
			'className' => 'Tblinvoiceitem',
			'foreignKey' => 'invoiceid'
		)
	);
    
    public $hasOne = array(
		'Tblorder' => array(
			'className' => 'Tblorder',
			'foreignKey' => 'invoiceid'
		)
	);
}
?>
