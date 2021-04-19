<?php

App::uses('AppController', 'Controller');

class OriginationRoutesController extends AppController {
    public $name = "OriginationRoutes";
    var $uses = array('OriginationRoute', 'OrigRate');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($group_id) {
        
        $originationRoutes = $this->OriginationRoute->find('all', array('conditions' => array('customer_bg_id' => $group_id), 'recursive' => -1));
        $this->set(compact('originationRoutes', 'group_id'));
    }
    
    public function add($group_id) {
        $origRate = $this->OrigRate->find('list', array('fields' => array('id', 'descr')));
        
        
        if($this->request->data) {
            if($this->OriginationRoute->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New origination route successfully added."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to add origination route."));
                $this->redirect('index/'.$group_id);
            }
        }
        
        $this->set(compact('group_id', 'origRate'));
    }
    
    public function edit($route_id, $group_id) {
        
        $origRate   = $this->OrigRate->find('list', array('fields' => array('id', 'descr')));
        $origRoute  = $this->OriginationRoute->find('first', array('conditions' => array('id' => $route_id), 'recursive' => -1));
        
        if($this->request->data) {
            $this->OriginationRoute->id = $route_id;
            if($this->OriginationRoute->saveAll($this->request->data)) {
                $this->Session->setFlash(_("Origination route changes saved."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$group_id);
            }
        }
        
        $this->set(compact('group_id', 'origRate', 'origRoute'));
    }
    
    
    public function delete($orig_id, $group_id) {
        if($this->OriginationRoute->delete($orig_id)) {
            $this->Session->setFlash(_("Origination route successfully removed."));
            $this->redirect('/origination_routes/index/'.$group_id);
        } else {
            $this->Session->setFlash(_("Failed to delete origination route."));
            $this->redirect('/origination_routes/index/'.$group_id);
        }
    }
}

?>
