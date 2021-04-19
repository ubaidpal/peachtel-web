<?php

App::uses('AppController', 'Controller');

class SubscribersController extends AppController {
    public $name = "Subscribers";
    var $uses = array('Subscriber');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($group_id) {
        
        $subscribers = $this->Subscriber->find('all', array('conditions' => array('customer_bg_id' => $group_id), 'recursive' => -1));

        $this->set(compact('subscribers', 'group_id'));
    }
    
    public function add($group_id) {
        if($this->request->data) {
            if($this->Subscriber->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New subscriber successfully added."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to add subscriber."));
                $this->redirect('index/'.$group_id);
            }
        }
        
        $this->set(compact('group_id'));
    }
    
    public function edit($subs_id, $group_id) {
        $subscriber = $this->Subscriber->findById($subs_id);

        $this->set(compact('group_id', 'subscriber'));
        
        if($this->request->data) {
            $this->Subscriber->id = $subs_id;
            if($this->Subscriber->save($this->request->data)) {
                $this->Session->setFlash(_("Subscriber changes saved."));
                $this->redirect('index/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$group_id);
            }
        }
    }
    
    
    
    public function delete($gw_id, $group_id) {
        if($this->Subscriber->delete($gw_id)) {
            $this->Session->setFlash(_("Subscriber successfully removed."));
            $this->redirect('index/'.$group_id);
        } else {
            $this->Session->setFlash(_("Failed to delete subscriber."));
            $this->redirect('index/'.$group_id);
        }
    }
}

?>
