<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblticket extends AppModel{
    
    var $name = 'Tblticket';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    
    public $belongsTo = array(
		'Tblticketdepartment' => array(
			'className' => 'Tblticketdepartment',
			'foreignKey' => 'did'
		)
	);
    
    public $hasMany = array(
		'Tblticketreply' => array(
			'className' => 'Tblticketreply',
			'foreignKey' => 'tid',
            'dependent' => true
		)
	);
}
?>

