<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblticketreply extends AppModel{
    
    var $name = 'Tblticketreply';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    
    public $belongsTo = array(
		'Tblticket' => array(
			'className' => 'Tblticket',
			'foreignKey' => 'tid',
            'dependent' => true
		)
	);
}
?>

