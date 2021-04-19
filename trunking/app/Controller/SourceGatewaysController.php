<?php

App::uses('AppController', 'Controller');

class SourceGatewaysController extends AppController {
    public $name = "SourceGateways";
    var $uses = array('SourceGateway');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($group_id) {
        
        $sourcegateways = $this->SourceGateway->find('all', array('conditions' => array('customer_bg_id' => $group_id), 'recursive' => -1));

        $this->set(compact('sourcegateways', 'group_id'));
    }
    
    public function add($group_id) {
        if($this->request->data) {
            if($this->SourceGateway->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New source gateway successfully added."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to add source gateway."));
                $this->redirect('index/'.$group_id);
            }
        }
        
        $this->set(compact('group_id'));
    }
    
    public function edit($gw_id, $group_id) {
        $sourceGateway = $this->SourceGateway->findById($gw_id);

        $this->set(compact('group_id', 'sourceGateway'));
        
        if($this->request->data) {
            $this->SourceGateway->id = $gw_id;
            if($this->SourceGateway->save($this->request->data)) {
                $this->Session->setFlash(_("Source gateway changes saved."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$group_id);
            }
        }
    }
    
    
    
    public function delete($gw_id, $group_id) {
        if($this->SourceGateway->delete($gw_id)) {
            $this->Session->setFlash(_("Source gateway successfully removed."));
            $this->redirect('index/'.$group_id);
        } else {
            $this->Session->setFlash(_("Failed to delete source gateway."));
            $this->redirect('index/'.$group_id);
        }
    }
}

?>
