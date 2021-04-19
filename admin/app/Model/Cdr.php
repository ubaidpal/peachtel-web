<?php

class Cdr extends AppModel{
    
    var $name = 'Cdr';
    var $actsAs = array('Containable');
    var $useTable = "cdr";
    var $useDbConfig = "postgres";
    
    public $belongsTo = array(
        'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id'
		),
        'BillingGroup' => array(
			'className' => 'BillingGroup',
			'foreignKey' => 'customer_bg_id'
		)
	);
    
    public function findSDateEDate($data) {
        $startTime  = date('Y-m-d H:i:s', strtotime($data['start']));
        $endTime    = date('Y-m-d H:i:s', strtotime($data['end']));
        
        $conditions = array(
            'Cdr.customer_id' => $data['cid'], 
            'AND' => array(
                'Cdr.start_time >=' => $startTime,
                'Cdr.end_time <='   => $endTime
            )
        );

        return $this->find('all', array('conditions' => $conditions, 'recursive' => -1));
    }
}