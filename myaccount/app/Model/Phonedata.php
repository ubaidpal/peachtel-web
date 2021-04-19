<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Phonedata extends AppModel {

    
    public $belongsTo = array(
        'Macid' => array(
			'className' => 'Macid',
			'foreignKey' => 'MacID'
		)
	);
    
}
