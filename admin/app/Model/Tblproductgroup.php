<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tblproductgroup extends AppModel{
    
    var $name = 'Tblproductgroup';
    var $actsAs = array('Containable');
    var $useTable = "tblproductgroups";
    var $useDbConfig = "whmcs";
    
    public $hasOne = array(
        'QbAdminCategory' => array(
            'className' => 'QbAdminCategory',
            'foreignKey' => 'wid'
        )
    );
    
    public $hasMany = array(
        'Tblproduct' => array(
            'className' => 'Tblproduct',
            'foreignKey' => 'gid'
        )
    );
    
    
    public function getWHMCScategories($pids = null, $cats = null) {
        return $this->find('all', array(
                'contain' => array(
                    'Tblproduct' => array('fields' => array('name', 'order', 'paytype'), 'order' => 'order ASC', 'conditions' => array('Tblproduct.id' => $pids),
                        'Tblpricing' => array('fields' => array('msetupfee', 'monthly'))
                    ), 
                    'QbAdminCategory' => array('fields' => array('id', 'description', 'visible', 'displayType', 'billType'))
                ),
                'order' => 'order ASC',
                'fields' => array('name'),
                'conditions' => array('Tblproductgroup.id' => $cats)
            )
        );
    }

    public function displayWHMCScategories() {
        return $this->find('all', array(
                'contain' => array(
                    'Tblproduct' => array('fields' => array('name', 'order', 'paytype'), 'order' => 'order ASC', 
                        'QbAdminProduct' => array('fields' => array('visible')),
                        'Tblpricing' => array('fields' => array('msetupfee', 'monthly'))
                    ), 
                    'QbAdminCategory' => array('fields' => array('id', 'description', 'visible', 'displayType', 'billType'))
                ),
                'order' => 'order ASC',
                'fields' => array('name')
            )
        );
    }
}
?>

