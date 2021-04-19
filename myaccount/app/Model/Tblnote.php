<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblnote extends AppModel{
    
    var $name = 'Tblnote';
    var $actsAs = array('Containable');
    var $useDbConfig = "whmcs";
    
    public $belongsTo = array(
		'Tbladmin' => array(
			'className' => 'Tbladmin',
			'foreignKey' => 'adminid',
            'dependent' => true
		)
	);
}
?>

