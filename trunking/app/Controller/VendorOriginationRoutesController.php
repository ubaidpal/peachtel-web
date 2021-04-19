<?php

App::uses('AppController', 'Controller');

class VendorOriginationRoutesController extends AppController {
    public $name = "VendorOriginationRoutes";
    var $uses = array('VendorOriginationRoute');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($vendor_id) {
        
        $origroutes = $this->VendorOriginationRoute->find('all', array('conditions' => array('vendor_id' => $vendor_id), 'recursive' => -1));

        $this->set(compact('origroutes', 'vendor_id'));
        
    }
    
    public function add($vendor_id) {

        if($this->request->data) {
            if($this->VendorOriginationRoute->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New vendor orig. route successfully added."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to add vendor orig. route."));
                $this->redirect('index/'.$vendor_id);
            }
        }
        $this->set(compact('vendor_id'));
    }
    
    public function edit($r_id, $vendor_id) {
        $vendorOrigR = $this->VendorOriginationRoute->findById($r_id);
        $this->set(compact('vendorOrigR', 'vendor_id'));
        
        if($this->request->data) {
            $this->VendorOriginationRoute->id = $r_id;
            if($this->VendorOriginationRoute->save($this->request->data)) {
                $this->Session->setFlash(_("Vendor orig. route changes saved."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$vendor_id);
            }
        }
    }
    
    
    
    public function delete($r_id, $vendor_id) {
        if($this->VendorOriginationRoute->delete($r_id)) {
            $this->Session->setFlash(_("Vendor successfully removed."));
            $this->redirect('index/'.$vendor_id);
        } else {
            $this->Session->setFlash(_("Failed to delete vendor."));
            $this->redirect('index/'.$vendor_id);
        }
    }
}

?>
