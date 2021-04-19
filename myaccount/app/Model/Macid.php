<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Macid extends AppModel{
    
    public $hasMany = array(
        'Phonedata' => array(
			'className' => 'Phonedata',
			'foreignKey' => 'MacID',
            'dependent' => true
		)
	);
}
?>
