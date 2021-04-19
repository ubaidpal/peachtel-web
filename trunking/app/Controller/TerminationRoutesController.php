<?php

App::uses('AppController', 'Controller');

class TerminationRoutesController extends AppController {
    public $name = "TerminationRoutes";
    var $uses = array('TerminationRoute');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($vendor_id) {
        
        $termroutes = $this->TerminationRoute->find('all', array('conditions' => array('vendor_id' => $vendor_id), 'recursive' => -1));

        $this->set(compact('termroutes', 'vendor_id'));
        
    }
    
    public function add($vendor_id) {

        if($this->request->data) {
            if($this->TerminationRoute->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New vendor term. route successfully added."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to add vendor term. route."));
                $this->redirect('index/'.$vendor_id);
            }
        }
        $this->set(compact('vendor_id'));
    }
    
    public function edit($r_id, $vendor_id) {
        $termRoute = $this->TerminationRoute->findById($r_id);
        $this->set(compact('termRoute', 'vendor_id'));
        
        if($this->request->data) {
            $this->TerminationRoute->id = $r_id;
            if($this->TerminationRoute->save($this->request->data)) {
                $this->Session->setFlash(_("Vendor term. route changes saved."));
                $this->redirect('index/'.$vendor_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$vendor_id);
            }
        }
    }
    
    
    
    public function delete($r_id, $vendor_id) {
        if($this->TerminationRoute->delete($r_id)) {
            $this->Session->setFlash(_("Termination gateway successfully removed."));
            $this->redirect('index/'.$vendor_id);
        } else {
            $this->Session->setFlash(_("Failed to delete gateway."));
            $this->redirect('index/'.$vendor_id);
        }
    }
}

?>
