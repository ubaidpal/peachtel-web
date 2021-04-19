<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Zipcode extends AppModel{
    
    var $name = 'Zipcode';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";
    
    public $belongsTo = array(
		'PsState' => array (
			'className' => 'PsState',
			'foreignKey' => 'id_state'
		)
	);
    
    public $hasMany = array(
		'PhoneNumber' => array (
			'className' => 'PhoneNumber',
			'foreignKey' => 'zip_code_id'
		)
	);
}
?>