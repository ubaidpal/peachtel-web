<?php

App::uses('AppController', 'Controller');

class CdrsController extends AppController {
    public $name = "Cdrs";
    var $uses = array('Cdr', 'Customer');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $this->paginate = array('limit' => 15);
        $cdrs           = $this->paginate('Cdr');
        $customersList  = $this->Customer->find('all', array('fields' => array('id', 'descr')));
        $this->set(compact('cdrs', 'customersList'));
    }
    
    public function cdr_filter() {
        
        $this->layout   = '';
        $this->paginate = array('limit' => 15);
        $conditions = array();
        
        if($this->request->data) {
            if(!empty($this->request->data['customer'])) {
                array_push($conditions, array('Cdr.customer_id' => $this->request->data['customer']));
            } else if(!empty($this->request->data['source'])) {
                array_push($conditions, array('Cdr.src LIKE' => '%' . $this->request->data['source'] . '%'));
            } else if(!empty($this->request->data['destination'])) {
                array_push($conditions, array('Cdr.dest LIKE' => '%' . $this->request->data['destination'] . '%'));
            }
            
        }
        
        $cdrs = $this->paginate('Cdr', $conditions);
        
        $this->set(compact('cdrs'));
    }
    
    public function view($cdr_id) {
        $cdr = $this->Cdr->find('first', array('conditions' => array('Cdr.id' => $cdr_id)));
        
        $this->set(compact('cdr'));
    }
    
    public function view_rating($cdr_id) {
        $cdr = $this->Cdr->find('first', array('conditions' => array('Cdr.id' => $cdr_id)));
        $this->set(compact('cdr'));
    }
}

?>
