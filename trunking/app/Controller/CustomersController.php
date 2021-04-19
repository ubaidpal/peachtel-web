<?php

App::uses('AppController', 'Controller');

class CustomersController extends AppController {
    public $name = "Customers";
    var $uses = array('User', 'Customer');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        
        $customers = $this->Customer->find('all');

        $this->set(compact('customers'));
    }
    
    public function add() {
        
        if($this->request->data) {
            if($this->Customer->saveAll($this->request->data)) {
                $this->Session->setFlash(_("Customer successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add customer."));
                $this->redirect('index');
            }
        }
        
    }
    
    public function edit($customer_id) {
        
        $customer = $this->Customer->findById($customer_id);
        $this->set(compact('customer'));
        
        if($this->request->data) {
            $this->Customer->id = $customer_id;
            if($this->Customer->save($this->request->data)) {
                $this->Session->setFlash(_("Customer successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add customer."));
                $this->redirect('index');
            }
        }
    }
    
    public function delete($customer_id) {
        if($this->Customer->delete($customer_id)) {
            $this->Session->setFlash(_("Customer successfully removed."));
            $this->redirect('index');
        } else {
            $this->Session->setFlash(_("Failed to delete added."));
            $this->redirect('index');
        }
    }
}

?>
