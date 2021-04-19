<?php

class PsCountry extends AppModel{
    
    var $name = 'PsCountry';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "country";
    var $primaryKey = "id_country";
    
    public $hasMany = array(
		'PsCountryLang' => array(
			'className' => 'PsCountryLang',
			'foreignKey' => 'id_country'
		),
        'PsState' => array(
			'className' => 'PsState',
			'foreignKey' => 'id_country'
		)
	);

	public function getCountries() {
		$countries = $this->find('all', array(
                'fields' => array('iso_code'),
                'order' => 'iso_code ASC',
                'contain' => array('PsCountryLang' =>  array('conditions' => array('id_lang' => 1), 'fields' => array('name')))
            )
        );

        $countryList = array();
        foreach($countries as $country) {
            $index = $country['PsCountry']['iso_code'];
            $value = $country['PsCountryLang'][0]['name'];
            $countryList[$index] = $value;
        }
        asort($countryList);

        return $countryList;
	}
}

?>