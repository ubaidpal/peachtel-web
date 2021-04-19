<?php

class PsCountryLang extends AppModel{
    
    var $name = 'PsCountryLang';
    var $actsAs = array('Containable');
    var $useDbConfig = "prestashop";
    var $useTable = "country_lang";
    var $primaryKey = "id_country";
    
    public $belongsTo = array(
		'PsCountry' => array(
			'className' => 'PsCountry',
			'foreignKey' => 'id_country'
		)
	);
}

?>