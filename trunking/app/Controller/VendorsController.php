<?php

App::uses('AppController', 'Controller');

class VendorsController extends AppController {
    public $name = "Vendors";
    var $uses = array('CustomerVendor', 'RegionGroup');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $vendors = $this->CustomerVendor->find('all');
        
        $this->set(compact('vendors'));
    }
    
    public function add() {
        $regionGroup = $this->RegionGroup->find('list', array('fields' => array('id', 'descr')));
        if($this->request->data) {
            if($this->CustomerVendor->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New vendor successfully added."));
                $this->redirect('/');
            } else {
                $this->Session->setFlash(_("Failed to add vendor."));
                $this->redirect('/');
            }
        }
        
        $this->set(compact('regionGroup'));
    }
    
    public function edit($vendor_id) {
        $regionGroup = $this->RegionGroup->find('list', array('fields' => array('id', 'descr')));
        $vendor = $this->CustomerVendor->findById($vendor_id);
        $vendor_id = $vendor['CustomerVendor']['id'];
        $this->set(compact('vendor', 'regionGroup', 'vendor_id'));
        
        if($this->request->data) {
            $this->CustomerVendor->id = $vendor_id;
            if($this->CustomerVendor->save($this->request->data)) {
                $this->Session->setFlash(_("Vendor changes saved."));
                $this->redirect('/');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('/');
            }
        }
    }
    
    
    
    public function delete($gw_id, $group_id) {
        if($this->CustomerVendor->delete($gw_id)) {
            $this->Session->setFlash(_("Vendor successfully removed."));
            $this->redirect('/');
        } else {
            $this->Session->setFlash(_("Failed to delete vendor."));
            $this->redirect('/');
        }
    }
}

?>
