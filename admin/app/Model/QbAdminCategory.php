<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class QbAdminCategory extends AppModel{
    
    var $name = 'QbAdminCategory';
    var $actsAs = array('Containable');
    var $useTable = "QB_admin_category";
    var $useDbConfig = "voiplion";

    public $belongsTo = array(
		'QbAdminDisplayType' => array(
			'className' => 'QbAdminDisplayType',
			'foreignKey' => 'displayType'
		),
        'QbAdminBillType' => array(
			'className' => 'QbAdminBillType',
			'foreignKey' => 'billType'
		)
	);

	public $hasMany = array(
		'Datacenter' => array(
			'className' => 'Datacenter',
			'foreignKey' => 'category_id'
		),
	);
}
?>