<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Zipcode extends AppModel{
    
    public $name = 'Zipcode';
    public $actsAs = array('Containable');
    public $useDbConfig = "voiplion";
    public $useTable = 'zipcodes';
    
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