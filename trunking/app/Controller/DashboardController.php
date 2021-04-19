<?php

App::uses('AppController', 'Controller');

class DashboardController extends AppController {
    public $name = "Dashboard";
    var $uses = array('Customer', 'Cdr', 'CustomerVendor');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
    }
}

?>
