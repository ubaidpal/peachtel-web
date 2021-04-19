<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblorder extends AppModel {
    var $name = 'Tblorder';
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
