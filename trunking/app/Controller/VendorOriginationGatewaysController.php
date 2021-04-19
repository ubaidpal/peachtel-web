<?php

App::uses('AppController', 'Controller');

class VendorOriginationGatewaysController extends AppController {
    public $name = "VendorOriginationGateways";
    var $uses = array('VendorOriginationGateway');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($vendor_id) {
        
        $origgateways = $this->VendorOriginationGateway->find('all', array('conditions' => array('vendor_id' => $vendor_id), 'recursive' => -1));

        $this->set(compact('origgateways', 'vendor_id'));
        
    }
    
    public function add($vendor_id) {

        if($this->request->data) {
            if($this->VendorOriginationGateway->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New vendor orig. gateway successfully added."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to add vendor orig. gateway."));
                $this->redirect('index/'.$vendor_id);
            }
        }
        $this->set(compact('vendor_id'));
    }
    
    public function edit($gw_id, $vendor_id) {
        $vendorOrigGw = $this->VendorOriginationGateway->findById($gw_id);
        $this->set(compact('vendorOrigGw', 'vendor_id'));
        
        if($this->request->data) {
            $this->VendorOriginationGateway->id = $gw_id;
            if($this->VendorOriginationGateway->save($this->request->data)) {
                $this->Session->setFlash(_("Vendor orig. gateway changes saved."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$vendor_id);
            }
        }
    }
    
    
    
    public function delete($gw_id, $vendor_id) {
        if($this->VendorOriginationGateway->delete($gw_id)) {
            $this->Session->setFlash(_("Vendor successfully removed."));
            $this->redirect('index/'.$vendor_id);
        } else {
            $this->Session->setFlash(_("Failed to delete vendor."));
            $this->redirect('index/'.$vendor_id);
        }
    }
}

?>
