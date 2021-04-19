<?php

class OriginationRouteCostDest extends AppModel{
    
    var $name = 'OriginationRouteCostDest';
    var $actsAs = array('Containable');
    var $useTable = "orig_route_cos_dest";
    var $useDbConfig = "postgres";
    var $primaryKey = 'orig_route_id';
    
    public $belongsTo = array(
		'OriginationRoute' => array(
			'className' => 'OriginationRoute',
			'foreignKey' => 'orig_route_id'
		)
	);
}

?>