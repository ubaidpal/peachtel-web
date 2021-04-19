<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblinvoiceitem extends AppModel {
    var $name = 'Tblinvoiceitem';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    public $belongsTo = array(
		'Tblinvoice' => array(
			'className' => 'Tblinvoice',
			'foreignKey' => 'invoiceid'
		)
	);
}
?>
