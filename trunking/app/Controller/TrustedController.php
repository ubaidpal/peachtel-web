<?php

App::uses('AppController', 'Controller');

class TrustedController extends AppController {
    public $name = "Trusted";
    var $uses = array('Trusted');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $trusted = $this->Trusted->find('all');
        $this->set(compact('trusted'));
    }
    
    public function add() {
        if($this->request->data) {
            if($this->Trusted->save($this->request->data)) {
                $this->Session->setFlash(_("Trusted added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add Trusted."));
                $this->redirect('index');
            }
        }
    }
    
    public function edit($tid) {
        $trusted = $this->Trusted->findById($tid);
        
        if($this->request->data) {
            $this->Trusted->id = $tid;
            if($this->Trusted->save($this->request->data)) {
                $this->Session->setFlash(_("Changes saved."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index');
            }
        }
        
        $this->set(compact('trusted'));
    }
    public function delete($tid) {
        if($this->Trusted->delete($tid)) {
            $this->Session->setFlash(_("Trusted deleted."));
            $this->redirect('index');
        } else {
            $this->Session->setFlash(_("Failed to delete Trusted."));
            $this->redirect('index');
        }
    }
}

?>
