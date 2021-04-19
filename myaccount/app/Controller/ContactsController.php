<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ContactsController extends AppController {
    public $uses = array('ContactMessage');
    
    public function beforeFilter() {
        
    }
    
    public function saveRequest() {
        
        if($this->request->data) {
            
            if($this->ContactMessage->save($this->request->data['Contact'])) {
                $this->redirect('/contact_us.html');
            } else {
                $this->redirect('/contact_us.html');
            }
        }
    }
}