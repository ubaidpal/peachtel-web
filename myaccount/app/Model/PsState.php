<?php

class PsState extends AppModel{
    
    var $name = 'PsState';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "state";
    var $primaryKey = "id_state";
    
    public $belongsTo = array(
		'PsCountry' => array(
			'className' => 'PsCountry',
			'foreignKey' => 'id_country'
		)
	);
    
    public $hasMany = array(
		'Zipcode' => array (
			'className' => 'Zipcode',
			'foreignKey' => 'state_id'
		)
	);

	public function getStates($country = null) {
		$condition = array();
		if($country) {
			$condition = array('id_country' => $country);
		}
		return $this->find('list', array(
			'conditions' => $condition,
			'fields' => array('iso_code', 'name'),
			'order' => array('name ASC')
			)
		);
	}

	public function getPhoneNumbers($data) {

        $val = $data['val'];
        $method = $data['method'];
        $condition1 = ($method == 'state') ? array('PsState.name LIKE' => "%$val%") : array();
        $condition2 = ($method == 'zip') ? array('Zipcode.code LIKE' => "%$val%") : array();
        
		return $this->find('all', array(
            'conditions' => $condition1,
            'order' => array('PsState.name' => 'ASC'),
            'contain' => array('Zipcode' => array('conditions' => $condition2, 'order' => array('Zipcode.code' => 'ASC'), 'PhoneNumber' => array('conditions' => array('is_available' => true, 'is_processed' => false))))
        ));
	}
}
?>
