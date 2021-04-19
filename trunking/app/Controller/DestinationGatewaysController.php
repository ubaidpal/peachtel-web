<?php

App::uses('AppController', 'Controller');

class DestinationGatewaysController extends AppController {
    public $name = "DestinationGateways";
    var $uses = array('DestinationGateway');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($group_id) {
        
        $destgateways = $this->DestinationGateway->find('all', array('conditions' => array('customer_bg_id' => $group_id), 'recursive' => -1));

        $this->set(compact('destgateways', 'group_id'));
    }
    
    public function add($group_id) {
        if($this->request->data) {
            if($this->DestinationGateway->saveAll($this->request->data)) {
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
        $destGateway = $this->DestinationGateway->findById($gw_id);

        $this->set(compact('group_id', 'destGateway'));
        
        if($this->request->data) {
            $this->DestinationGateway->id = $gw_id;
            if($this->DestinationGateway->save($this->request->data)) {
                $this->Session->setFlash(_("Destination gateway changes saved."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$group_id);
            }
        }
    }
    
    
    
    public function delete($gw_id, $group_id) {
        if($this->DestinationGateway->delete($gw_id)) {
            $this->Session->setFlash(_("Source gateway successfully removed."));
            $this->redirect('index/'.$group_id);
        } else {
            $this->Session->setFlash(_("Failed to delete source gateway."));
            $this->redirect('index/'.$group_id);
        }
    }
}

?>
