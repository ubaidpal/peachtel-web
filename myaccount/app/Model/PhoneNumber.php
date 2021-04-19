<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PhoneNumber extends AppModel{
    
    var $name = 'PhoneNumber';
    var $actsAs = array('Containable');
    var $useDbConfig = "voiplion";
    
    public $belongsTo = array(
		'Zipcode' => array (
			'className' => 'Zipcode',
			'foreignKey' => 'zip_code_id'
		)
	);
}
?>