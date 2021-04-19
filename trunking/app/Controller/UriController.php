<?php

App::uses('AppController', 'Controller');

class UriController extends AppController {
    public $name = "Uri";
    var $uses = array('Uri');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $uris = $this->Uri->find('all');
        $this->set(compact('uris'));
    }
    
    public function add() {
        if($this->request->data) {
            $this->request->data['Uri']['last_modified'] = date('Y-m-d H:i:s');
            if($this->Uri->save($this->request->data)) {
                $this->Session->setFlash(_("Uri added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add Uri."));
                $this->redirect('index');
            }
        }
    }
    
    public function edit($uid) {
        $uri = $this->Uri->findById($uid);
        
        if($this->request->data) {
            $this->Uri->id = $uid;
            $this->request->data['Uri']['last_modified'] = date('Y-m-d H:i:s');
            if($this->Uri->save($this->request->data)) {
                $this->Session->setFlash(_("Changes saved."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index');
            }
        }
        
        $this->set(compact('uri'));
    }
    public function delete($uid) {
        if($this->Uri->delete($uid)) {
            $this->Session->setFlash(_("Uri deleted."));
            $this->redirect('index');
        } else {
            $this->Session->setFlash(_("Failed to delete Uri."));
            $this->redirect('index');
        }
    }
}

?>
