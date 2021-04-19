<?php

App::uses('AppController', 'Controller');

class TerminationGatewaysController extends AppController {
    public $name = "TerminationGateways";
    var $uses = array('TerminationGateway');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($vendor_id) {
        
        $termgateways = $this->TerminationGateway->find('all', array('conditions' => array('vendor_id' => $vendor_id), 'recursive' => -1));

        $this->set(compact('termgateways', 'vendor_id'));
        
    }
    
    public function add($vendor_id) {

        if($this->request->data) {
            if($this->TerminationGateway->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New vendor term. gateway successfully added."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to add vendor term. gateway."));
                $this->redirect('index/'.$vendor_id);
            }
        }
        $this->set(compact('vendor_id'));
    }
    
    public function edit($gw_id, $vendor_id) {
        $vendorTermGw = $this->TerminationGateway->findById($gw_id);
        $this->set(compact('vendorTermGw', 'vendor_id'));
        
        if($this->request->data) {
            $this->TerminationGateway->id = $gw_id;
            if($this->TerminationGateway->save($this->request->data)) {
                $this->Session->setFlash(_("Vendor term. gateway changes saved."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$vendor_id);
            }
        }
    }
    
    
    
    public function delete($gw_id, $vendor_id) {
        if($this->TerminationGateway->delete($gw_id)) {
            $this->Session->setFlash(_("Termination gateway successfully removed."));
            $this->redirect('index/'.$vendor_id);
        } else {
            $this->Session->setFlash(_("Failed to delete gateway."));
            $this->redirect('index/'.$vendor_id);
        }
    }
}

?>
